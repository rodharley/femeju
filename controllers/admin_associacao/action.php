<?php
$menu = 25;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Associacao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $conn->connection->autocommit(false);
        //$conn->connection->begin_transaction(); 
		$obj->Alterar();
         $conn->connection->commit();
        $_SESSION['fmj.mensagem'] = 38;
        header("Location:admin_associacao-main");
        exit();
		break;
	case 'incluir' :
		$conn->connection->autocommit(false);
        //$conn->connection->begin_transaction();
		$obj->Incluir();
         $conn->connection->commit();
        $_SESSION['fmj.mensagem'] = 37;
        header("Location:admin_associacao-main");
        exit();
		break;
	case 'excluir' :
		$obj->Excluir($_REQUEST['id']);
        header("Location:admin_associacao-main");
        exit();
		break;		
}
}
?>