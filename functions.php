<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

/* My code */

/**
 * Enqueue scripts and styles.
 */
function storefront_scripts() {
    wp_enqueue_style( 'css-mobile', get_template_directory_uri() . '/mobile.css?n=1', array(), _S_VERSION );
    wp_enqueue_style( 'css-geowidget', 'https://geowidget.easypack24.net/css/easypack.css', array(), _S_VERSION );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js?n=2', array('siema', 'jquery', 'gsap', 'geowidget', 'google-maps'), _S_VERSION, true );
    wp_enqueue_script( 'siema', get_template_directory_uri() . '/js/siema.js', null, null, true );
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', null, null, true );
    wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js', null, null, true );
    wp_enqueue_script( 'geowidget', 'https://geowidget.easypack24.net/js/sdk-for-javascript.js', null, null, true );
    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB2HRouNPP05z0Cup7YmeN6jFeV5kKXEYM&callback=initMap', null, null, true );


    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'storefront_scripts' );


add_filter( 'redirect_canonical', 'custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url ) {
    if ( is_paged() && is_singular() ) $redirect_url = false;
    return $redirect_url;
}

/* Add 09.03.2021 */
function wooc_extra_register_fields() {?>
        <!-- DANE UZYTKOWNIKA -->
    <p class="form-row form-row-first">
        <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
    </p>
    <p class="form-row form-row-last">
        <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
        <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
    </p>

    <!-- DANE ADRESOWE -->
    <p class="form-row form-row-first">
        <label for="reg_billing_first_name"><?php _e( 'Adres', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_adress_1" id="reg_billing_first_adress_1" value="<?php if ( ! empty( $_POST['billing_adress_1'] ) ) esc_attr_e( $_POST['billing_adress_1'] ); ?>" />
    </p>
    <p class="form-row form-row-last">
        <label for="reg_billing_last_name"><?php _e( 'Miejscowość', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_city" id="reg_billing_last_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e( 'Kod pocztowy', 'woocommerce' ); ?></label>
        <input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php esc_attr_e( $_POST['billing_postcode'] ); ?>" />
    </p>
    <div class="clear"></div>
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

/**
 * Below code save extra fields.
 */
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
        // Phone input filed which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
    if ( isset( $_POST['billing_first_name'] ) ) {
        //First name field which is by default
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        // First name field which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        // Last name field which is by default
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        // Last name field which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

/* Add baner post type */
function zdrowko_add_baner_post_type() {
    $supports = array(
        'title'
    );

    $labels = array(
        'name' => 'Banery'
    );

    $args = array(
        'labels'               => $labels,
        'supports'             => $supports,
        'public'               => true,
        'capability_type'      => 'post',
        'rewrite'              => array( 'slug' => '' ),
        'has_archive'          => true,
        'menu_position'        => 30,
        'menu_icon'            => 'dashicons-welcome-view-site'
    );

    register_post_type("Baner", $args);
}

add_action("init", "zdrowko_add_baner_post_type");

/* Add on 14.03 */
add_shortcode( 'stock_status', 'display_product_stock_status' );
function display_product_stock_status( $atts) {

    $atts = shortcode_atts(
        array('id'  => get_the_ID() ),
        $atts, 'stock_status'
    );

    $product = wc_get_product( $atts['id'] );

    $stock_status = $product->get_stock_status();
    $stock_quantity = $product->get_stock_quantity();

    if(($stock_quantity <= 3)&&($stock_quantity >= 1)) {
        return '<p class="stock in-stock">Ostatnie sztuki</p>';
    }
    else if ( 'instock' == $stock_status) {
        return '<p class="stock in-stock">Dostępny</p>';
    }
    else {
        return '<p class="stock out-of-stock">Niedostępny</p>';
    }
}

/* Get subcategories of given parent */
function get_product_subcategories_list( $category_slug ){
    $terms_html = array();
    $taxonomy = 'product_cat';
    // Get the product category (parent) WP_Term object
    $parent = get_term_by( 'slug', $category_slug, $taxonomy );
    // Get an array of the subcategories IDs (children IDs)
    $children_ids = get_term_children( $parent->term_id, $taxonomy );

    // Loop through each children IDs
    foreach($children_ids as $children_id){
        $term = get_term( $children_id, $taxonomy ); // WP_Term object
        $term_link = get_term_link( $term, $taxonomy ); // The term link
        if ( is_wp_error( $term_link ) ) $term_link = '';
        // Set in an array the html formated subcategory name/link
        $terms_html[] = '<a href="' . esc_url( $term_link ) . '" rel="tag" class="' . $term->slug . '">' . $term->name . '</a>';
    }


    return $terms_html;
}

/* Add InPost Geowidget */
/* do sekcji head dodajemy cały poniższy kod */
add_action('wp_head', 'inpost_script_javascript', 9);
function inpost_script_javascript()
{
    /* sprawdzamy czy jesteśmy na stronie z zamówieniem */
    if (is_checkout()) {
        ?>
        <script src="https://geowidget.easypack24.net/js/sdk-for-javascript.js"></script>
        <script type="text/javascript">
            function createOutput(e) {
                /*
                  pobieramy id naszego pola które ustawialiśmy w formularzu
                  i wstawiamy do pola nasz adres który otrzymujemy od inpost
                */
                var n = document.getElementById("inpost_place"),
                    t = e.address,
                    o = t.line1 + ", " + t.line2 + ", " + e.name;
                n.value = o
            };
            /*
              w miejscu uruchamiamy funkcję która otwiera popup,
              a także wywołujemy funkcję zamykająca popup
              na oficjalnej stornie inpost jest metoda do zamknięcia
              okna ale jest zbugowana
              a za pomocą tej funkcji createOutput wstawiamy dane
              do pola inpost
            */
            function openModal() {
                easyPack.modalMap(function(e, n) {
                    document.getElementById("widget-modal").addEventListener("click", closeModalPopup), createOutput(e)
                }, {
                    width: 500,
                    height: 600
                })
            };
            // funkcja chowająca popup
            function closeModalPopup() {
                var e = document.getElementById("widget-modal");
                e.parentNode.style.display = "none", e.removeEventListener("click", closeModalPopup)
            }

            window.easyPackAsyncInit = function() {
                easyPack.init({
                    defaultLocale: "pl",
                    mapType: "osm",
                    searchType: "osm",
                    points: {
                        types: ["parcel_locker"]
                    },
                    map: {
                        initialTypes: ["parcel_locker"]
                    }
                })
            };

            // kliknięcie w pole inpost wywołuje uruchomienie funkcji openModal()
            window.addEventListener("DOMContentLoaded", function() {
                document.getElementById("inpost_place").addEventListener("click", function() {
                    openModal()
                })
            });
        </script>
        <link rel="stylesheet" href="https://geowidget.easypack24.net/css/easypack.css" />
    <?php }
}

/* Add 17.03.2021 */
add_action('init', 'custom_rewrite_basic');
function custom_rewrite_basic() {
    global $wp_post_types;
    foreach ($wp_post_types as $wp_post_type) {
        if ($wp_post_type->_builtin) continue;
        if (!$wp_post_type->has_archive && isset($wp_post_type->rewrite) && isset($wp_post_type->rewrite['with_front']) && !$wp_post_type->rewrite['with_front']) {
            $slug = (isset($wp_post_type->rewrite['slug']) ? $wp_post_type->rewrite['slug'] : $wp_post_type->name);
            $page = get_page_by_slug($slug);
            if ($page) add_rewrite_rule('^' .$slug .'/page/([0-9]+)/?', 'index.php?page_id=' .$page->ID .'&paged=$matches[1]', 'top');
        }
    }
}

function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
    global $wpdb;

    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) );

    return ($page ? get_post($page, $output) : NULL);
}

//function modify_product_cat_query( $query ) {
//    $query->set('posts_per_page', 30);
//}
//add_action( 'pre_get_posts', 'modify_product_cat_query', 900);

/* Add additional fee based on weight */
function weight_add_cart_fee() {

    // Set here your percentage
    $percentage = 0.3;

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Get weight of all items in the cart
    $cart_weight = WC()->cart->get_cart_contents_weight();

    // calculate the fee amount
    $fee = $cart_weight * $percentage;

    // If weight amount is not null, adds the fee calcualtion to cart
    if ( !empty( $cart_weight ) ) {
        WC()->cart->add_fee( __('Opłata za wagę paczki ('.$cart_weight.' kg): ', 'storefront'), $fee, false );
    }
}
add_action( 'woocommerce_cart_calculate_fees','weight_add_cart_fee' );

/* Hide paczkomaty field if shipping method is different */
add_filter('woocommerce_checkout_fields', 'xa_remove_billing_checkout_fields');

function xa_remove_billing_checkout_fields($fields) {
    $shipping_method ='flat_rate:4'; // Set the desired shipping method to hide the checkout field(s).
    global $woocommerce;
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0];

    if ($chosen_shipping != $shipping_method) {
        unset($fields['billing']['inpost_place']); // Add/change filed name to be hide
    }
    return $fields;
}

