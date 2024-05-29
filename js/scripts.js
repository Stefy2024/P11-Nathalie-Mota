// le code est ajouté une fois tout le DOM chargé
document.addEventListener('DOMContentLoaded', function () {
    //variables lightbox
        //selecton de toutes les images (converties en tableau), en excluant les images de lien lightbox et des publications
        let images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
        let currentImageIndex = 0;
        let page=1;

        /*********************MODAL*******************/
    // recupere la modal
    var modal = document.getElementById('myModal');
    // recupere l'élément "contact"
    var contact = document.getElementById("menu-item-46");
    // recupere l'élément span pour fermer (la croix)
    var span = document.getElementsByClassName("close")[0];

    // au click sur contact, on remplace display none par display block (ouvre le formulaire)
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
            // Récupère la référence stockée dans data-reference
            var photoReference = $(this).data('reference'); 
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

    /************partie JS mobile*****************/

    const burger = document.querySelector('.burger_menu');
    const nav = document.querySelector('#navigation');
    const closeIcon = document.querySelector('.close_icon');
    // Lors du clic sur le menu burger, on affiche le menu et on cache le menu burger
    burger.addEventListener('click', function() {
        nav.classList.toggle('is-active');
        closeIcon.style.display = 'block'; // Affiche la croix
        burger.style.display = 'none'; // Cache le menu burger
    });
    // Lors du clic sur la croix, on cache le menu et on affiche le menu burger
    closeIcon.addEventListener('click', function() {
        nav.classList.remove('is-active');
        closeIcon.style.display = 'none'; // Cache la croix
        burger.style.display = 'block'; // Affiche le menu burger
    });

    /****************lightbox**********************/
    /*images des liens vers lighbox et photo-publi*/

    var menuLinks = document.querySelectorAll('.photo_simple .link_publi');
    // Pour chaque lien, on ajoute un écouteur d'événements de clic
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
            const links = document.querySelectorAll('.link_lightbox')
            //on ajoute un écouteur d'évènements de click à chaque élément
            links.forEach((link, i)=> link.addEventListener('click', (e)=> {
               // console.log(i);
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
                //image suivante
        nextImage() {console.log(this.index);
            this.index = (this.index + 1) % this.images.length; // % pour ne pas dépasser le nombre existant dans l'index, pour faire une boucle
            this.updateImage(); //mettre à jour image
            this.updateInfo(); //mettre à jour réf et catégorie
        }
                //image précédente
        prevImage() {
            this.index = (this.index - 1 + this.images.length) % this.images.length;
            this.updateImage();
            this.updateInfo();
        }
                //chargement photo avec ajout de src    
        updateImage() {
            const imageElement = document.querySelector('.lightbox__container img');
            imageElement.src = this.images[this.index].getAttribute('src');
        }
                //chargement des info de la photo
        updateInfo() {
            const photoElement = this.images[this.index].closest('.photo_simple');
            const reference = photoElement.getAttribute('data-reference');
            const category = photoElement.getAttribute('data-category');
            const referenceElement = document.querySelector('#lightbox_reference');
            referenceElement.textContent = reference;
            const categoryElement = document.querySelector('#lightbox_category');
            categoryElement.textContent = category;
        }
        //pour supprimer la classe fadeIn- rendre la lightbox visible
        removeFadeIn() {
            const lightboxElement = document.querySelector('.lightbox');
            lightboxElement.classList.remove('fadeIn');
        }
        //pour ajouter la classe fade-in- faire disparaitre la lightbox
        close(e) {
            e.preventDefault();
            this.element.classList.add('fadeIn');
            window.setTimeout(() => {
                this.element.remove();
            }, 500);
        }
        //pour construire la partie du DOM correspondante
        buildDOM(url, reference, category) {
            //cration d'un nouvel élément image
            const img = document.createElement('img');
            img.src= url;
            let lb =document.querySelector('.lightbox__container img');
            lb.src=url;
            //ajout de la classe fade-in à lightbox (je la fais disparaitre)
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
            //pour supprimer les éléments précédents (pour éviter de reprendre les info de la photo précédente visionnée)
            while (infoContainer.firstChild) {
                infoContainer.removeChild(infoContainer.firstChild);
            }
            // pour ajouter les nouveaux éléments de paragraphe
            infoContainer.appendChild(referenceElement);
            infoContainer.appendChild(categoryElement);
        }
    }
    //conditions pour initialiser la lightbox
    Lightbox.init = function() {

        // au niveau de la photo principale dans single-photo-publi.php
            if (document.querySelector('.photo-lightbox')) {
                //ajout de l'évènement au click
                const container = document.querySelector('.photo-lightbox');
                container.addEventListener('click', (e) => {
                    const link = e.target.closest('.photo_alone .link_lightbox');
                   const image_selec = e.target.closest('.photo_alone').querySelector('img:not(.overlay img)');
                   const src_image= image_selec.getAttribute('src');
                   console.log(src_image);
                   let index='';
                   images.forEach((image, i) => {
                       //console.log(`URL of image ${i}:`, image.getAttribute('src'));
                       if (image.getAttribute('src')==src_image){
                           index=i;
                       }
                   });

                   if (link) {
                       console.log('rentrer');
                       e.preventDefault();
                       const photoElement = e.target.closest('.photo_alone');
                       const image_selec = photoElement.querySelector('img:not(.overlay img)');
                       const src_image = image_selec.getAttribute('src');
                       const reference = photoElement.getAttribute('data-reference');
                       const category = photoElement.getAttribute('data-category');
                       new Lightbox(src_image, images, index, reference, category);
                   }
               });    
            } 
        //au niveau de photo-galerie:photo "vous aimerez aussi" dans single-photo-publi.php et photo front-page.php
            if (document.querySelector('.photo-autre-lightbox')){
                const container = document.querySelector('.photo-autre-lightbox');
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
                   if (link) {

                       e.preventDefault();
                       const photoElement = e.target.closest('.photo_simple');
                       const image_selec = photoElement.querySelector('img:not(.overlay img)');
                       const src_image = image_selec.getAttribute('src');
                       const reference = photoElement.getAttribute('data-reference');
                       const category = photoElement.getAttribute('data-category');
                       new Lightbox(src_image, images, index, reference, category);
                   }
               });    
            }
        }


   Lightbox.init();

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
    
/*************bouton charger plus*****************/
    //récupère le bouton "load more"
    const loadMoreBtn = document.getElementById('load-more-btn');
    //ajout d'un écouteur d'évènement sur le bouton
    loadMoreBtn.addEventListener('click', function () {
        // Incrémentation de la page
        page++;
        // Appel de la fonction showfilter avec chargerPlus à true
        showfilter(true, page);
    });
    //définition de la fonction showfilter
    (function($) {
        'use strict';

        window.showfilter = function showfilter(chargerPlus, page) {
          
            var categorieSelection = valueCat;
            var formatSelection = valueForm;
            var ordre = valueTrier;
          // Appel Ajax pour récupérer les données filtrées
            $.ajax({
                type: 'POST',
                url: 'wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                    action: 'filter',
                    nonce:filterAjax.nonce,
                    categorieSelection: categorieSelection,
                    formatSelection: formatSelection,
                    orderDirection: ordre,
                    page: page,
                },
                // Si chargerPlus est vrai, on ajoute le résultat à la fin de .photo_flex
                success: function(resultat) {
                   
                    if (chargerPlus) {
                        $('.photo_flex').append(resultat);
                        images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
                    // Sinon, on remplace le contenu de .photo_flex par le résultat
                    } else {
                        $('.photo_flex').html(resultat);
                        images = document.querySelectorAll('.photo_simple img:not(.img_lightbox):not(.img_publi)');
                    }
                },
                // En cas d'erreur, on affiche un message dans la console
                error: function(xhr, textStatus, errorThrown) {
                
                    console.log('Erreur Ajax: ' + textStatus);
                }
            });  
       
    }})(jQuery);
});
