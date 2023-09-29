
document.readyState !== 'loading' ? startBracket() : document.addEventListener('DOMContentLoaded', () => startBracket());
function startBracket(){

		if(document.querySelector("[data-name='select_a_league']") ){
			listenForChange()
			}
		
		
}

function listenForChange (){
	//LISTEN ON CHANGEacf-input
	const mySelect = document.querySelector("[data-name='select_a_league'] > .acf-input  select ")
	console.log(mySelect,  'mySelect')
	mySelect.addEventListener("onchange", ()=>console.log('xxxxx'));

}


function makeAfetch(){
	 // Make an AJAX request to trigger the PHP function
	 fetch(ajaxurl, {
		method: 'POST',
		headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: 'action=my_admin_ajax_action&param1=value1&param2=value2',
})
		.then(response => response.json())
		.then(data => {
				// Handle the AJAX response
				console.log(data);
		})
		.catch(error => {
				console.error('Error:', error);
		});
}


// function makeAfetch(league){
// 	if(league === 'Select an Option') return
// 	const infoDiv = document.querySelector('.info')
// 	infoDiv.innerHTML = 'Fetching Data'
// 	console.log('start fetching')
// 	fetch('https://api.sportsanddata.com/api/v1/GetLeagueTeams?leagueName=' + league, {
// 		method: 'GET',
// 		mode: 'cors' // Ensure CORS is enabled
// 	})
// 	.then(response => response.json())
// 	.then(data =>{
// 		infoDiv.innerHTML = 'Data loaded'
// 		setTimeout(() => infoDiv.innerHTML = '', 2000);
// 		console.log('data from fetch', data)
// 		//sendToPHP(data)
// 	})
// 	.catch(error => {
// 		infoDiv.innerHTML = 'Data error'
// 		setTimeout(() => infoDiv.innerHTML = '', 2000);
// 		console.log('fetching prev-brack-admin🚫', error)
// 	})
// }