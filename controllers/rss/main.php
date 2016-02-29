<?php

$rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
$rss->addAttribute('version', '2.0');
$canal = $rss->addChild('channel');
$now = time();
$pubDate= date('r', $now);
// Adiciona sub-elementos ao elemento <channel>
$canal->addChild('title', utf8_encode('Notícias Judo Brasília'));
$canal->addChild('link', 'http://www.judobrasilia.com.br');
$canal->addChild('description', utf8_encode('Rss de notícias do site judo brasília'));
$canal->addChild('pubDate', $pubDate);

$objNoticia = new Noticia();
$rs = $objNoticia->listar3Portal(0,10);
foreach ($rs as $key => $not) {
    // Cria um elemento <item> dentro de <channel>
$item = $canal->addChild('item');
// Adiciona sub-elementos ao elemento <item>
$item->addChild('title', utf8_encode($not->titulo));
$item->addChild('link', URL.'/portal_noticia-detalhe?id='.$objNoticia->md5_encrypt($not->id));
$item->addChild('description', utf8_encode($not->sumario));
$dt = strtotime($not->data);
$item->addChild('pubDate', date('r',$dt));

	
}



// Define o tipo de conteúdo e o charset
header("content-type: application/rss+xml; charset=utf-8");
//header('Content-Type: text/xml');
//header('Content-Type: application/xml');
// Entrega o conteúdo do RSS completo:
echo $rss->asXML();
exit;
?>