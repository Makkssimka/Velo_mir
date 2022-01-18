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

        $where .= " AND meta_1.meta_key = '_stock_status'";
        $where .= " AND meta_1.meta_value = 'instock'";

        $where .= " AND meta_2.meta_key = '_sku'";

        foreach ($like_title as $item) {
            $where .= " AND ($wpdb->posts.post_title LIKE '%" . esc_sql( $wpdb->esc_like( $item )) . "%' OR meta_2.meta_value LIKE '%" . esc_sql( $wpdb->esc_like( $item )) . "%')";
        }
    }
    return $where;
}
add_filter( 'posts_where', 'like_title_posts_where', 10, 2 );

// Join for searching metadata
function like_sku_posts_where($join) {
    global $wp_query, $wpdb;
    $join .= "LEFT JOIN $wpdb->postmeta as meta_1 ON $wpdb->posts.ID = meta_1.post_id ";
    $join .= "LEFT JOIN $wpdb->postmeta as meta_2 ON $wpdb->posts.ID = meta_2.post_id ";

    return $join;
}

add_filter('posts_join', 'like_sku_posts_where');

function my_posts_groupby($groupby) {
    global $wpdb;
    $groupby = "{$wpdb->posts}.ID";
    return $groupby;
}

add_filter( 'posts_groupby', 'my_posts_groupby' );
