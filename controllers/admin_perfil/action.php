<?php
$menu =3;
include("includes/include.lock.php");
//INSTACIA CLASSES
$perfil = new Perfil();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$perfil->Alterar();
		break;
     case 'incluir' :
        $perfil->Incluir();
        break;  	
}
}

?>