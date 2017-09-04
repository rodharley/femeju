<?php
$menu =50;
include("includes/include.lock.php");
//INSTACIA CLASSES
$objdiploma = new Diploma();
$post = new Post();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'incluir' :
		$conn->connection->autocommit(false);        
        $objdiploma->Incluir();
        $conn->connection->commit();
        header("Location:admin_diploma");
        exit();
        break;
	case 'editar' :
		$conn->connection->autocommit(false);        
        $objdiploma->Alterar();
        $conn->connection->commit();
        header("Location:admin_diploma");
        exit();
        break;	
	case 'excluir' :
		$conn->connection->autocommit(false);        
        $objdiploma->Excluir($objdiploma->md5_decrypt($_REQUEST['id']));
        $conn->connection->commit();
        header("Location:admin_diploma");
        exit();
        break;	
	
   
}
}

?>