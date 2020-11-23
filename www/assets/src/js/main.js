import naja from 'naja'
import toastLoader from "./toastLoader";

document.addEventListener('DOMContentLoaded', () => naja.initialize())
naja.snippetHandler.addEventListener('afterUpdate', (event) => {
	if (event.detail.snippet.id === 'snippet--flashes') {
		toastLoader()
	}
})

toastLoader()