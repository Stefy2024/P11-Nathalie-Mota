
document.addEventListener('DOMContentLoaded', function () {
    //variables lightbox
        //on selectionne toutes les images converties ensuite en tableau, en excluant les images de lien lightbox et des publications
        let images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
        let currentImageIndex = 0;
        let page=1;

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
    //remplissage du label référence sur le formulaire de contact de single-photo-publi.php
    jQuery(document).ready(function($) {
        // Lorsqu'on ouvre la modal, définit la valeur du champ 'Ref. photo'
        $('.open-modal').on('click', function() {
            var photoReference = $(this).data('reference'); // Récupère la référence stockée dans l'attribut data-reference
            $('#myModal').find('input[name="your-subject"]').val(photoReference);
        });
    
        // Ferme la modal et réinitialise le champ lorsque l'utilisateur clique sur 'x'
        $('.close').on('click', function() {
            $('#myModal').find('input[name="your-subject"]').val('');
        });
    });

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
        page=1;
        showfilter(false, page);
    }

    /*filtre format*/   
    const selectForm = document.getElementById('format-filter');
    let valueForm = '';
    selectForm.onchange = function () {
        valueForm = selectForm.value;
        console.log(valueForm); // Affichage de la valeur fomrat dans la console
        page=1;
        showfilter(false, page); 
    }

    /*filtre trier par*/   
    const selectTrier = document.getElementById('sort-filter');
    let valueTrier = '';
    selectTrier.onchange = function () {
        valueTrier = selectTrier.value;
        console.log(valueTrier); // Affichage de la valeur trier dans la console
        page=1;
        showfilter(false, page);   
    }
    
   
    //const selects = document.querySelectorAll('.filters select');
  /*ajpout effet survol filtres*/
    // // Fonction pour réinitialiser le style des options
    // function resetOptionsStyle(select) {
    //     Array.from(select.options).forEach(option => {
    //         option.style.backgroundColor = '';
    //         option.style.color = '';
    //     });
    // }
    
    // // Ajoutez un écouteur d'événements pour chaque select
    // selects.forEach(select => {
    //     select.addEventListener('mouseover', (event) => {
    //         // Réinitialisez le style de toutes les options
    //         resetOptionsStyle(select); // Passez 'select' au lieu de 'select.options'
    
    //         // Appliquez le style uniquement à l'option survolée
    //         if (event.target.tagName === 'OPTION' && select.selectedIndex !== 0) {
    //             event.target.style.backgroundColor = '#e00000';
    //             event.target.style.color = 'white';
    //         }
    //     });
    
    //     select.addEventListener('mouseout', (event) => {
    //         // Réinitialisez le style lorsque la souris quitte l'option
    //         resetOptionsStyle(select); // Passez 'select' au lieu de 'select.options'
    //     });
    // });

    /*Bouton charger plus*/
    const loadMoreBtn = document.getElementById('load-more-btn');
    loadMoreBtn.addEventListener('click', function () {
        page++;
        showfilter(true, page);
    })
    

    /****************lightbox**********************/
    /*images des liens vers lighbox et photo-publi*/


    const lightboxLinks = document.querySelectorAll('.photo_simple .link_lightbox');
    var menuLinks = document.querySelectorAll('.photo_simple .link_publi');

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
                console.log('tityiti');
                const imageSrc = images[i].getAttribute('src');
                new Lightbox(src_image, images, index, reference, category);
            }))
        }

        //constructeur de la classe qui prend 'url de l'image à afficher en paramètre
        constructor(url, images, index, reference, category) {
            console.log('constructor');
            this.url = url;
            this.images = images;
            this.index = index;
            this.reference = reference;
            this.category = category;
            this.buildDOM(url, reference, category);
            this.bindEvents();
        }

        //pour fermer la lighbox, bindEvents() va servir à lier les évènements aux éléments dela lightbox (clic sur croix)
        bindEvents() {
            const closeButton = document.querySelector('.lightbox__close');
            const nextButton = document.querySelector('.lightbox__next');
            const prevButton = document.querySelector('.lightbox__prev');
           
            if (closeButton) {
                closeButton.addEventListener('click', this.removeFadeIn.bind(this));
            }
            if (nextButton) {
                nextButton.addEventListener('click', this.nextImage.bind(this));
            }
            if (prevButton) {
                prevButton.addEventListener('click', this.prevImage.bind(this));
            }
        }
        //pour naviguer entre les images
        nextImage() {console.log(this.index);
            this.index = (this.index + 1) % this.images.length; // % pour ne pas dépasser le nombre existant dans l'index, pour faire une boucle
            this.updateImage(); //mettre à jour image
            this.updateInfo(); //mettre à jour réf et catégorie
        }
    
        prevImage() {
            this.index = (this.index - 1 + this.images.length) % this.images.length;
            this.updateImage();
            this.updateInfo();
        }
    
        updateImage() {
            const imageElement = document.querySelector('.lightbox__container img');
            imageElement.src = this.images[this.index].getAttribute('src');
        }

        updateInfo() {
            const photoElement = this.images[this.index].closest('.photo_simple');
            const reference = photoElement.getAttribute('data-reference');
            const category = photoElement.getAttribute('data-category');
            const referenceElement = document.querySelector('#lightbox_reference');
            referenceElement.textContent = reference;
            const categoryElement = document.querySelector('#lightbox_category');
            categoryElement.textContent = category;
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
        
        buildDOM(url, reference, category) {
            
            const img = document.createElement('img');
            img.src= url;
            let lb =document.querySelector('.lightbox__container img');
            lb.src=url;
            document.querySelector('.lightbox').classList.add('fadeIn');
            //construction de la partie réf et catégorie de la photo sur lightbox
            const referenceElement = document.createElement('p');
            referenceElement.textContent = reference;
            referenceElement.id = 'lightbox_reference';
            referenceElement.className = 'lightbox_ref';
            const categoryElement = document.createElement('p');
            categoryElement.textContent = category;
            categoryElement.id = 'lightbox_category';
            categoryElement.className = 'lightbox_cat';

            const infoContainer = document.querySelector('.lightbox__container .lightbox_info');
            //pour supprimer les éléments précédents (éviter de reprendre les info de la photo précédente visionnée)
            while (infoContainer.firstChild) {
                infoContainer.removeChild(infoContainer.firstChild);
            }
            // pour ajouter les nouveaux éléments de paragraphe
            infoContainer.appendChild(referenceElement);
            infoContainer.appendChild(categoryElement);
        }
    }

    Lightbox.init = function() {
        const container = document.querySelector('.photo_flex');
        container.addEventListener('click', (e) => {
            const link = e.target.closest('.photo_simple .link_lightbox');
            const image_selec = e.target.closest('.photo_simple').querySelector('img:not(.overlay img)');
            const src_image= image_selec.getAttribute('src');
            console.log('Sapin de noel');
            console.log(src_image);
            let index='';
            images.forEach((image, i) => {
                //console.log(`URL of image ${i}:`, image.getAttribute('src'));
                if (image.getAttribute('src')==src_image){
                    index=i;
                }
            });
            //console.log('link'+ link);
            //console.log('index'+ index);
            if (link) {
               // console.log('rentrer');
                e.preventDefault();
                const photoElement = e.target.closest('.photo_simple');
                const image_selec = photoElement.querySelector('img:not(.overlay img)');
                const src_image = image_selec.getAttribute('src');
                const reference = photoElement.getAttribute('data-reference');
                const category = photoElement.getAttribute('data-category');
                //const image = link.parentElement.previousElementSibling;
                new Lightbox(src_image, images, index, reference, category);
            }
        });
    }


   Lightbox.init();

    /*************bouton charger plus et lightbox*****************/

    (function($) {
        'use strict';


        window.showfilter = function showfilter(chargerPlus, page) {
          
            var categorieSelection = valueCat;
            var formatSelection = valueForm;
            var ordre = valueTrier;

            $.ajax({
                type: 'POST',
                url: 'wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                    action: 'filter',
                    categorieSelection: categorieSelection,
                    formatSelection: formatSelection,
                    orderDirection: ordre,
                    page: page,
                },
                success: function(resultat) {
                    //console.log(resultat);
                    if (chargerPlus) {
                        $('.photo_flex').append(resultat);
                        images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
                    } else {
                        $('.photo_flex').html(resultat);
                        images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //console.warn(resultat);
                    console.log('Erreur Ajax: ' + textStatus);
                }
            });
       
    }})(jQuery);

});
