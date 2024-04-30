
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
class Lightbox{
    static init(){
const links = document.querySelectorAll('a[href$=".jpeg"], a[href$=".jpg"], a[href$=".png"] ')
        .forEach(link => link.addEventListener('click', e=>
        {
            e.preventDefault()
            new Lightbox(e.currentTarget.getAttribute('href'))
        }))
    }
    /*url=url de l'image dans constructor()*/
    constructor(url){
        const element = this.buildDOM(url)
        document.body.appendChild(element)
    }

/*ferme la lightbox*/
close (e) {
    e.preventDefault()
    this.element.classList.add('fadeOut')
    window.setTimeout(() => {
        this.element.parentElement.removeChild(this.element)
    }, 500)
}

    /* buildDOM va retourner un élément html*/
    buildDOM(url){
        const dom = document.createElement('div')
        dom.classList.add('lightbox')
        dom.innerHTML=~`<button class="lightbox__close"></button>
        <button class="lightbox__next"></button>
        <button class="lightbox__prev"></button>
        <div class="lightbox__container">
            <img src="wp-content/themes/NathalieMota/assets/images/nathalie-0.jpeg" alt="test"></div>`
            dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this))
        return dom
    }
}

Lightbox.init()

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