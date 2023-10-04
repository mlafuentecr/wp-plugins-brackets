
// Wait for the DOM to be ready

if (document.readyState !== 'loading') { setTimeout(() => {startBracket();}, 1000); } else {
    document.addEventListener('DOMContentLoaded', () => {setTimeout(() => {startBracket();}, 1000);});
}


function startBracket() {
    const selectLeagueElements = document.querySelectorAll("[data-name='bracket']");
    if (selectLeagueElements.length > 0) { 
        ListenLeagueChange(); 
        ListenBtnShowTeams(); 
    }
}

function ListenLeagueChange() {
    const select = document.querySelectorAll("[data-name='select_a_league']");
    select.forEach(item => {
        //const leagueSelected = jQuery( '[data-name="select_a_league"] .acf-input select' );
        
        const e = item.querySelector('.acf-input select');
        const leagueSelected = e.options[e.selectedIndex].value;

        const parent = item.parentNode.closest('.acf-fields');
        const shortcut = parent.querySelector("[data-name='bracket_shorcut']");
        console.log(shortcut)
        console.log(leagueSelected)
        shortcut.innerHTML = `Use this code: [ bracket_${leagueSelected} ]`

        //    jQuery(document).on('change', leagueSelected, function(e) {
        //     //Donde estoy buscar todos los teams y meterle la data
        //     //makeAfetch(leagueSelected.val());
        // });
        //change shortcut
        //data-name="bracket_shorcut"
    });
}
//acf-btn acf-publish ShowListOfTeams
function ListenBtnShowTeams() {
    const infoBtn = document.querySelectorAll(".ShowListOfTeams");
    const lista_de_teams = document.querySelectorAll("[data-name='lista_de_teams']");
    //hide list
    lista_de_teams.forEach((item) => item.style.display = "none");


    infoBtn.forEach((item) => item.addEventListener('click', ()=>{
       
        const parent = item.closest(".acf-fields");
        const list_of_teams = parent.querySelector(".list_of_teams");

        const league = parent.querySelector('[data-name="select_a_league"] .acf-input select');
        const json_of_teams = parent.querySelector('.json_of_teams .acf-input textarea');
        
      if( item.innerHTML === "Show List of Teams"){
        item.innerHTML = "Hide List of Teams";
        list_of_teams.style.display = "block"
        makeAfetch(league.value, list_of_teams, json_of_teams)
       
      } else{
        item.innerHTML = "Show List of Teams"
        list_of_teams.style.display = "none"
      }

    }))
}


function saveListOfPlayers(leagueSelected) {
 
    if(leagueSelected == 'Select an Option') return;
    console.log(leagueSelected, 'doing ajax request')
     const ajax_url = ajax_plugin_obj.ajax_url;

    fetch(ajax_url, {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': 'true',
        },
    })
        .then(response => response.json())
        .then(teamsData => {
            console.log(teamsData.data);
            const nationalLeagueTeams = teamsData.data.filter(function (team) {
                return {
                    teamShortName: team.teamShortName,
                    teamID: team.teamID,
                };
            });
    
            teamsListDiv.innerHTML = ' ';
            json_of_teams.innerHTML = ' ';
            teamsListDiv.innerHTML += '<h1> Click Update Btn to save it </h1>';
            nationalLeagueTeams.forEach(function (team) {
                teamsListDiv.innerHTML += `${team.teamID} : ${team.teamShortName} <br>`;
            });
            json_of_teams.innerHTML = JSON.stringify(teamsData.data);
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });

}

function makeAfetch(league, teamsListDiv, json_of_teams){
 
       
	if(league === 'Select an Option') return
    console.log('start fetching' )
 

	fetch('https://api.sportsanddata.com/api/v1/GetLeagueTeams?leagueName=' + league, {
		method: 'GET',
		mode: 'cors'
	})
	.then(response => response.json())
	.then(teamsData =>{
        console.log(teamsData.data)
        const nationalLeagueTeams  = teamsData.data.filter(function(team) {   
            return {
            teamShortName: team.teamShortName,
            teamID: team.teamID
        }; });
      
		teamsListDiv.innerHTML =' ';
        json_of_teams.innerHTML=' ';
        teamsListDiv.innerHTML+= '<h1> Click Update Btn to save it </h1>'
        nationalLeagueTeams.forEach(function(team) {
            teamsListDiv.innerHTML+= `${team.teamID} : ${team.teamShortName} <br>`;
        });
        
        console.log(json_of_teams,'saving ', JSON.stringify(teamsData.data)) 
        json_of_teams.innerHTML =  JSON.stringify(teamsData.data);
        
        
		//sendToPHP(data)
	})
	.catch(error => {
		teamsListDiv.innerHTML = 'Data error'
		// setTimeout(() => teamsListDiv.innerHTML = '', 2000);
		console.log('fetching prev-brack-admin🚫', error)
	})
}