/* Add 'Chce otrzymac fakture' checkbox */
// Add custom checkout field: woocommerce_review_order_before_submit
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
function my_custom_checkout_field() {
    echo '<div id="chceOtrzymacFaktureCheckbox">';

    woocommerce_form_field( 'faktura', array(
        'type'      => 'checkbox',
        'class'     => array('input-checkbox'),
        'label'     => __('Chcę otrzymać fakturę'),
    ),  WC()->checkout->get_value( 'faktura' ) );
    echo '</div>';
}

// Save the custom checkout field in the order meta, when checkbox has been checked
add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta', 10, 1 );
function custom_checkout_field_update_order_meta( $order_id ) {

    if ( ! empty( $_POST['faktura'] ) )
        update_post_meta( $order_id, 'faktura', $_POST['faktura'] );
}

// Display the custom field result on the order edit page (backend) when checkbox has been checked
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_custom_field_on_order_edit_pages', 10, 1 );
function display_custom_field_on_order_edit_pages( $order ){
    $my_field_name = get_post_meta( $order->get_id(), 'faktura', true );
    if( $my_field_name == 1 )
        echo '<p><strong>Faktura:</strong> Tak</p>';
    else
        echo '<p><strong>Faktura:</strong> Nie</p>';
}

/* Add suggested products in My Account page */
add_action('woocommerce_after_my_account', 'display_suggested_products');
add_action('woocommerce_after_account_orders', 'display_suggested_products');
add_action('woocommerce_after_account_payment_methods', 'display_suggested_products');

