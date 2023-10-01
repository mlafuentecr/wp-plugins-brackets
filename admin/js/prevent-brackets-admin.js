
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
        const leagueSelected = jQuery( '[data-name="select_a_league"] .acf-input select' );
           jQuery(document).on('change', leagueSelected, function(e) {
            //Donde estoy buscar todos los teams y meterle la data
            //makeAfetch(leagueSelected.val());
        });
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
        const info = parent.querySelector("[data-name='lista_de_teams']");
        const league = parent.querySelector('[data-name="select_a_league"] .acf-input select');
        const json_of_teams = parent.querySelector('.json_of_teams .acf-input textarea');
        
      if( item.innerHTML === "Show List of Teams"){
        item.innerHTML = "Hide List of Teams";
        info.style.display = "block"
        console.log(league.value)
        makeAfetch(league.value, info, json_of_teams)
      } else{
        item.innerHTML = "Show List of Teams"
        info.style.display = "none"
      }

    }))
}


//[data-key="field_ID"] .acf-input select'
function saveListOfPlayers(leagueSelected) {
 

    if(leagueSelected == 'Select an Option') return;
    console.log(leagueSelected)
     const ajax_url = ajax_plugin_obj.ajax_url;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if( xhr.readyState === 4 && xhr.status === 200 ) {
            console.log( xhr.responseText );
            //location.reload();
        }
    }

    xhr.open( 'POST', ajax_url, true );
    xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    const params = `action=saveACF&leagueSelected=${leagueSelected}`;
    xhr.send( params );
}

function makeAfetch(league, teamsListDiv, json_of_teams){
 
   
	if(league === 'Select an Option') return
    console.log('start fetching',json_of_teams)
 

	fetch('https://api.sportsanddata.com/api/v1/GetLeagueTeams?leagueName=' + league, {
		method: 'GET',
		mode: 'cors' // Ensure CORS is enabled
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
        json_of_teams.innerHTML =  JSON.stringify(teamsData.data);
        
        
		//sendToPHP(data)
	})
	.catch(error => {
		teamsListDiv.innerHTML = 'Data error'
		// setTimeout(() => teamsListDiv.innerHTML = '', 2000);
		console.log('fetching prev-brack-admin🚫', error)
	})
}