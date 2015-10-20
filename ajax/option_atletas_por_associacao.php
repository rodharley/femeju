<?php
$menu = 0;
include("configuraAjax.php");
$obj = new Atleta();
$lista = $obj->listaPorAssociacao($_REQUEST['associacao']);
foreach ($lista as $key => $value) {
    
    echo "<option value='$value->id'>".$value->pessoa->nome." ".$value->pessoa->nomeMeio." ".$value->pessoa->sobrenome."</option>";
}
exit();
?>