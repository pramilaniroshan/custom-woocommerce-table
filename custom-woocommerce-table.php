<?php
/*
Plugin Name: Custom WooCommerce Table
Description: Display products in a table format with real-time price updates and a single add-to-cart button.
Version: 1.0
Author: Pramila Niroshan
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Enqueue scripts and styles
function custom_woocommerce_table_enqueue_scripts() {
    wp_enqueue_style( 'custom-woocommerce-table-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    wp_enqueue_script( 'custom-woocommerce-table-script', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '1.0', true );
    wp_localize_script( 'custom-woocommerce-table-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'custom_woocommerce_table_enqueue_scripts' );

// Shortcode to display the product table
function custom_woocommerce_product_table($atts) {
    $atts = shortcode_atts(
        array(
            'category' => '', // Default category is empty
        ),
        $atts,
        'custom_product_table'
    );

    $category = $atts['category'];

    ob_start();

    // Query products in the specified category
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => $category,
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        echo '<div class="product-table">';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Product</th>';
        echo '<th>Unit Price</th>';
        echo '<th>Quantity</th>';
        echo '<th>Subtotal</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            $product_id = $product->get_id();
            $price = $product->get_price();
            $product_name = $product->get_name();
            $product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

            echo '<tr class="product-row" data-product-id="' . $product_id . '" data-price="' . $price . '">';
            echo '<td><img src="' . $product_image[0] . '" alt="' . $product_name . '"><br>' . $product_name . '</td>';
            echo '<td>$' . $price . '</td>';
            echo '<td><input type="number" class="quantity" min="0" value="0"></td>';
            echo '<td class="subtotal">$0.00</td>';
            echo '</tr>';
        endwhile;

        echo '</tbody>';
        echo '</table>';
        echo '<div id="total-price">Total: $0.00</div>';
        echo '<button id="add-all-to-cart">Add to Cart</button>';
        echo '</div>';
    } else {
        echo __( 'No products found' );
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'custom_product_table', 'custom_woocommerce_product_table' );

// Handle adding multiple products to cart via AJAX
function custom_add_multiple_products_to_cart() {
    if ( isset( $_POST['products'] ) ) {
        foreach ( $_POST['products'] as $product ) {
            $product_id = intval( $product['product_id'] );
            $quantity = intval( $product['quantity'] );

            if ( $product_id > 0 && $quantity > 0 ) {
                WC()->cart->add_to_cart( $product_id, $quantity );
            }
        }
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action( 'wp_ajax_add_multiple_products_to_cart', 'custom_add_multiple_products_to_cart' );
add_action( 'wp_ajax_nopriv_add_multiple_products_to_cart', 'custom_add_multiple_products_to_cart' );
?>