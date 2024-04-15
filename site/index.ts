function set(id: string, text: string) {
	const element = document.getElementById(id)
	if(!element) {
		return
	}
	
	if(text.length === 0) {
		element.innerHTML = ""
	} else {
		element.innerHTML = text
	}
}

fetch('../scripts/get_qotd.php')
	.then(response => response.text())
	.then(text => set('quote', '"' + text.trim() + '"'))
	.catch(()=>console.error("Couldn't get qotd"))

fetch('../scripts/get_visitor_count.php')
    .then(response => response.text())
    .then(text => set('visitor_count', 'You are visitor # ' + text + '.'))
	.catch(()=>console.error("Couldn't get visitor count"))
