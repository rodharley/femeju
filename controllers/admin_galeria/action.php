<?php
$menu = 19;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Galeria();
$objImg = new GaleriaImagem();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'addImagem' :
        $objImg->AddImagens();        
        break;   
	case 'excluir' :
		$obj->Excluir($_REQUEST['id']);
		break;		
}
}
exit();

?>