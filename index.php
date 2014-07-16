<?php

/*
*
*  Plugin Name: BPFidelidade
*  Plugin URI: http://github.com/jmaicon/bpfidelidade
*  Description: Um plugin para integrar qualquer loja na plataforma woocommerce com o programa de fidelidade Banco de Pontos Fidelidade.
*  Author: Jorge Maicon
*  Author URI: http://github.com/jmaicon/
*  Version: 1.0
*
*/


if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];

// define the product feed php page  
function wbpf_product_feed() {  
    $rss_template = dirname(__FILE__) . '/product-feed.php';  
    load_template ( $rss_template );  
}  

// add the product feed RSS  
add_action('do_feed_products', 'wbpf_product_feed', 10, 1);  

// update the Rerewrite rules  
add_action('init', 'my_add_product_feed');  
   
// function to add the rewrite rules  
function my_rewrite_product_rules( $wp_rewrite ) {  
    $new_rules = array(  
        'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)  
    );  
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;  
}  
  
// add the rewrite rule  
function my_add_product_feed( ) {  
    global $wp_rewrite;  
    add_action('generate_rewrite_rules', 'my_rewrite_product_rules');  
    $wp_rewrite->flush_rules();  
}

// Set up options if they do not exist
add_option('codigo_parceiro', '');
add_option('cnpj', '');
add_option('nome_fornecedor', '');
add_option('autorizacao', '');


// add options page
function wbpf_add_options_page() {
    if (function_exists('add_options_page')) {
        add_options_page('Woocommerce Banco de Pontos Fidelidade', 'Banco de Pontos Fidelidade', 8, __FILE__, 'wbpf_options_page');
    }
}

// generate options page
function wbpf_options_page() { ?>
    <div class="wrap">
        <h2>Woocommerce Banco de Pontos Fidelidade</h2>
    </div> <?php
} 

add_action('admin_menu', 'wbpf_add_options_page'); ?>
