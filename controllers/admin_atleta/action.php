<?php
$menu = 28;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Atleta();
$objH = new HistoricoGraduacao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$conn->connection->autocommit(false);
        //$conn->connection->begin_transaction(); 
        $obj->Alterar();
        $conn->connection->commit();
        header("Location:admin_atleta-main");
        exit();
        break;
	case 'incluir' :
        $conn->connection->autocommit(false);
        //$conn->connection->begin_transaction(); 
		$obj->Incluir();
        $conn->connection->commit();
        header("Location:admin_atleta-main");
        exit();
		break;
	case 'verificar' :
		$conn->connection->autocommit(false);
		$obj->Alterar();
        $obj->Verificar($_REQUEST['id']);
        $conn->connection->commit();
        header("Location:admin_atleta-main");
        exit();
		break;
	case 'excluir' :
		$obj->Excluir($_REQUEST['id']);
        header("Location:admin_atleta-main");
        exit();
		break;
	case 'incluirH':
		$objH->Incluir();
		header("Location:ajax/admin_listHistoricoGraduacao.php?idAtleta=".$_REQUEST['idAtleta']);
			break;
	case 'editarH':
		$objH->Alterar();
		header("Location:ajax/admin_listHistoricoGraduacao.php?idAtleta=".$_REQUEST['idAtleta']);
			break;
	case 'excluirH':
		$objH->Excluir($_REQUEST['idHistorico']);
		header("Location:ajax/admin_listHistoricoGraduacao.php?idAtleta=".$_REQUEST['idAtleta']);
			break;		
}
}
?>