function display_suggested_products() {
    // Get the current user Object
    $current_user = wp_get_current_user();
    // Check if the user is valid
    if ( 0 == $current_user->ID ) return;

    //Create $args array
    $args = array(
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'meta_value' => $current_user->ID,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    );
    $customer_orders = get_posts($args);

    if ( ! $customer_orders ) return;

    /* Print header */
    echo '<div class="frontPageSection__header">
                    <div class="frontPageSection__header__left">
                        <h2 class="frontPageSection__header__header">
                            Może Ci się spodobać
                        </h2>
                    </div>
                </div>

                <div class="frontPageSection__main frontPageSection__main--single">';

    /* Orders */
    $i = 0;
    $alreadyUsed = array();
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        /* Products */
        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
            $product = wc_get_product($product_id);
            $title =  get_the_title($product_id);

            if(($product->is_purchasable())&&(!in_array($product_id, $alreadyUsed))) {
                $i++;
                echo('<div class="productItem">
                            <a href="' . get_permalink($product_id) . '">
                                <img class="productImg" src="' . get_the_post_thumbnail_url($product_id) . '" alt="' . $title . '" />
                                <h3 class="productTitle">
                                    ' . $title . '
                                </h3>
                                <h4 class="productPrice">
                                    ' . $product->get_price_html() . '
                                </h4> ');

                        echo do_shortcode('[add_to_cart id=' . $product->get_id() . ']');



                echo '</a>
                        </div>';
            }

            array_push($alreadyUsed, $product_id);
            if($i == 4) break;
        }
        if($i == 4) break;
    }

    /* Promocje */
    if($i < 4) {
                    $query = wc_get_products(array(
                            'status' => 'publish',
                            'limit' => $i + 5,
                            'category' => array('promocje')
                    ));

                        foreach($query as $product) {
                            if(in_array($product->get_id(), $alreadyUsed)) continue;

                            echo '<div class="productItem">
                                <a href="' . $product->get_permalink() . '">
                                     <img class="productImg" src="' . get_the_post_thumbnail_url($product->get_id()) . '" />
                                    <h3 class="productTitle">
                                        ' . $product->get_title() .'
                                    </h3>
                                    <h4 class="productPrice">
                                        ' . $product->get_price_html() . '
                                    </h4>';

                                    global $product2;
                                    $imgSrc = get_bloginfo('stylesheet_directory') . '/assets/images/img/add-to-cart.svg';

                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="addToCartBtn">
%s
<img class="addToCartBtn__img" src="%s" alt="dodaj-do-koszyka" />
</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->get_id() ),
                                            esc_attr( $product->get_sku() ),
                                            'Dodaj do koszyka',
                                            $imgSrc
                                        ),
                                        $product2 );
                                echo '</a>
                            </div>';
                        }
    }
}

