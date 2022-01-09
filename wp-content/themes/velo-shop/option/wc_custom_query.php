<?php

/**
 * Handle a custom 'customvar' query var to get products with the 'customvar' meta.
 * @param array $query - Args for WP_Query.
 * @param array $query_vars - Query vars from WC_Product_Query.
 * @return array modified $query
 */

function handle_custom_query_var( $query, $query_vars ) {
    if (isset($query_vars['price_rage'])) {
        $query['meta_query'][] = array(
            'key'     => '_price',
            'value'   => $query_vars['price_rage'],
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC'
        );
    }

    return $query;
}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2 );

function like_title_posts_where( $where, $wp_query )
{
    global $wpdb;
    if ( $like_title = $wp_query->get( 'like_title' )) {
        $like_title = preg_replace("/(?![.=$'€%-])\p{P}/u", "", $like_title);
        $like_title = explode(' ', $like_title);

        foreach ($like_title as $item) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $item ) ) . '%\'';
        }
    }
    return $where;
}
add_filter( 'posts_where', 'like_title_posts_where', 10, 2 );