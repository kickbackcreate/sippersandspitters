<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<h1 class="product-title entry-title">
    <?php global $post; echo get_post_meta( $post->ID, '_subtitle2', true ) ?>
</h1>

<!--show the new subtitle field-->
<?php
global $post;
echo "<h2>" . get_post_meta( $post->ID, '_subtitle', true ) . "</h2>";
?>

<?php if(get_theme_mod('product_title_divider', 1)) { ?>
	<div class="is-divider small"></div>
<?php } ?>
