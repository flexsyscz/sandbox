import {Toast} from "bootstrap";

export default function() {
	Array.from(document.querySelectorAll('.toast'))
		.forEach(toastNode => new Toast(toastNode, {
			autohide: true,
			delay: 15 * 1000,
		}).show())
}