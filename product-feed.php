<?php


// Get list of products and generate a xml:

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

$settings = get_option('wbpf_settings'); ?>

<catalogo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.bpfidelidade.com/schema/catalogo">
  <data><?php echo mysql2date('c', get_lastpostmodified('blog'), false); ?></data>
  
  <parceiro>
    <codigo><?php echo $settings['wbpf_codigo_parceiro']; ?></codigo>
    <cnpj><?php echo $settings['wbpf_cnpj']; ?></cnpj>
    <nome><?php echo $settings['wbpf_nome_fornecedor']; ?></nome>
    <autorizacao><?php echo $settings['wbpf_autorizacao']; ?></autorizacao>
  </parceiro>

  <produtos> <?php
    $args = array( 'post_type' => 'product', 'posts_per_page' => 999 );
    $loop = new WP_Query( $args );
    
    while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
    <produto>
      <codigo><?php echo $id; ?></codigo>
      <titulo><?php the_title_rss(); ?></titulo>
      <descricao><?php the_excerpt_rss(); ?></descricao>
      <detalhe><?php the_content_rss(); ?></detalhe>
      <categoria><?php echo get_the_term_list( $id, 'product_cat' ); ?></categoria>
      <preco><?php echo $product->regular_price; ?></preco>
      <promocional><?php echo $product->sale_price; ?></promocional>
      <custo></custo>
      <disponibilidade><?php echo $product->is_in_stock(); ?></disponibilidade>
      <entrega><?php echo $settings['wbpf_entrega']; ?></entrega>
      <validade>2015-03-30T00:00:00</validade>
      <imagens>
        <imagem>
          <urlThumb><?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?></urlThumb>
          <urlDefault><?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?></urlDefault>
          <urlZoom><?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?></urlZoom>
          <principal>true</principal>
        </imagem>

        <?php 

          $attachment_ids = $product->get_gallery_attachment_ids();

          if ( $attachment_ids ) {
            
            foreach ( $attachment_ids as $attachment_id ) {
              
              $image_link = wp_get_attachment_url( $attachment_id ); ?>
              
              <imagem>
                <urlThumb><?php echo $image_link; ?></urlThumb>
                <urlDefault><?php echo $image_link; ?></urlDefault>
                <urlZoom><?php echo $image_link; ?></urlZoom>
                <principal>false</principal>
              </imagem> <?php
            }
          } 
        ?>
      </imagens>
    </produto>
  <?php endwhile; ?>
  </produtos>
</catalogo>