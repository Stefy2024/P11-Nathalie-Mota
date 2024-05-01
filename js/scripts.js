
document.addEventListener('DOMContentLoaded', function () {
    //MODAL
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
// même code pour le bouton contact de la page single-photo-publi
var contactSingle = document.getElementById('btn_single_photo');
contactSingle.onclick = function() {
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



/*lightbox*/
class Lightbox {
    constructor(url) {
        this.element = this.buildDOM(url);
        document.body.appendChild(this.element);
        this.element.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this));
    }

    close(e) {
        e.preventDefault();
        this.element.classList.add('fadeOut');
        window.setTimeout(() => {
            this.element.remove();
        }, 500);
    }
    

    buildDOM(url) {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `
            <button class="lightbox__close"></button>
            <button class="lightbox__next"></button>
            <button class="lightbox__prev"></button>
            <div class="lightbox__container">
                <img src="${url}" alt="Image en pleine taille">
            </div>
        `;
    }
}

// Attachez un gestionnaire d'événements au clic sur chaque image miniature
const links = document.querySelectorAll('a[href$=".jpeg"], a[href$=".jpg"], a[href$=".png"]');
links.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        new Lightbox(e.currentTarget.getAttribute('href'));
    });
});


});








/*bouton charger plus*/
jQuery(document).ready(function($) {
    $('#load-more-btn').on('click', function() {
        $.ajax({
            type: 'POST',
            url: $("#ajaxurl").val(), // Utiliser la variable globale ajaxurl de WordPress
            data: {
                action: 'load_more_photos',
                offset: $('.photo_flex img').length
            },
            success: function(response) {
                $('.photo_flex').append(response);
            }
        });
    });
});