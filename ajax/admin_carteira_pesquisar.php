<?php
$menu = 43;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/carteira/list.html");
$obj = new Atleta();
$alist = $obj->pesquisarCarteira($_REQUEST['nome'],$_REQUEST['associacao'],$_REQUEST['numero'],$_REQUEST['range']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->FOTO = $n->pessoa->foto != "" ? $n->pessoa->foto : "pessoa.png";
    $TPL->NUMERO = $n->getId();
   	$TPL->NOME = $n->pessoa->nome." ".$n->pessoa->nomeMeio." ".$n->pessoa->sobrenome;    
    $TPL->ASSOCIACAO = $n->associacao->nome;
    $TPL->ID = $n->id;
    $TPL->block("BLOCK_ITEM_LISTA");
    
}
}
$TPL->show();
exit();
?>

