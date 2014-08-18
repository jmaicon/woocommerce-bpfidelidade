<?php

// Receive and make order

// Receive and treat information from xml

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<pedidoRemessa xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.bpfidelidade.com/schema/pedidoRemessa">
	<data>2014-05-20T16:20:29.4106501-03:00</data>
	<codigo>4abd0067-b4e6-4c2c-8ab9-2a1206f988a6</codigo>
	
	<fornecedor>
		<codigo>9fe1c14b-2313-4f08-9e31-8a249315c355</codigo>
		<nome>RAZAO SOCIAL DO FORNECEDOR</nome>
		<cnpj>00.000.000/0000-00</cnpj>
	</fornecedor>

	<cliente>
		<nome>MACHADO</nome>
		<sobrenome>ASSIS</sobrenome>
		<cpf>999.999.999-99</cpf>
		<email>meuemail@meudominio.com.br</email>
		<endereco>
			<logradouro>Av. Maria Coelho de Aguiar</logradouro>
			<numero>215</numero>
			<complemento>Conjunto A</complemento>
			<bairro>Jardim São Luiz</bairro>
			<cidade>Sao Paulo</cidade>
			<uf>SP</uf>
			<cep>05804-900</cep>
		</endereco>
	</cliente>

	<itens>
		<item>
			<codigo>123</codigo>
			<descricao>Smartphone Nokia Lumia 520 Desbloqueado Oi Preto Windows Phone 8 Câmera 5MP 3G Wi-Fi Memória Interna 8G GPS</descricao>
			<quantidade>1</quantidade>
			<custo>380.00</custo>
		</item>
	</itens>
</pedidoRemessa>



// Create order with the xml data



?>
