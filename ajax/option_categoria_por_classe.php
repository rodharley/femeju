<?php
$menu = 0;
include("configuraAjaxSemLogin.php");
$obj = new CategoriaPeso();
$classe = isset($_REQUEST['classe']) ?$_REQUEST['classe']:""; 
echo "<option value=''></option>";
$lista = $obj->listaAtivasPorClasse($classe);
foreach ($lista as $key => $value) {
   echo "<option value='".$value->id."'>".$value->descricao."</option>";	
}
exit();
?>