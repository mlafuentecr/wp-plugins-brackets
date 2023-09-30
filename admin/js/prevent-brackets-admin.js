
// Wait for the DOM to be ready
document.readyState !== 'loading' ? startBracket() : document.addEventListener('DOMContentLoaded', startBracket);

function startBracket() {
    const selectLeagueElements = document.querySelectorAll("[data-name='select_a_league']");
    
    if (selectLeagueElements.length > 0) {
        listenForChange();
    }
}

function listenForChange() {
    const apiCallBtns = document.querySelectorAll('#apiCall_btn');

    apiCallBtns.forEach(btn => {
        const parentWithClass = btn.closest(".acf-fields");
        const select = parentWithClass.querySelector("[data-name='select_a_league'] select");
        btn.addEventListener("click", () => saveListOfPlayers(select.value));
    });
}

function saveListOfPlayers(select) {
 
     const ajax_url = ajax_plugin_obj.ajax_url;


    // jQuery.ajax({
    //     type: 'POST',
    //     url: ajax_url,
    //     //dataType: 'html',
    //     data: {
    //       action: 'saveACF',
    //     },
    //     success: function (res) {
    //         console.log(res);
    //     }
    //   });
//  

console.log(select)

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
    if( xhr.readyState === 4 && xhr.status === 200 ) {
        console.log( xhr.responseText );
    }
    }

    xhr.open( 'POST', ajax_url, true );
    xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    const params = `action=saveACF&leagueSelected=${select}`;
    xhr.send( params );
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