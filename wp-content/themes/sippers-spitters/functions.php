<?php
// Add custom Theme Functions here

add_action( 'woocommerce_product_options_general_product_data', 'my_custom_field' );


//add subtitile custom field to product
function my_custom_field() {

    woocommerce_wp_text_input(
        array(
            'id'          => '_subtitle',
            'label'       => __( 'Subtitle', 'woocommerce' ),
            'placeholder' => 'Subtitle....',
            'description' => __( 'Enter the subtitle.', 'woocommerce' )
        )
    );

}

add_action( 'woocommerce_process_product_meta', 'my_custom_field_save' );

function my_custom_field_save( $post_id ){

    $subtitle = $_POST['_subtitle'];
    if( !empty( $subtitle ) )
        update_post_meta( $post_id, '_subtitle', esc_attr( $subtitle ) );

}


//shop - add subtitle to item description
if ( ! function_exists( 'woocommerce_template_loop_product_title_SS' ) ) {

    function woocommerce_template_loop_product_title_SS() {
        global $post;
        echo '<a href="' . get_the_permalink() . '">';
        echo '<p class="name product-title">' . get_the_title() . '</p>';
        echo '<p class="name product-title">' . get_post_meta( $post->ID, '_subtitle', true ) . '</p>';
        echo '</a>';
    }

}

add_action( 'woocommerce_shop_loop_item_title_SS', 'woocommerce_template_loop_product_title_SS', 16 );