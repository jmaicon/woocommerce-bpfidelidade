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


class wbpf_settings {
    public $options;

    public function __construct () {
        $this->options = get_option('wbpf_settings');
        $this->wbpf_register_settings_and_fields();
    }

    public function wbpf_add_settings_page () {
        add_options_page( 'Woocommerce Banco de Pontos Fidelidade', 'Banco de Pontos Fidelidade', 'administrator', __FILE__, array('wbpf_settings', 'wbpf_display_settings_page'));
    }

    public function wbpf_display_settings_page () { ?>
        <div class="wrap">
            <h2>Configuração do Woocommerce Banco de Pontos Fidelidade</h2>

            <form action="options.php" method="post">
                <?php settings_fields('wbpf_settings'); ?>
                <?php do_settings_sections( __FILE__ ); ?>

                <p class="submit"><input type="submit" name="submit" class="button-primary" value="Salvar"></p>
            </form>
        </div> <?php
    }

    public function wbpf_register_settings_and_fields () {
        register_setting( 'wbpf_settings', 'wbpf_settings' ); 
        add_settings_section( 'wbpf_main_section', 'Configurações Principais', array($this, 'wbpf_main_section_cb'), __FILE__ );
        add_settings_field( 'wbpf_codigo_parceiro', 'Código do Parceiro de Troca', array($this, 'wbpf_codigo_parceiro_setting'), __FILE__, 'wbpf_main_section' );
        add_settings_field( 'wbpf_cnpj', 'CNPJ do Parceiro de Troca', array($this, 'wbpf_cnpj_setting'), __FILE__, 'wbpf_main_section' );
        add_settings_field( 'wbpf_nome_fornecedor', 'Nome do Parceiro de Troca', array($this, 'wbpf_nome_fornecedor_setting'), __FILE__, 'wbpf_main_section' );
        add_settings_field( 'wbpf_autorizacao', 'Autorização', array($this, 'wbpf_autorizacao_setting'), __FILE__, 'wbpf_main_section' );
    }

    public function wbpf_main_section_cb () {
        // optional
    }

    public function wbpf_validate_settings ($wbpf_settings) {
        // validate inputs
    }

    public function wbpf_codigo_parceiro_setting () {
        echo "<input name='wbpf_settings[wbpf_codigo_parceiro]' type='text' value='{$this->options[wbpf_codigo_parceiro]}' />";
    }

    public function wbpf_cnpj_setting () {
        echo "<input name='wbpf_settings[wbpf_cnpj]' type='text' value='{$this->options[wbpf_cnpj]}' />";
    }

    public function wbpf_nome_fornecedor_setting () {
        echo "<input name='wbpf_settings[wbpf_nome_fornecedor]' type='text' value='{$this->options[wbpf_nome_fornecedor]}' />";
    }

    public function wbpf_autorizacao_setting () {
        echo "<input name='wbpf_settings[wbpf_autorizacao]' type='text' value='{$this->options[wbpf_autorizacao]}' />";
    }
}

add_action('admin_menu', function() {
    wbpf_settings::wbpf_add_settings_page();
});

add_action('admin_init', function() {
    new wbpf_settings();
});

?>