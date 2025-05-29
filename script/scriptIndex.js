const move = () => {
    var elem = document.getElementById("barra");
    var width = 0;
    var id = setInterval(frame, 1);
    
    function frame() {
        if (width >= 100) {
            clearInterval(id);
            window.location.href = 'public/Login.html';
        } else {
            width += 5;
            elem.style.width = width + '%';
            elem.innerHTML = width + '%';
        }
    }
}