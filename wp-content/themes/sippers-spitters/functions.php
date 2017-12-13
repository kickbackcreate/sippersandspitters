<?php
// Add custom Theme Functions here

add_action( 'woocommerce_product_options_general_product_data', 'my_custom_field_brand_name' );
add_action( 'woocommerce_product_options_general_product_data', 'my_custom_field' );


//////////////////////////////////////////////////////
//add subtitile custom field to product
function my_custom_field_brand_name() {

    woocommerce_wp_text_input(
        array(
            'id'          => '_subtitle2',
            'label'       => __( 'Brand Name', 'woocommerce' ),
            'placeholder' => 'Brand Name....',
            'description' => __( 'Enter the brand name.', 'woocommerce' )
        )
    );

}

add_action( 'woocommerce_process_product_meta', 'my_custom_field_brand_name_save' );

function my_custom_field_brand_name_save( $post_id ){

    $subtitle = $_POST['_subtitle2'];
    if( !empty( $subtitle ) )
        update_post_meta( $post_id, '_subtitle2', esc_attr( $subtitle ) );

}


//////////////////////////////////////////////////////
//add subtitile custom field to product
function my_custom_field() {

    woocommerce_wp_text_input(
        array(
            'id'          => '_subtitle',
            'label'       => __( 'Wine Name', 'woocommerce' ),
            'placeholder' => 'Wine Name....',
            'description' => __( 'Enter the product name.', 'woocommerce' )
        )
    );

}

add_action( 'woocommerce_process_product_meta', 'my_custom_field_save' );

function my_custom_field_save( $post_id ){

    $subtitle = $_POST['_subtitle'];
    if( !empty( $subtitle ) )
        update_post_meta( $post_id, '_subtitle', esc_attr( $subtitle ) );

}

//////////////////////////////////////////////////////
//shop - add subtitle to item description
//////////////////////////////////////////////////////
if ( ! function_exists( 'woocommerce_template_loop_product_title_SS' ) ) {

    function woocommerce_template_loop_product_title_SS() {
        global $post;
        echo '<a href="' . get_the_permalink() . '">';
        echo '<p class="name product-title">' . get_post_meta( $post->ID, '_subtitle2', true ) . '</p>';
        echo '<p class="name product-title">' . get_post_meta( $post->ID, '_subtitle', true ) . '</p>';
        echo '</a>';
    }

}

add_action( 'woocommerce_shop_loop_item_title_SS', 'woocommerce_template_loop_product_title_SS', 16 );

//////////////////////////////////////////////////////
//add column to product table
//////////////////////////////////////////////////////
add_filter( 'manage_edit-product_columns', 'show_product_order',15 );
function show_product_order($columns){

    //remove column
    unset( $columns['tags'] );

    //add column
    $columns['subtitle2'] = __( 'Brand Name');
    $columns['subtitle'] = __( 'Wine Name');

    return $columns;
}

add_action( 'manage_product_posts_custom_column', 'wpso23858236_product_column_subtitle2', 10, 2 );
add_action( 'manage_product_posts_custom_column', 'wpso23858236_product_column_subtitle', 10, 2 );

function wpso23858236_product_column_subtitle( $column, $postid ) {
    if ( $column == 'subtitle' ) {
        echo get_post_meta( $postid, '_subtitle', true );
    }

}
function wpso23858236_product_column_subtitle2( $column, $postid ) {
    if ( $column == 'subtitle2' ) {
        echo get_post_meta( $postid, '_subtitle2', true );
    }

}

//////////////////////////////////////////////////////
//add "add to basket" on shop page
//////////////////////////////////////////////////////


if ( ! function_exists( 'woocommerce_template_loop_add_to_cart_SS' ) ) {

    /**
     * Get the add to cart template for the loop.
     *
     * @subpackage    Loop
     *
     * @param array $args Arguments.
     */
    function woocommerce_template_loop_add_to_cart_SS( $args = array() ) {
        global $product;

        if ( $product ) {

            $defaults = array(
                'quantity' => 1,
                'class'    => implode( ' ', array_filter( array(
                    'shopQuickAdd',
                    'button',
                    'product_type_' . $product->get_type(),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                ) ) ),

            );

            $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

            wc_get_template( 'loop/add-to-cart.php', $args );
        }
    }
}

////////////////////////////

add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart_SS', 15 );

//////////////////////////////////////////////////////
//change name of "add to basket" on shop page
//////////////////////////////////////////////////////
add_filter('woocommerce_product_add_to_cart_text', 'wh_archive_custom_cart_button_text');   // 2.1 +

function wh_archive_custom_cart_button_text()
{
    return __('Add To Basket', 'woocommerce');
}

