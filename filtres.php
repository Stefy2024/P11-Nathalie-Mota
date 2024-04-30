<div class="filters">
    <div class="left-filters">
            <select id="category-filter" onChange="getcategory(this.value);">
                <option value="">Catégories</option>
                <?php

                // Récupérer catégories ACF et les afficher dans la liste déroulante

                $categories = get_terms('categorie'); 
                foreach ($categories as $category) {
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>

            <select id="format-filter" onChange="getformat(this.value);">
                <option value="">Formats</option>
                <?php
                
                // Récupérer formats ACF et les afficher dans la liste déroulante

                $formats = get_terms('format'); 
                foreach ($formats as $format) {
                    echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                }
                ?>
            </select>
    </div>
    <div class="right-filters">
            <select id="sort-filter">
                <option value="date">Trier par date</option>
                <option value="title">Trier par titre</option>
                
            </select>
    </div>
</div>