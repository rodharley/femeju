<?php
$menu = 19;
include("configuraAjax.php");
$obj = new Galeria();
$objImg = new GaleriaImagem();
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
    case 'editar' :
        $obj->Alterar();
        echo $obj->id;
        break;
    case 'incluir' :
        $obj->Incluir();
        echo $obj->id;
        break;   
     case 'excluirImg' :
        $objImg->ExcluirImagem($_REQUEST['id']);        
        break;         
}
}
exit();
?>

