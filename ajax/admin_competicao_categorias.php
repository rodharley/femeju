<?php
$menu = 37;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/competicao/itensCategoria.html");
$obj = new GrupoCompeticao();
$id = $_REQUEST['id'];
$alist = $obj->getRows(0,999,array(),array("competicao"=>"=".$id));

if (count($alist) > 0) {
$json = "";
foreach($alist as $key => $n){
    $TPL->CATEGORIA = $n->categoria->descricao;
    $TPL->CLASSE = $n->classe->descricao;
    $TPL->GRADUACAO = $n->graduacao->descricao;
    $TPL->VALOR = "R$ ".$obj->money($n->valor,"atb");
    $TPL->DOBRA = $n->dobra == 0 ? "Não" : "R$ ".$obj->money($n->dobra,"atb");
    $json .= json_encode($obj->objectToArray($n)).",";
    $TPL->ID_HASH = $obj->md5_encrypt($n->id);
    $TPL->KEY = $key;
    $TPL->block("BLOCK_ITEM");
    
}
 $TPL->JSON = substr($json, 0,strlen($json)-1);
}
$TPL->show();
exit();
?>

