<?php
$menu = 0;
include("configuraAjax.php");
$obj = new ClasseGraduacao();
$idade = $_REQUEST['idade'];
$lista = $obj->getRows(0,99,array(),array("graduacao"=>"=".$_REQUEST['graduacao']));
echo "<option value=''>selecione</option>";
foreach ($lista as $key => $value) {
	if ($idade <= $value -> classe -> maximo && $idade >= $value -> classe -> minimo) {    
    echo "<option value='".$value->classe->id."'>".$value->classe->descricao."</option>";
	}
}
exit();
?>