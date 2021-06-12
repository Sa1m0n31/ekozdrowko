<?php
get_header();
?>

<span class="fbc-sklep">
<?php echo do_shortcode( '[flexy_breadcrumb]'); ?>
</span>

<main class="sklep">
    <menu class="sklepMenu">
        <h3 class="sklepMenu__header sklepMenu__heahder--second">
            Szukaj wg produktu
        </h3>
        <div class="sklepMenu__search m-bottom30">
            <?php echo do_shortcode('[fibosearch]'); ?>
        </div>

        <h3 class="sklepMenu__header" onclick="showCategories()">
            Kategorie produktów

            <button class="sklepMenu__mobileBtn">
                <img class="sklepMenu__mobileBtn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/arrow-down.png'; ?>" alt="arrow" />
            </button>
        </h3>
        <?php
            wp_nav_menu(array('menu' => "Produkty"));
        ?>

        <h3 class="sklepMenu__header sklepMenu__header--second" onclick="showProducenci()">
            Szukaj wg producenta

            <button class="sklepMenu__mobileBtn">
                <img class="sklepMenu__mobileBtn__img sklepMenu__mobileBtn__img--producenci" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/arrow-down.png'; ?>" alt="arrow" />
            </button>
        </h3>
        <div class="sklepMenu__search sklepMenu__search--noPadding">
            <?php
                wp_nav_menu(array('menu' => 'Producenci'));
            ?>
        </div>
    </menu>
    <main class="sklepMain">
        <?php

        $term = get_queried_object();

        if( !empty( $term ) && !is_wp_error( $term ) ) {
            echo do_shortcode('[products category="' . $term->slug . '" per_page="15" limit="15" columns="3" paginate="true"]');
        } else {
            echo do_shortcode('[products per_page="15" limit="15" columns="3" paginate=true]');
        }
        ?>


    </main>
</main>

<?php
get_footer();
?>
