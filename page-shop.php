<?php
get_header();
?>

<main class="sklep">
    <menu class="sklepMenu">
        <?php
        wp_nav_menu("Drugie menu");
        ?>
    </menu>
    <main class="sklepMain">
        <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 30
        );

        $query = new WP_Query($args);

        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $product = wc_get_product( get_the_ID() );
                ?>

                <div class="productItem productItem--sklep">
                    <a href="<?php the_permalink(); ?>">
                        <img class="productImg" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo the_title(); ?>" />
                        <h3 class="productTitle">
                            <?php echo the_title(); ?>
                        </h3>
                        <h4 class="productPrice">
                            <?php echo $product->get_price_html(); ?>
                        </h4>
                        <?php

                        global $product;
                        $imgSrc = get_bloginfo('stylesheet_directory') . '/assets/images/img/add-to-cart.svg';

                        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="addToCartBtn">
%s
<img class="addToCartBtn__img" src="%s" alt="dodaj-do-koszyka" />
</a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                $product->is_purchasable() ? 'Dodaj do koszyka' : '',
                                $imgSrc
                            ),
                            $product );

                        ?>
                    </a>
                </div>

                <?php
            }
            wp_reset_postdata();
        }
        ?>
    </main>
</main>

<?php
get_footer();
?>