/* Disable payment method 'Za pobraniem' for shipping 'Paczkomaty' */
add_filter( 'woocommerce_available_payment_gateways', 'zdrowko_gateway_disable_shipping' );

function zdrowko_gateway_disable_shipping( $available_gateways ) {

    global $woocommerce;

    if ( !is_admin() ) {

        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        $chosen_shipping = $chosen_methods[0];

        if ( isset( $available_gateways['cod'] ) && 0 === strpos( $chosen_shipping, 'flat_rate:4' ) ) {
            unset( $available_gateways['cod'] );
        }

    }

    return $available_gateways;

}

//add_action( 'woocommerce_product_query', 'change_posts_per_page', 900 );
//function change_posts_per_page( $query ) {
//
//    if( is_admin() )
//        return;
//
//    $filterArray = explode("/", "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
//    if(count($filterArray)>5) {
//        $query->set( 'posts_per_page', 30);
//    }else{
//        $query->set( 'posts_per_page', 10);
//    }
//}

add_action( 'woocommerce_product_query', 'change_posts_per_page', 999 );
function change_posts_per_page( $query ) {

    if( is_admin() )
        return;

    $query->set( 'posts_per_page', 30);

}

// Add new stock status options
function filter_woocommerce_product_stock_status_options( $status ) {
    // Add new statuses
    $status['last_items'] = __( 'Ostatnie sztuki', 'woocommerce' );

    return $status;
}
add_filter( 'woocommerce_product_stock_status_options', 'filter_woocommerce_product_stock_status_options', 10, 1 );

// Availability text
function filter_woocommerce_get_availability_text( $availability, $product ) {
    switch( $product->get_stock_status() ) {
        case 'last_items':
            $availability = __( 'Ostatnie sztuki', 'woocommerce' );
            break;
    }

    return $availability;
}
add_filter( 'woocommerce_get_availability_text', 'filter_woocommerce_get_availability_text', 10, 2 );

// Availability class
function filter_woocommerce_get_availability_class( $class, $product ) {
    switch( $product->get_stock_status() ) {
        case 'last_items':
            $class = 'last-items';
            break;
    }

    return $class;
}
add_filter( 'woocommerce_get_availability_class', 'filter_woocommerce_get_availability_class', 10, 2 );