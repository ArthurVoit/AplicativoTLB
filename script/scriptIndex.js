function move() {
    var elem = document.getElementById("barra");
    var width = 5;
    var id = setInterval(frame, 10);
    
    function frame() {
        if (width >= 100) {
            clearInterval(id);
            window.location.href = 'public/Login.html';
        } else {
            width++;
            elem.style.width = width + '%';
            elem.innerHTML = width + '%';
        }
    }
}
