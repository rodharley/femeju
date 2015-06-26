<?php
header("Content-Type: text/html; charset=utf-8");
$file = fopen('https://www.google.com.br/search?q='.$_REQUEST['pesquisa'].'+site:judobrasilia.com.br&ie=utf-8&oe=utf-8&gws_rd=cr&ei=iYGNVY3WBYGLNsS_gtAD','r');
$conteudo = stream_get_contents($file);
//$xml = simplexml_load_string(str_replace("<!doctype html>", "",$conteudo)); 
echo $conteudo;
