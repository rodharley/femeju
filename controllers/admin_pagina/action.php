<?php
$pagina = new Pagina();
$menu = 16;
include("includes/include.lock.php");
//INSTACIA CLASSES
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $pagina->Alterar();		
        break;			
}
}
exit();
?>