<?php
get_header();?>

<?php
    if(have_posts()) {
        while(have_posts()) {
            the_post();
            ?>

            <?php echo do_shortcode( '[flexy_breadcrumb]'); ?>

    <main class="singleMain">
        <menu class="singleMenu">
            <h3 class="sklepMenu__header singleMenu--header">
                Kategoria produktów
            </h3>
            <div class="singleMenu__display singleMenu__display--kategoria">
                <?php
                function str2Url($text)
                {
                    // replace non letter or digits by -
                    $text = str_replace(' ', '-', $text);

                    // transliterate
//                    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

                    $text = str_replace('ą', 'a', $text);
                    $text = str_replace('ć', 'c', $text);
                    $text = str_replace('ę', 'e', $text);
                    $text = str_replace('ń', 'n', $text);
                    $text = str_replace('ó', 'o', $text);
                    $text = str_replace('ź', 'z', $text);
                    $text = str_replace('ż', 'z', $text);
                    $text = str_replace('ł', 'l', $text);
                    $text = str_replace('ś', 's', $text);
                    $text = str_replace('Ą', 'a', $text);
                    $text = str_replace('Ć', 'c', $text);
                    $text = str_replace('Ę', 'e', $text);
                    $text = str_replace('Ń', 'n', $text);
                    $text = str_replace('Ó', 'o', $text);
                    $text = str_replace('Ź', 'z', $text);
                    $text = str_replace('Ż', 'z', $text);
                    $text = str_replace('Ł', 'l', $text);
                    $text = str_replace('Ś', 's', $text);

                    // remove unwanted characters
                    $text = str_replace('~[^-\w]+~', '', $text);

                    // trim
                    $text = trim($text, '-');

                    // remove duplicate -
                    $text = str_replace('~-+~', '-', $text);

                    // lowercase
                    $text = strtolower($text);

                    if (empty($text)) {
                        return 'n-a';
                    }

                    return $text;
                }

                global $product;
                $terms = get_the_terms( $product->get_id(), 'product_cat' );
                $displayCategory = $terms[0]->name;
                $permalinkPart1 =  str2Url($terms[1]->name);
                $permalinkPart2 =  str2Url($terms[0]->name);
                $href = 'https://ekozdrowko.pl/product-category/' . $permalinkPart2;
                ?>

                <a href="<?php echo $href; ?>">
                    <?php echo $displayCategory; ?>
                </a>
                <img class="menuItem__img menuItem__img--single" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/chevron_down.svg'; ?>" alt="arrow" />

            </div>

            <h3 class="sklepMenu__header singleMenu--header">
                Produkty w promocji
            </h3>
            <div class="singleMenu__display">
                <!-- Promocje -->
                <?php
                $i = 0;
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 1,
                    'limit' => 1,
                    'product_cat' => 'Promocje',
                    'nopaging' => true
                );

                $query = new WP_Query($args);

                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $product = wc_get_product( get_the_ID() );
                        $i++;
                        ?>

                        <div class="productItem">
                            <a href="<?php the_permalink(); ?>">
                                <img class="productImg" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo the_title(); ?>" />
                                <h3 class="productTitle">
                                    <?php echo the_title(); ?>
                                </h3>
                                <h4 class="productPrice">
                                    <?php echo $product->get_price_html(); ?>
                                </h4>

                                <?php
                                echo do_shortcode('[add_to_cart id=' . $product->get_id() . ']');
                                ?>

<!--                                --><?php
//
//                                global $product;
//                                $imgSrc = get_bloginfo('stylesheet_directory') . '/assets/images/img/add-to-cart.svg';
//
//                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
//                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="addToCartBtn">
//%s
//<img class="addToCartBtn__img" src="%s" alt="dodaj-do-koszyka" />
//</a>',
//                                        esc_url( $product->add_to_cart_url() ),
//                                        esc_attr( $product->get_id() ),
//                                        esc_attr( $product->get_sku() ),
//                                        $product->is_purchasable() ? 'Dodaj do koszyka' : '',
//                                        $imgSrc
//                                    ),
//                                    $product );
//
//                                ?>
                            </a>
                        </div>

                        <?php
                        if($i == 1) break;
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>

            <h3 class="sklepMenu__header singleMenu--header">
                Nowości
            </h3>
            <div class="singleMenu__display">
                <!-- Nowości -->
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 1
                );

                $query = new WP_Query($args);

                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $product = wc_get_product( get_the_ID() );
                        ?>

                        <div class="productItem">
                            <a href="<?php the_permalink(); ?>">
                                <img class="productImg" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo the_title(); ?>" />
                                <h3 class="productTitle">
                                    <?php echo the_title(); ?>
                                </h3>
                                <h4 class="productPrice">
                                    <?php echo $product->get_price_html(); ?>
                                </h4>
                                <?php


                                echo do_shortcode('[add_to_cart id=' . $product->get_id() . ']');


                                //                                global $product;
