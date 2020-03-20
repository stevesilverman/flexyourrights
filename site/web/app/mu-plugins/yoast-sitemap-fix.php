<?php

add_action('init', function() {
    global $wp_rewrite;
    $GLOBALS['wp']->add_query_var( 'sitemap' );
    $GLOBALS['wp']->add_query_var( 'sitemap_n' );
    add_rewrite_rule( 'sitemap_index.xml$', 'index.php?sitemap=1', 'top' );
    add_rewrite_rule( '([^/]+?)-sitemap([0-9]+)?.xml$', 'index.php?sitemap=$matches[1]&sitemap_n=$matches[2]', 'top' );
});
