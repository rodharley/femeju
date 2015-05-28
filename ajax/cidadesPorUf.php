<?php
$menu = 0;
include("configuraAjax.php");
echo "<option value='' selected='selected'>Selecione</option>";
$objCidade = new Cidade();
$lista = $objCidade->getRows(0,999,array("nome"=>"asc"),array("uf"=>"=".$_REQUEST['uf']));
foreach ($lista as $key => $value) {
	echo "<option value='$value->id'>$value->nome</option>";
}
exit();
?>