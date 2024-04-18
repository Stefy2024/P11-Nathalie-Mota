document.addEventListener('DOMContentLoaded', function () {
// recupere la modal
var modal = document.getElementById('myModal');

// recupere l'id de "contact"
var contact = document.getElementById("menu-item-46");

// recupere l'élément span pour fermer (la croix)
var span = document.getElementsByClassName("close")[0];

// au click, on remplace display none par display block (ouvre le formulaire)
contact.onclick = function() {
    modal.style.display = "block";
}

// au click sur la croix, on ferme (display=none)
span.onclick = function() {
    modal.style.display = "none";
}

// au click hors du cadre du formulaire, on ferme (display=none)
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
});