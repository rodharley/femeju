<?php
$menu = 32;
include("includes/include.lock.php");
//INSTACIA CLASSES
$pag = new Pagamento();

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
}
}
?>