
/*-----------------------------------------------------------------------------------*/
/*  Get commet  JOB CAREER
/*-----------------------------------------------------------------------------------*/
document.readyState !== 'loading' ? startBracket() : document.addEventListener('DOMContentLoaded', () => setTimeout(startBracket(), 3000));
let side='L'
let bracket 			= ''
let bracketScroll = ''
let menuSeries		= ''
let menuLinks			= ''

function startBracket(){
		console.log('starting brackets')
	if(document.querySelector('.bracket-mobile')){
		startMobileMenu()
	}
}
function startMobileMenu(){
	const menuMobile 	= document.querySelector('.bracket-mobile')
	const logos 			= menuMobile.querySelectorAll('.logo')
	bracket 					= document.querySelector('.bracket-mlb');
	bracketScroll 		= bracket.querySelector('.scroll-wrap');
	menuSeries 				= document.querySelector('.series');
	menuLinks 				= document.querySelectorAll('.serie');
		//LISTEN top logo click
	logos.forEach(function(link){
		link.addEventListener('click', ()=>toggleLogo(link, logos))
	})

	//Listen for menu Click
	menuLinks.forEach(function(link){
		link.addEventListener('click', ()=>menuClick(link))
	})


	//bracketScroll.addEventListener('scroll', (e) =>  console.log(bracketScroll.scrollLeft))
}


// let timer;
// //console.log(bracketScroll.scrollLeft )
// const debounce = function (scroll) {
// 	const messageText = isInViewport(box) ;
// 	clearTimeout(timer);
// 	timer = setTimeout(function () {
// 			console.log(messageText, 'messageText')
// 	}, 50)
// }

function menuClick(link){
	console.log(link.dataset.type, ' menu click ',side)
	 if(side === 'L'){
		switch (link.dataset.type) {
			case 'wildcard':
				ScrollToDiv('wildcard')
				toggleMenuMobile('wildcard')
				break;

				case 'division':
					ScrollToDiv('division')
					console.log('division',side)
					toggleMenuMobile('division')
				// bracketScroll.scrollTo(165, 0);
				break;

				case 'championship':
				ScrollToDiv('championship')
				console.log('championship',side)
				toggleMenuMobile('championship')
				break;
				
			default:
				ScrollToDiv('worldseries')
				toggleMenuMobile('worldseries')
		}
			}else{
				switch (link.dataset.type) {
					case 'wildcard':
						ScrollToDiv('wildcard_R')
						toggleMenuMobile('wildcard')
						break;

						case 'division':
							ScrollToDiv('division_R')
							toggleMenuMobile('division')
						// bracketScroll.scrollTo(165, 0);
						break;

						case 'championship':
						ScrollToDiv('championship_R')
						toggleMenuMobile('championship')
						break;
						
					default:
						ScrollToDiv('worldseries')
						toggleMenuMobile('worldseries')
				}
			}
}

function toggleLogo(logo, logos){
		//remove all active
		logos.forEach((logo)=>logo.classList.remove("active"))
		//activate clicked one
		logo.classList.add('active')
		//scroll depending of the logo
		if(logos[0].classList.contains("active")){
			side='L'
			ScrollToDiv('wildcard') //reset pos
			menuSeries.style.flexDirection = 'row';
		}else{
			side='R'
			ScrollToDiv('wildcard_R') //reset pos
			menuSeries.style.flexDirection = 'row-reverse';
		}
		toggleMenuMobile('wildcard')
}
function resetMenuLinks(){
	menuLinks.forEach((link)=>link.classList.remove("active"))
}
function toggleMenuMobile(divId){
			resetMenuLinks()
			const linkId 	= `[data-type=${divId}]`;
			const link 		= document.querySelector(linkId)
			link.classList.add('active')
}
 
   
function ScrollToDiv(divId){
	const elem = document.getElementById(divId)
	cPos = elem.getBoundingClientRect(), 
	elem.scrollIntoView({ behavior: "smooth", block: "start", inline: "center" });

}