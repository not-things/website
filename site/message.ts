fetch('./scripts/messages/get_message.php')
    .then((response) => response.text())
    .then((text) => {
        const list = document.getElementById('list')
        if (list == null) {
            throw new Error("list is null")
        }
        for (let msg of text.split('\n')) {
            if (msg.length == 0) {
                break
            }
            const entry = document.createElement("li")
            entry.appendChild(document.createTextNode(msg))
            list.appendChild(entry)
        }
    }
    )