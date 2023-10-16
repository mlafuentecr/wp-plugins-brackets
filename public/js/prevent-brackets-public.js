/*-----------------------------------------------------------------------------------*/
/*  Get commet  JOB CAREER
/*-----------------------------------------------------------------------------------*/
document.readyState !== 'loading' ? startBracket() : document.addEventListener('DOMContentLoaded', () => setTimeout(startBracket(), 3000));
let side = 'L';
let bracket = '';
let bracketScroll = '';
let menuSeries = '';
let menuLinks = '';
const sizes = { sm: 576, md: 768, lg: 992, xl: 1200 };

function startBracket() {
	console.log('starting brackets');

	if (document.querySelector('.bracket-mobile')) {
		//check if Im on desktop but block is not fulwidth
		checkWidth();
		startMobileMenu();
	}
}
function checkWidth() {
	const bracketMobile = document.querySelector('.bracket-mobile');
	const bracket = document.querySelector('.bracket_container');

	if (bracket.offsetWidth < sizes.lg) {
		bracketMobile.classList.add('swithMobile');
		bracket.classList.add('swithMobile');
	}
}
function startMobileMenu() {
	const menuMobile = document.querySelector('.bracket-mobile');
	const logos = menuMobile.querySelectorAll('.logo');
	bracket = document.querySelector('.bracket_container');
	bracketScroll = bracket.querySelector('.scroll-wrap');
	menuSeries = document.querySelector('.series');
	menuLinks = document.querySelectorAll('.serie');
	//LISTEN top logo click
	logos.forEach(function (link) {
		link.addEventListener('click', () => toggleLogo(link, logos));
	});

	//Listen for menu Click
	menuLinks.forEach(function (link) {
		link.addEventListener('click', () => menuClick(link));
	});

	//bracketScroll.addEventListener('scroll', (e) =>  console.log(bracketScroll.scrollLeft))
}

function menuClick(link) {
	console.log(link.dataset.type, ' menu click ', side);
	if (side === 'L') {
		switch (link.dataset.type) {
			case 'group-1':
				ScrollToDiv('group-1');
				toggleMenuMobile('group-1');
				break;

			case 'group-2':
				ScrollToDiv('group-2');
				console.log('group-2', side);
				toggleMenuMobile('group-2');
				// bracketScroll.scrollTo(165, 0);
				break;

			case 'group-3':
				ScrollToDiv('group-3');
				console.log('group-3', side);
				toggleMenuMobile('group-3');
				break;

			case 'group-4':
				ScrollToDiv('group-4');
				console.log('group-4', side);
				toggleMenuMobile('group-4');
				break;

			default:
				ScrollToDiv('group-5');
				toggleMenuMobile('group-5');
		}
	} else {
		switch (link.dataset.type) {
			case 'group-1':
				ScrollToDiv('group-1_R');
				toggleMenuMobile('group-1');
				break;

			case 'group-2':
				ScrollToDiv('group-2_R');
				toggleMenuMobile('group-2');
				// bracketScroll.scrollTo(165, 0);
				break;

			case 'group-3':
				ScrollToDiv('group-3_R');
				toggleMenuMobile('group-3');
				break;

			case 'group-4':
				ScrollToDiv('group-4_R');
				toggleMenuMobile('group-4');
				break;

			default:
				ScrollToDiv('group-5');
				toggleMenuMobile('group-5');
		}
	}
}

function toggleLogo(logo, logos) {
	//remove all active
	logos.forEach(logo => logo.classList.remove('active'));
	//activate clicked one
	logo.classList.add('active');
	//scroll depending of the logo
	if (logos[0].classList.contains('active')) {
		side = 'L';
		ScrollToDiv('group-1'); //reset pos
		menuSeries.style.flexDirection = 'row';
	} else {
		side = 'R';
		ScrollToDiv('group-1_R'); //reset pos
		menuSeries.style.flexDirection = 'row-reverse';
	}
	toggleMenuMobile('group-1');
}
function resetMenuLinks() {
	menuLinks.forEach(link => link.classList.remove('active'));
}
function toggleMenuMobile(divId) {
	resetMenuLinks();
	const linkId = `[data-type=${divId}]`;
	const link = document.querySelector(linkId);
	link.classList.add('active');
}

function ScrollToDiv(divId) {
	const elem = document.getElementById(divId);
	(cPos = elem.getBoundingClientRect()), elem.scrollIntoView({ behavior: 'smooth', block: 'start', inline: 'center' });
}
