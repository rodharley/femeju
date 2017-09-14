<?php
$menu = 0;
include("configuraAjax.php");
echo "<option value='' selected='selected'>Selecione</option>";
$objCidade = new Cidade();
if(isset($_REQUEST['uf']) && $_REQUEST['uf'] != ""){
$lista = $objCidade->getRows(0,9999,array("nome"=>"asc"),array("uf"=>"=".$_REQUEST['uf']));
$idCidade = 0;
if(isset($_REQUEST['cidade'])){
   $idCidade =  $_REQUEST['cidade'];
}
foreach ($lista as $key => $value) {
        
    if($idCidade == $value->id)
    echo "<option value='$value->id' selected='selected'>$value->nome</option>";
    else
	echo "<option value='$value->id'>$value->nome</option>";
}
}
exit();
?>