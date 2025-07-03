<?php

class BaseController {

    protected function createMeta() {
        return array(
            array('name' => 'description', 'content' => SITE_NAME . ' - A vitrine online que conecta vendedores e compradores de carros.'),
            array('name' => 'keywords', 'content' => 'carros, venda de carros, comprar carro, vitrine de carros, ' . SITE_NAME),
            array('name' => 'author', 'content' => SITE_NAME),
            array('property' => 'og:title', 'content' => SITE_NAME . ' - Vitrine de Carros Online'),
            array('property' => 'og:description', 'content' => 'Conectamos vendedores e compradores para facilitar a negociação de veículos.'),
            array('property' => 'og:type', 'content' => 'website'),
            array('property' => 'og:url', 'content' => BASE_URL),
            array('property' => 'og:image', 'content' => OG_IMAGE),
            array('name' => 'twitter:card', 'content' => 'summary_large_image'),
            array('name' => 'twitter:title', 'content' => SITE_NAME . ' - Vitrine de Carros Online'),
            array('name' => 'twitter:description', 'content' => 'Encontre e venda carros com segurança e facilidade na ' . SITE_NAME),
            array('name' => 'twitter:image', 'content' => OG_IMAGE),
            array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
        );
    }


    protected function render($page, $data) {
        extract($data);
        $metaTags = $this->createMeta();
        include_once('app/views/partials/head.php');
        include_once('app/views/partials/header.php');
        include_once('app/views/' . $page . '.php');
        include_once('app/views/partials/footer.php');
    }
}