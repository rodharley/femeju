<?php
$menu = 1;
include("configuraAjax.php");
$not = new Post();
if($_REQUEST['id'] != 0){
$not->getById($_REQUEST['id']);
$obCat = new Categoria();
$pasta = $obCat->retornaPasta($not->categoria);    
if ($not -> arquivo != "")
           $not -> apagaImagem($not -> arquivo, "../documentos/".$pasta."/");
$not->arquivo = "";
$not->save();
}
exit();
?>

