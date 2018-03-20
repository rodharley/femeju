<?php
$menu = 0;
include("configuraAjax.php");
$obj = new ClasseGraduacao();
$objGrupoCompeticao = new GrupoCompeticao();
$idade = $_REQUEST['idade'];
$idCompeticao = isset($_REQUEST['idcompeticao']) ? $_REQUEST['idcompeticao'] : 0;
$lista = $obj->getRows(0,99,array(),array("graduacao"=>"=".$_REQUEST['graduacao']));
echo "<option value=''>selecione</option>";
foreach ($lista as $key => $value) {
	if ($idade <= $value -> classe -> maximo && $idade >= $value -> classe -> minimo) {
	if ($objGrupoCompeticao -> getRow(array("classe" => "=" . $value -> classe -> id, "competicao" => "=" . $idCompeticao))) {
	    echo "<option value='".$value->classe->id."'>".$value->classe->descricao."</option>";
	}
	}
}
exit();
?>