
document.addEventListener('DOMContentLoaded', function () {
    //variables lightbox
        //on selectionne toutes les images converties ensuite en tableau, en excluant les images de lien lightbox et des publications
        const images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
        const lightboxPrev = document.querySelector('.lightbox__prev');
        const lightboxNext = document.querySelector('.lightbox__next');
        let currentImageIndex = 0;

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
        if (contactSingle) {
            contactSingle.onclick = function() {
            modal.style.display = "block";}
        }
        //else {console.log("btn_single_photo non trouvé");}

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

 /****************filtres**********************/
  /*filtre catégorie*/   
     const selectCat = document.getElementById('category-filter');
     let valueCat = '';
     selectCat.onchange = function () {
       valueCat = selectCat.value;
        console.log(valueCat); // Affichage de la valeur catégorie dans la console
    }

    /*filtre format*/   
    const selectForm = document.getElementById('format-filter');
    let valueForm = '';
    selectForm.onchange = function () {
        valueForm = selectForm.value;
        console.log(valueForm); // Affichage de la valeur fomrat dans la console
    }

    /*filtre trier par*/   
    const selectTrier = document.getElementById('sort-filter');
    let valueTrier = '';
    selectTrier.onchange = function () {
        valueTrier = selectTrier.value;
    console.log(valueTrier); // Affichage de la valeur trier dans la console
    }

    /*affichage des photos en fonction des filtres*/


    //     // Écouteur d'événement pour le formulaire de filtre
    // document.querySelector('form').addEventListener('submit', function(event) {
    //     event.preventDefault(); // Empêche le rechargement de la page
        
    //     // Récupère la valeur sélectionnée dans la liste déroulante
    //     var category = document.querySelector('select[name="category"]').value;
        
    //     // Effectue une requête AJAX pour récupérer les photos filtrées
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', 'photo-galerie.php', true);
    //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState === 4 && xhr.status === 200) {
    //             // Met à jour le contenu du conteneur des photos avec les photos filtrées
    //             document.getElementById('photo-container').innerHTML = xhr.responseText;
    //         }
    //     };
    //     xhr.send('category=' + category);
    // });

    /****************lightbox**********************/
    /*images des liens vers lighbox et photo-publi*/

    var lightboxLinks = document.querySelectorAll('.photo_simple .link_lightbox');
    var menuLinks = document.querySelectorAll('.photo_simple .link_publi');

    lightboxLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var image = this.querySelector('img');
            var url = image.getAttribute('src');
            var lightbox = new Lightbox(url);
        });
    });

    menuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var postUrl = this.getAttribute('href');
            window.location.href = postUrl;
            console.log (postUrl);
        });
    });

    /*ouverture et fermeture de la lightbox*/
    class Lightbox {
        //pour initialiser la fonctionnalité de la lightbox
        static init() {
        //on sélectionne les liens lightbox
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

            //pour passer d'une image à l'autre
                //déclaration de variables
        //    ChangeImage(sens) {
        //     currentImageIndex += sens;
        //     if (currentImageIndex > sl){}
                

        //     }

    }

    Lightbox.init();



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

});