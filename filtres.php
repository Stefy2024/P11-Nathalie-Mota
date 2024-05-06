<div class="filters">
    <div class="left-filters">
            <select id="category-filter">
                <option value="">Catégories</option>
                <?php

                // Récupérer catégories ACF et les afficher dans la liste déroulante

                $categories = get_terms('categorie'); 
                foreach ($categories as $category) {
                    var_dump ( $category->slug);
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>

            <select id="format-filter">
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
                <option value="alldate">trier par</option>
                <option value="lastdate">à partir des plus récentes</option>
                <option value="firstdate">à partir des plus anciennes</option>
                
            </select>
    </div>
</div>