//                                $imgSrc = get_bloginfo('stylesheet_directory') . '/assets/images/img/add-to-cart.svg';
//
//                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
//                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="addToCartBtn">
//%s
//<img class="addToCartBtn__img" src="%s" alt="dodaj-do-koszyka" />
//</a>',
//                                        esc_url( $product->add_to_cart_url() ),
//                                        esc_attr( $product->get_id() ),
//                                        esc_attr( $product->get_sku() ),
//                                        $product->is_purchasable() ? 'Dodaj do koszyka' : '',
//                                        $imgSrc
//                                    ),
//                                    $product );

                                ?>
                            </a>
                        </div>

                        <?php
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>

            <h3 class="sklepMenu__header singleMenu--header">
                Kontakt ze sklepem
            </h3>
            <div class="singleMenu__display singleMenu__display--kontakt">
                <h2 class="kontaktRight__header">
                    Zdrówko Albert Załęczny
                </h2>
                <div class="kontaktRightItem">
                    <img class="kontaktIcon" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/home.svg'; ?>" alt="adres" />
                    <h3 class="kontaktData">
                        Tatrzańska 109<br/>
                        93-279 Łódź
                    </h3>
                </div>

                <div class="kontaktRightItem">
                    <img class="kontaktIcon" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/phone.svg'; ?>" alt="telefon" />
                    <h3 class="kontaktData">
                        <a href="tel:+48505029190">505 029 190</a>
                    </h3>
                </div>

                <div class="kontaktRightItem">
                    <img class="kontaktIcon" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/mail.svg'; ?>" alt="email" />
                    <h3 class="kontaktData">
                        <a href="mailto:sklep@ekozdrowko.pl">sklep@ekozdrowko.pl</a>
                    </h3>
                </div>
            </div>

        </menu>
        <main class="singleMainMain">
            <h2 class="singleMain__title">
                <?php echo the_title(); ?>
            </h2>

            <div class="singleMain__productInfo">
                <div class="singleMain__productImgWrapper">
                    <img class="singleMain__productImg" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo the_title(); ?>" />
                </div>
                <div class="singleMain__productInfo__description">
                    <h3 class="singleMain__productInfo__header">
                        Informacje o produkcie
                    </h3>
                    <h4 class="singleMain__productInfo__info">
                        <span class="singleMain__label">Producent: </span>
                        <?php echo get_field('producent'); ?>
                    </h4>
                    <h4 class="singleMain__productInfo__info">
                        <span class="singleMain__label">Dostępność: </span>
                        <?php echo do_shortcode("[stock_status]") ?>
                    </h4>

                    <h4 class="singleMain__price">
                        <?php
                        $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */
                        echo $product->get_price_html();
                        ?>
                    </h4>

                    <div class="singleMain__shopping">
                        <?php

//                        global $product;
//                        $imgSrc = get_bloginfo('stylesheet_directory') . '/assets/images/img/add-to-cart.svg';
//                        $actualLink = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//                        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
//                            sprintf( '<a href="%s" rel="nofollow" data-quantity="5" data-product_id="%s" data-product_sku="%s" class="addToCartBtn addToCartBtn--single">
//%s
//<img class="addToCartBtn__img" src="%s" alt="dodaj-do-koszyka" />
//</a>',
//                                esc_url( $product->add_to_cart_url() ),
//                                esc_attr( $product->get_id() ),
//                                esc_attr( $product->get_sku() ),
//                                $product->is_purchasable() ? 'Dodaj do koszyka' : '',
//                                $imgSrc
//                            ),
//                            $product );

                        ?>

                        <?php

                        echo do_shortcode('[add_to_cart id=' . $product->get_id() . ']');

                        ?>

                    </div>

                </div>
            </div>

            <div class="singleMain__description">
                <h2 class="singleMain__description__header">
                    Opis produktu
                </h2>

                <div class="singleMain__description__text">
                    <?php the_content(); ?>
                </div>
            </div>

            <?php
            global $product;
            $cross_sell_ids = $product->get_cross_sell_ids();

            if($cross_sell_ids[0]) {
              ?>
                <section class="frontPageSection frontPageSection--single">
                    <div class="frontPageSection__header">
                        <div class="frontPageSection__header__left">
                            <h2 class="frontPageSection_header_header__header">
                                Inni kupili również
                            </h2>
                        </div>
                    </div>

                    <div class="frontPageSection__main frontPageSection__main--single">
                        <!-- Promocje -->
                        <?php
                        global $product;
                        $cross_sell_ids = $product->get_cross_sell_ids();

                        $crosssellProductIds   =   get_post_meta( get_the_ID(), '_crosssell_ids' );
                        $crosssellProductIds    =   $crosssellProductIds[0];

                        foreach($crosssellProductIds as $id):
                            $product = wc_get_product( $id );
                            ?>

                            <div class="productItem">
                                <a href="<?php echo get_permalink($id); ?>">
                                    <img class="productImg" src="<?php echo get_the_post_thumbnail_url($id); ?>" alt="<?php echo get_the_title($id); ?>" />
                                    <h3 class="productTitle">
                                        <?php echo get_the_title($id); ?>
                                    </h3>
                                    <h4 class="productPrice">
                                        <?php echo $product->get_price_html(); ?>
                                    </h4>
                                    <?php

                                    echo do_shortcode('[add_to_cart id=' . $product->get_id() . ']');

                                    ?>
                                </a>
                            </div>

                        <?php


                        endforeach;
                        ?>
                    </div>
                </section>


                    <?php
            }
            ?>

        </main>
    </main>


<?php
        }
    }

?>

<?php
get_footer();
?>
