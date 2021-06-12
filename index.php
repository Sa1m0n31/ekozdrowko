<?php
get_header(); ?>

    <!-- LANDING PAGE -->
    <header class="landingContainer">
        <div class="landingDots">
            <button class="landingDot" id="dot1" aria-label="baner-1" onclick="landingGoTo(0)"></button>
            <button class="landingDot" id="dot2" aria-label="baner-2" onclick="landingGoTo(1)"></button>
            <button class="landingDot" id="dot3" aria-label="baner-3" onclick="landingGoTo(2)"></button>
        </div>


        <button class="landingArrow landingLeft" onclick="landingPrev()">
            <img class="landingArrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/arrow-down.png'; ?>" alt="w-lewo" />
        </button>

        <div class="landingSiema">

            <?php
            $args = array(
                    'post_type' => 'baner',
                    'posts_per_page' => 3
            );
            $q = new WP_Query($args);

            if($q->have_posts()) {
                while($q->have_posts()) {
                    $q->the_post(); ?>

                    <div class="landing">
                        <div class="landingSiemaOverlay"></div>
                        <div class="landing__imgWrapper">
                            <img class="landing__img" src="<?php echo get_field('zdjecie'); ?>" alt="<?php echo the_title(); ?>" />
                        </div>

                        <h1 class="landing__header">
                            <?php echo get_field('naglowek_duzy') ?>
                        </h1>
                        <h2 class="landing__subheader">
                            <?php echo get_field('naglowek_mniejszy'); ?>
                        </h2>

                        <button class="landing__cta raise">
                            <a href="<?php echo get_field('link_do_buttona'); ?>">
                                <?php echo get_field('napis_na_buttonie'); ?>
                            </a>
                        </button>
                    </div>

                        <?php
                }
                wp_reset_postdata();
            }
            ?>

        </div>

        <button class="landingArrow landingRight" onclick="landingNext()">
            <img class="landingArrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/arrow-down.png'; ?>" alt="w-lewo" />
        </button>
    </header>

    <!-- PRODUCTS -->
    <div class="sections">
        <section class="frontPageSection">
            <div class="frontPageSection__header">
                <div class="frontPageSection__header__left">
                    <h2 class="frontPageSection__header__header">
                        Najlepiej sprzedawane
                    </h2>

                    <img class="frontPageSection__header__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/top-three.svg'; ?>" alt="najlepiej-sprzedawane" />

                    <button class="frontPageSection__button raise">
                        <a href="<?php echo get_page_link(get_page_by_title('sklep')->ID); ?>">
                            Zobacz więcej
                        </a>
                    </button>
                </div>

                <div class="frontPageSection__header__right">
                    <button class="frontPageSection__arrow" id="arrowLeft1" onclick="siemaLeft1()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                    <button class="frontPageSection__arrow" id="arrowRight1" onclick="siemaRight1()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                </div>
            </div>

            <div class="frontPageSection__main" id="frontPageSection1">

                <!-- Najlepiej sprzedawane -->
                <?php
                    $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 6,
                            'meta_key' => 'total_sales',
                            'orderby' => 'meta_value_num'
                    );
                    $q = new WP_Query($args);

                    if($q->have_posts()) {
                        while($q->have_posts()) {
                            $q->the_post();
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
                                ?>
                                </a>
                            </div>


                                <?php
                        }
                        wp_reset_postdata();
                    }

                ?>



            </div>
        </section>

        <section class="frontPageSection">
            <div class="frontPageSection__header">
                <div class="frontPageSection__header__left">
                    <h2 class="frontPageSection__header__header">
                        Promocje
                    </h2>

                    <img class="frontPageSection__header__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/discount.svg'; ?>" alt="promocje" />

                    <button class="frontPageSection__button raise">
                        <a href="<?php echo get_page_link(get_page_by_title('sklep')->ID); ?>">
                            Zobacz więcej
                        </a>
                    </button>
                </div>

                <div class="frontPageSection__header__right">
                    <button class="frontPageSection__arrow" id="arrowLeft2" onclick="siemaLeft2()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                    <button class="frontPageSection__arrow" id="arrowRight2" onclick="siemaRight2()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                </div>
            </div>

            <div class="frontPageSection__main" id="frontPageSection2">
                <!-- Promocje -->
                <?php
                    $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 6,
                            'product_cat' => 'Promocje',
                            'nopaging' => true
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
                                    ?>
                                </a>
                            </div>

                                <?php
                        }
                        wp_reset_postdata();
                    }
                ?>
            </div>
        </section>

        <section class="frontPageSection">
            <div class="frontPageSection__header">
                <div class="frontPageSection__header__left">
                    <h2 class="frontPageSection__header__header">
                        Nowości
                    </h2>

                    <img class="frontPageSection__header__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/new.svg'; ?>" alt="nowości" />

                    <button class="frontPageSection__button raise">
                        <a href="<?php echo get_page_link(get_page_by_title('sklep')->ID); ?>">
                            Zobacz więcej
                        </a>
                    </button>
                </div>

                <div class="frontPageSection__header__right">
                    <button class="frontPageSection__arrow" id="arrowLeft3" onclick="siemaLeft3()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                    <button class="frontPageSection__arrow" id="arrowRight3" onclick="siemaRight3()">
                        <img class="frontPageSection__arrow__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/long_right.svg'; ?>" alt="arrow" />
                    </button>
                </div>
            </div>

            <div class="frontPageSection__main" id="frontPageSection3">
                <!-- Nowości -->
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 6
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
                                ?>
                            </a>
                        </div>

                        <?php
                    }
                    wp_reset_postdata();
                }
                ?>

            </div>
        </section>
    </div>

    <!-- PARALAX -->
    <div class="paralax">
        <!-- CSS background-image here -->
    </div>

    <!-- KONTAKT -->
    <section class="kontakt">
        <div class="kontaktLeft" id="map">

        </div>

        <div class="kontaktRight">
            <h2 class="kontaktRight__header">
                Masz pytania? Skontaktuj się z nami
            </h2>
            <div class="kontaktRightItem">
                <img class="kontaktIcon" src="<?php echo get_bloginfo('stylesheet_directory') . '/assets/images/img/home.svg'; ?>" alt="adres" />
                <h3 class="kontaktData">
                    Zdrówko Albert Załęczny<br/>
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
    </section>


<?php
get_footer();
