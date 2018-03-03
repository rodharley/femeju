<?php
$menu = 0;
include("configuraAjax.php");
$obj = new Atleta();
$lista = $obj->listaPorAssociacaoInativo($_REQUEST['associacao'],$_REQUEST['ano']);
foreach ($lista as $key => $value) {
    echo '<div class="checkbox"><label><input type="checkbox" name="atleta[]" value="'.$value->id.'" class="flat-blue">&nbsp;&nbsp;'.$value->pessoa->nome." ".$value->pessoa->nomeMeio." ".$value->pessoa->sobrenome.'</label></div>';
}
exit();
?>