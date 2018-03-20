<?php
$menu = 0;
include ("configuraAjax.php");
$obj = new ClasseGraduacao();
$objCat = new CategoriaPeso();
$objGrupoCompeticao = new GrupoCompeticao();
$idade = $_REQUEST['idade'];
$genero = $_REQUEST['genero'];
$idCompeticao = isset($_REQUEST['idcompeticao']) ? $_REQUEST['idcompeticao'] : 0;
$lista = $obj -> getRows(0, 99, array(), array("graduacao" => "=" . $_REQUEST['graduacao']));
echo "<option value=''>selecione</option>";
foreach ($lista as $key => $value) {
	if ($idade <= $value -> classe -> maximo && $idade >= $value -> classe -> minimo) {
		if ($objGrupoCompeticao -> getRow(array("classe" => "=" . $value -> classe -> id, "competicao" => "=" . $idCompeticao))) {
		
		echo "<optgroup label='" . $value -> classe -> descricao . "'>";
		if ($genero != "") {
			$lista2 = $objCat -> listaAtivasPorClasseGenero($value -> classe->id, $genero);
		} else {
			$lista2 = $objCat -> listaAtivasPorClasse($value -> classe->id);
		}
		foreach ($lista2 as $key2 => $value2) {
			echo "<option value='" . $value2 -> id . "'>" . $value2 -> descricao." Peso:".$value2 -> minimo."Kg até ".$value2 -> maximo . "Kg" . "</option>";
		}
		echo "</optgroup>";
	}
	}
}
exit();
?>