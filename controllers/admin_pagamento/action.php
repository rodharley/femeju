<?php
$menu = 32;
include("includes/include.lock.php");
//INSTACIA CLASSES
$pag = new Pagamento();
$custa = new Custa();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'excluir' :
		$conn->connection->autocommit(false);
        $pag->excluir($_REQUEST['id']);
        $conn->connection->commit();
        header("Location:admin_pagamento");
        exit();
        break; 
    case 'alterarCusta' :
        $conn->connection->autocommit(false);
        $custa->alterar();
        $conn->connection->commit();
        exit();
        break;   	
   case 'incluirCusta' :
        $conn->connection->autocommit(false);
        $custa->incluir();
        $conn->connection->commit();
        exit();
        break;  
   case 'excluirCusta' :
        $conn->connection->autocommit(false);
        $custa->excluir($_REQUEST['id']);
        $conn->connection->commit();
        exit();
        break;      
}
}
?>