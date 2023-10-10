
// Wait for the DOM to be ready

if (document.readyState !== 'loading') { setTimeout(() => {startBracket();}, 1000); } else {
    document.addEventListener('DOMContentLoaded', () => {setTimeout(() => {startBracket();}, 1000);});
}


function startBracket() {
    //console.log('starting admin js')
    const selectLeagueElements = document.querySelectorAll("[data-name='create_a_bracket']");
    if (selectLeagueElements.length > 0) { 
        ListenLeagueChange(); 
        ListenBtnShowTeams(); 
    }
}

function ListenLeagueChange() {
    const select = document.querySelectorAll("[data-name='select_a_league']");
    //console.log(select, 'select')
    select.forEach(item => {
        const selection         = item.querySelector('[selected=selected]');
        const leagueSelected    = selection.innerHTML;
        const parent            = item.parentNode.closest('.acf-fields');
        const shortcut          = parent.querySelector(".bracket_shorcut");
        shortcut.innerHTML      = `Use this code: [bracket_${leagueSelected.toLowerCase()}]`
    });
}
//acf-btn acf-publish ShowListOfTeams
function ListenBtnShowTeams() {
    const infoBtn = document.querySelectorAll(".ShowListOfTeams");
    const lista_de_teams = document.querySelectorAll("[data-name='lista_de_teams']");
    //hide list
    lista_de_teams.forEach((item) => item.style.display = "none");

    //console.log(infoBtn, 'btn foundxx')

    infoBtn.forEach((item) => item.addEventListener('click', ()=>{
       console.log('btn list click')
        const parent = item.closest(".acf-fields");
        const list_of_teams = parent.querySelector(".list_of_teams");

        const league = parent.querySelector('[data-name="select_a_league"] .acf-input select');
        const jsonAcf = parent.querySelector('[data-name="lista_de_teams_json"]');
        const json_of_teams = parent.querySelector('.json_of_teams .acf-input textarea');
              console.log(json_of_teams, 'json_of_teams****')

      if( item.innerHTML === "Show List of Teams" || item.innerHTML === "Populate Teams"){
        item.innerHTML = "Hide List of Teams";
        list_of_teams.style.display = "block"
        jsonAcf.style.display = "block"
        makeAfetch(league.value, list_of_teams, json_of_teams)
       
      } else{
        item.innerHTML = "Populate Teams"
        list_of_teams.style.display = "none"
        jsonAcf.style.display = "none"
      }

    }))
}


function saveListOfPlayers(leagueSelected) {
 
    if(leagueSelected == 'Select an Option') return;
    //console.log(leagueSelected, 'doing ajax request')
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
            //console.log(teamsData.data);
            const nationalLeagueTeams = teamsData.data.filter(function (team) {
                return {
                    teamShortName: team.teamShortName,
                    teamID: team.teamID,
                };
            });
    
            teamsListDiv.innerHTML = ' ';
            json_of_teams.innerHTML = ' ';
            teamsListDiv.innerHTML += '<h1> Click ( update bracket) Btn to populate teams and logos </h1>';
            teamsListDiv.innerHTML += '<p> this list should be paste it in acf if its not working </p>';
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
    //console.log('start fetching' )
 

	fetch('https://api.sportsanddata.com/api/v1/GetLeagueTeams?leagueName=' + league, {
		method: 'GET',
		mode: 'cors'
	})
	.then(response => response.json())
	.then(teamsData =>{
        //console.log(teamsData.data)
        const nationalLeagueTeams  = teamsData.data.filter(function(team) {   
            return {
            teamShortName: team.teamShortName,
            teamID: team.teamID
        }; });
      
		teamsListDiv.innerHTML =' ';
        json_of_teams.innerHTML=' ';
        teamsListDiv.innerHTML+= '<h1> Click update bracket btn to save it </h1>'
        teamsListDiv.innerHTML += '<p> this list should be paste it in acf if its not working </p>';
        teamsListDiv.innerHTML+= `Select a team <br>`;
        nationalLeagueTeams.forEach(function(team) {
            teamsListDiv.innerHTML+= `${team.teamID} : ${team.teamShortName} <br>`;
        });
        
        //console.log(json_of_teams,'saving ', JSON.stringify(teamsData.data)) 
        json_of_teams.innerHTML =  `${JSON.stringify(teamsData.data)}`;
       
	})
	.catch(error => {
		teamsListDiv.innerHTML = 'Data error'
		// setTimeout(() => teamsListDiv.innerHTML = '', 2000);
		//console.log('fetching prev-brack-admin🚫', error)
	})
}