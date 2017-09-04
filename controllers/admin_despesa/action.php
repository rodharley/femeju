<?php
$menu = 46;
include("includes/include.lock.php");
//INSTACIA CLASSES
$objgrupo = new DespesaGrupo();
$objdespesa = new Despesa();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'lancar' :
		$conn->connection->autocommit(false);
        $objgrupo->lancar();
        $conn->connection->commit();
        header("Location:admin_despesa");    
        break; 
	case 'excluir' :
		$conn->connection->autocommit(false);
        $objgrupo->excluir($objgrupo->md5_decrypt($_REQUEST['id']));
        $conn->connection->commit();
        header("Location:admin_despesa");
       
		break;
	case 'alterar' :
		$conn->connection->autocommit(false);
        $objgrupo->alterar();
        $conn->connection->commit();
        header("Location:admin_despesa");
       
		break;
	case 'savedata' :
		$conn->connection->autocommit(false);
		$objdespesa->alteraData($_REQUEST['id'],$_REQUEST['data']);
		$conn->connection->commit();
		
		break;
	case 'savevalor' :
		$conn->connection->autocommit(false);
		$objdespesa->alteraValor($_REQUEST['id'],$_REQUEST['valor']);
		$conn->connection->commit();
		
		break;
	case 'excluirp' :
		$conn->connection->autocommit(false);
		$objdespesa->excluir($_REQUEST['idp']);
		$conn->connection->commit();
		header("Location:admin_despesa-detalhe?id=".$_REQUEST['id']);
		break;
 
}
}
?>