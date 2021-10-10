<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wptime-plugin-preloader"></div>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div class="container">
            <!-- MENU -->
            <menu class="topMenu">
                <div class="topMenu__logo">
                    <a href="<?php echo home_url(); ?>">
                        <img class="topMenu__logo__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/zdrowko-logo.png'; ?>" alt="logo" />
                    </a>
                </div>

                <!-- Desktop -->
                <ul class="topMenu__menu">
                    <?php
                    function sortByCategoryName($a, $b) {
                        if($a > $b) return 1;
                        else return -1;
                    }

                    $categories = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0] );

                    for($i=0; $i<sizeof($categories); $i++) {
                        if(($categories[$i]->name !== 'Najlepiej sprzedawane')&&($categories[$i]->name !== 'Uncategorized')&&($categories[$i]->name !== 'Nowości')&&($categories[$i]->name !== 'Bez kategorii')&&($categories[$i]->name !== 'Promocje')) {
                            ?>

                            <li class="menuItem">
                                <a onmouseover="menuHover()" class="menuItem__main" href="<?php echo 'https://ekozdrowko.pl/product-category/' . $categories[$i]->slug; ?>"><?php echo $categories[$i]->name; ?></a>
                                <div class="menuItem__subcategoriesContainer">
                                    <span class="menuItem__space"></span>

                                    <div class="menuItem__subcategoriesSubcontainer">
                                        <ul class="menuItem__subcategories">
                                            <?php
                                            $subcategories = get_product_subcategories_list($categories[$i]->slug);
                                            usort($subcategories, "sortByCategoryName");
                                            for($j=0; $j<sizeof($subcategories); $j++) {
                                                ?>
                                                <li class="menuSubcategoryItem"><?php echo $subcategories[$j]; ?></li>

                                                <?php
                                            }
                                            ?>
                                        </ul>

                                        <?php
                                        $thumbnail_id = get_term_meta( $categories[$i]->term_id, 'thumbnail_id', true );

                                        // get the image URL
                                        $image = wp_get_attachment_url( $thumbnail_id );
                                        ?>

                                        <div class="categoryImageWrapper">
                                            <img class="categoryImage" src="<?php echo $image; ?>" alt="kategoria-produktow" />
                                        </div>
                                    </div>
                                </div>

                                <img class="menuItem__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/chevron_down.svg'; ?>" alt="arrow" />
                            </li>

                    <?php

                        }
                    }

                    ?>

                </ul>

                <div class="topMenu__right">
                    <a class="topMenu__right__item" href="<?php echo get_page_link(get_page_by_title('Koszyk')->ID); ?>">
                        <img class="topMenu__right__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/shopping-basket.svg'; ?>" alt="koszyk" />
                        <h2 class="topMenu__right__header">
                            Koszyk
                        </h2>
<!--                        <h3 class="topMenu__cartCounter">-->
<!--                            --><?php
//                                echo WC()->cart->get_cart_contents_count();
//                            ?>
<!--                        </h3>-->
                    </a>
                    <a class="topMenu__right__item" href="<?php echo get_page_link(get_page_by_title('Moje konto')->ID); ?>">
                        <img class="topMenu__right__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/user.svg'; ?>" alt="klient" />
                        <h2 class="topMenu__right__header">
                            <?php echo get_current_user_id() ? wp_get_current_user()->user_firstname : "Panel klienta" ?>
                        </h2>
                    </a>

                    <!-- Mobile -->
                    <button class="hamburgerMenu" onclick="openMobileMenu()">
                        <span class="hamburgerLine"></span>
                        <span class="hamburgerLine"></span>
                        <span class="hamburgerLine"></span>
                    </button>
                </div>

                <!-- Mobile container -->
                <div class="mobileMenu">
                    <button class="mobileMenuClose" onclick="closeMobileMenu()">
                        <img class="mobileMenuClose__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/close.png'; ?>" alt="exit" />
                    </button>

                    <h2 class="mobileMenu__header">
                        Menu
                    </h2>

                    <ul class="mobileMenu__menu">
                        <?php
                        //echo get_product_subcategories_list( 'suplementy-diety' );
                        $categories = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0] );

                        for($i=0; $i<sizeof($categories); $i++) {
                        if(($categories[$i]->name !== 'Bez kategorii')&&($categories[$i]->name !== 'Uncategorized')&&($categories[$i]->name !== 'Producenci')) {
                        ?>

                            <a class="mobileMenuItem" href="https://ekozdrowko.pl/product-category/<?php echo $categories[$i]->slug;  ?>">
                                <?php echo $categories[$i]->name; ?>
                            </a>

                        <?php
                            }
                        }
                        ?>
                    </ul>

                    <div class="mobileMenu__panelKlienta">
                        <a class="topMenu__right__item d-block" href="<?php echo get_page_link(get_page_by_title('Moje konto')->ID); ?>">
                            <img class="topMenu__right__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/user.svg'; ?>" alt="klient" />
                            <h2 class="topMenu__right__header">
                                Panel klienta
                            </h2>
                        </a>
                    </div>
                </div>
            </menu>
