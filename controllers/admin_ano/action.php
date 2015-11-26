<?php
$menu =38;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Ano();
$objA = new Atleta();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$conn->connection->autocommit(false);
        $obj->editar();
        $conn->connection->commit();
        header("Location:admin_ano");
        exit();
		break;
     case 'incluir' :
        case 'incluir' :
        $conn->connection->autocommit(false);
        $obj->gerar();
        $conn->connection->commit();
        header("Location:admin_ano");
        exit();
        break;
	case 'excluir' :
        $obj->Excluir($_REQUEST['id']);
		header("Location:admin_ano");
        exit();
        break; 
    case 'revogar' :
        $objA->desativarTodos();
        header("Location:admin_ano");
        exit();
        break;  	
}
}

?>