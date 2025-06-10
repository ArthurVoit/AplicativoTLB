function toggleMenu() {
    var menu = document.getElementById("menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

document.addEventListener("click", function(event) {
    var menu = document.getElementById("menu");
    var button = document.querySelector(".nav-button");

    if (menu.style.display === "block" && !menu.contains(event.target) && !button.contains(event.target)) {
        menu.style.display = "none";
    }
});
