
document.addEventListener('DOMContentLoaded', function () {
    /*********************MODAL*******************/
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
if (contactSingle) {contactSingle.onclick = function() {
    modal.style.display = "block";
}
}else {console.log("btn_single_photo non trouvé");}

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



/****************lightbox**********************/
/*images des liens vers lighbox et photo-publi*/

var lightboxLinks = document.querySelectorAll('.photo_simple .link_lightbox');
var menuLinks = document.querySelectorAll('.photo_simple .link_publi');

lightboxLinks.forEach(function(link) {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    var image = this.parentNode.querySelector('img');
    var url = image.getAttribute('src');
    var lightbox = new Lightbox(url);
  });
});

menuLinks.forEach(function(link) {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    var postUrl = this.parentNode.getAttribute('href');
    window.location.href = postUrl;
  });
});

/*ouverture et fermeture de la lightbox*/
class Lightbox {
    //pour initialiser la fonctionnalité de la lightbox
     static init() {
        //on selectionne toutes les images converties ensuite en tableau
         const images = document.querySelectorAll('.photo_simple img')
         const links = document.querySelectorAll('.photo_simple .link_lightbox')
        //on ajoute un écouteur d'évènements de click à chaque élément
         links.forEach((link, i)=> link.addEventListener('click', (e)=> {
            e.preventDefault()
            console.log(i);
            const imageSrc = images[i].getAttribute('src');
            new Lightbox(imageSrc);
         }))
     }

 //constructeur de la classe qui prend 'url de l'image à afficher en paramètre
    constructor(url) {      
         this.buildDOM(url);
         this.bindEvents();
    }

    //pour fermer la lighbox, bindEvents() va servir à lier les évènements aux éléments dela lightbox (clic sur croix)
    bindEvents() {
        const closeButton = document.querySelector('.lightbox__close');
        if (closeButton) {
            closeButton.addEventListener('click', this.removeFadeIn.bind(this));
        }
    }
//pour supprimer la classe fadeIn
    removeFadeIn() {
        const lightboxElement = document.querySelector('.lightbox');
        lightboxElement.classList.remove('fadeIn');
    }


    close(e) {
        e.preventDefault();
        this.element.classList.add('fadeIn');
        window.setTimeout(() => {
            this.element.remove();
        }, 500);
    }
    
    buildDOM(url) {
        
        const img = document.createElement('img');
        img.src= url;
        let lb =document.querySelector('.lightbox__container img');
        lb.src=url;
        document.querySelector('.lightbox').classList.add('fadeIn');
      
    }
}

Lightbox.init();
});


/*************bouton charger plus*****************/

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