<?php
$menu = 0;
include("configuraAjaxSemLogin.php");
$obj = new GrupoCompeticao();
$classe = isset($_REQUEST['classe']) ?$_REQUEST['classe']:""; 
echo "<option value=''></option>";
$lista = $obj->listarPorClasse($classe);
foreach ($lista as $key => $value) {
   echo "<option value='".$value->categoria->id."'>".$value->categoria->descricao."</option>";	
}
exit();
?>