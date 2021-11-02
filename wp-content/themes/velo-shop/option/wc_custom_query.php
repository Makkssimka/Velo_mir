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

function handle_custom_query_like( $query, $query_vars ) {
    if ( isset( $query_vars['like_name'] ) && ! empty( $query_vars['like_name'] ) ) {
        $query['s'] = esc_attr( $query_vars['like_name'] );
    }

    return $query;
}

add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_like', 10, 2 );