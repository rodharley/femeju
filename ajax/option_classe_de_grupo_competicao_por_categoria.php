<?php
$menu = 0;
include("configuraAjax.php");
$obj = new GrupoCompeticao();
$lista = $obj->listar($_REQUEST['competicao'],$_REQUEST['graduacao'],$_REQUEST['categoria']);
echo "<option value=''></option>";
foreach ($lista as $key => $value) {
    
    echo "<option value='".$value->classe->id."'>".$value->classe->descricao."</option>";
}
exit();
?>