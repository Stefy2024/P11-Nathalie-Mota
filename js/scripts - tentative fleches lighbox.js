
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
        // Méthode statique pour initialiser la fonctionnalité de la lightbox
        static init() {
            const links = Array.from(document.querySelectorAll('.photo_simple .link_lightbox'));
            if (links.length > 0) {
                links.forEach((link, i) => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const imageSrc = link.previousElementSibling.getAttribute('src'); // Récupère l'URL de l'image
                        new Lightbox(imageSrc, i, links.length);
                    });
                });
            }
        }

        // Constructeur de la classe qui prend 'url de l'image à afficher en paramètre
        constructor(url, index, totalImages) {      
            this.currentIndex = index;
            this.totalImages = totalImages;
            this.buildDOM(url);
            this.bindEvents();
        }

        // Méthode pour lier les événements aux éléments de la lightbox (clic sur la croix)
        bindEvents() {
            const closeButton = document.querySelector('.lightbox__close');
            const prevButton = document.querySelector('.lightbox__prev');
            const nextButton = document.querySelector('.lightbox__next');

            closeButton.addEventListener('click', this.close.bind(this));
            prevButton.addEventListener('click', this.showPreviousImage.bind(this));
            nextButton.addEventListener('click', this.showNextImage.bind(this));
        }

        // Méthode pour afficher l'image précédente
        showPreviousImage() {
            this.currentIndex = (this.currentIndex - 1 + this.totalImages) % this.totalImages;
            this.updateImage();
        }

        // Méthode pour afficher l'image suivante
        showNextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.totalImages;
            this.updateImage();
        }

        // Méthode pour fermer la lightbox
        close(e) {
            e.preventDefault();
            const lightboxElement = document.querySelector('.lightbox');
            lightboxElement.classList.add('fadeOut');
            window.setTimeout(() => {
                lightboxElement.remove();
            }, 500);
        }
        
        // Méthode pour construire l'interface de la lightbox
        buildDOM(url) {
            const container = document.querySelector('.lightbox__container');
            if (!container) {
                console.error("Container is null");
                return;
            }
        
            container.innerHTML = ''; // Efface le contenu précédent
            const img = document.createElement('img');
            img.src = url;
            container.appendChild(img);
        
            const lightbox = document.querySelector('.lightbox');
            if (lightbox) {
                lightbox.classList.add('fadeIn');
            } else {
                console.error("Lightbox element is null");
            }
        }

        // Méthode pour mettre à jour l'image affichée dans la lightbox
        updateImage() {
            const images = Array.from(document.querySelectorAll('.photo_simple .link_lightbox img'));
            if (images.length > 0 && this.currentIndex >= 0 && this.currentIndex < images.length) {
                const newImageUrl = images[this.currentIndex].getAttribute('src');
                const img = document.querySelector('.lightbox__container img');
                if (img) {
                    img.src = newImageUrl;
                }
            }
        }
    }

Lightbox.init();



/*************bouton charger plus*****************/

    jQuery(document).ready(function($) {
        $('#load-more-btn').on('click', function() {
            $.ajax({
                type: 'POST',
                url: jQuery("#ajaxurl").val(), // Utiliser la variable globale ajaxurl de WordPress
                data: {
                    action: 'load_more_photos',
                    offset: jQuery('.photo_flex img').length
                },
                success: function(response) {
                    jQuery('.photo_flex').append(response);
                }
            });
        });
    });
});