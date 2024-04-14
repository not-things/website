fetch('../scripts/get_visitor_count.php')
    .then(response => response.text())
    .then(text => document.getElementById('visitor_count').innerHTML = text)