<?php
$menu = 0;
include ("configuraAjax.php");
$obj = new ClasseGraduacao();
$objCat = new CategoriaPeso();
$idade = $_REQUEST['idade'];
$genero = $_REQUEST['genero'];
$lista = $obj -> getRows(0, 99, array(), array("graduacao" => "=" . $_REQUEST['graduacao']));
echo "<option value=''>selecione</option>";
foreach ($lista as $key => $value) {
	if ($idade <= $value -> classe -> maximo && $idade >= $value -> classe -> minimo) {
		echo "<optgroup label='" . $value -> classe -> descricao . "'>";
		if ($genero != "") {
			$lista = $objCat -> listaAtivasPorClasseGenero($value -> classe->id, $genero);
		} else {
			$lista = $objCat -> listaAtivasPorClasse($value -> classe->id);
		}
		foreach ($lista as $key2 => $value2) {
			echo "<option value='" . $value2 -> id . "'>" . $value2 -> descricao . "</option>";
		}
		echo "</optgroup>";
	}
}
exit();
?>