<?php
session_start();
/**
 * @package TownHub - Directory & Listing WordPress Theme
 * @author CTHthemes - http://themeforest.net/user/cththemes
 * @date 06-11-2019
 * @since 1.0.0
 * @version 1.0.0
 * @copyright Copyright ( C ) 2025 snapseo.ca . All rights reserved.
 * @license GNU General Public License version 3 or later; see LICENSE

  function townhub_child_enqueue_styles() {
    $parent_style = 'townhub-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array( 'townhub-fonts', 'townhub-plugins' ), null );
    wp_enqueue_style( 'townhub-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style , 'townhub-color'),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'townhub_child_enqueue_styles' );

/*
////////////Hide specific products from the shop page.\\\\\\\\\\\\\\\
Some users will want to hide their subscriptions from the rest of the WooCommerce Store.
*/

function hide_specific_products_from_shop( $query ) {
    // Only run on the front end, main query, and the Shop page.
    if ( ! is_admin() && $query->is_main_query() && is_shop() ) {
        
        // List the product IDs you want to hide.
        $products_to_hide = array( product ID, Product ID);

        // Exclude these products from the query.
        $query->set( 'post__not_in', $products_to_hide );
    }
}
add_action( 'pre_get_posts', 'hide_specific_products_from_shop' );
