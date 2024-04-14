function set(id: string, text: string) {
	if(text.length === 0) {
		document.getElementById(id).innerHTML = null
	} else {
		document.getElementById(id).innerHTML = text
	}
}

fetch('../scripts/get_qotd.php')
	.then(response => response.text())
	.then(text => set('quote', '"' + text.trim() + '"'))

fetch('../scripts/get_visitor_count.php')
    .then(response => response.text())
    .then(text => set('visitor_count', text + '.'))