import netteForms from 'nette-forms';
import naja from 'naja';
import { Toast } from 'bootstrap';

window.Nette = netteForms;
netteForms.initOnLoad();

document.addEventListener('DOMContentLoaded', () => naja.initialize());

Array.from(document.querySelectorAll('.toast'))
	.forEach(toastNode => new Toast(toastNode, {
		autohide: true,
		delay: 15 * 1000,
	}).show())