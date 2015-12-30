<?php
$menu = 1;
include("configuraAjax.php");
$not = new Noticia();
if($_REQUEST['id'] != 0){
$not->getById($_REQUEST['id']);
if ($not -> foto != "")
           $not -> apagaImagem($not -> foto, "../img/noticias/");
$not->foto = "";
$not->save();
}
exit();
?>

