<?php
$menu = 31;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Anuidade();

$pag = new Pagamento();

//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'gerar' :
		$conn->connection->autocommit(false);
        $obj->gerar();
        $conn->connection->commit();
        header("Location:admin_anuidade");
        exit();
        break;
    case 'guia' :
        $conn->connection->autocommit(false);
        $itensPagamento = $obj->geraItensPagamento();
        $obj->getOneByAno($_REQUEST['ano']);        
        $idPagamento = $pag->gerarPagamento(GrupoCusta::ANUIDADE,$_REQUEST['tipoPagamento'],$obj->dataVencimento,$_SESSION['fmj.userId'],$itensPagamento);
        $obj->atualizarAnuidades($idPagamento,$obj->anoReferencia);
         $_SESSION['fmj.mensagem'] = 52;
        $conn->connection->commit();
        header("Location:admin_anuidade");
        exit();
        break;			
}
}
?>