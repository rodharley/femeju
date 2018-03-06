<?php
$menu = 0;
include("configuraAjaxSemLogin.php");
$obj = new CategoriaPeso();
$classe = isset($_REQUEST['classe']) ?$_REQUEST['classe']:""; 
$genero = isset($_REQUEST['genero']) ?$_REQUEST['genero']:""; 
echo "<option value=''></option>";
if($genero != ""){
$lista = $obj->listaAtivasPorClasseGenero($classe,$genero);	
}else{
$lista = $obj->listaAtivasPorClasse($classe);
}
foreach ($lista as $key => $value) {
   echo "<option value='".$value->id."'>".$value->descricao."</option>";	
}
exit();
?>