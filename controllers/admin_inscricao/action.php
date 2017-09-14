<?php 
$menu =37;
include("includes/include.lock.php");
//INSTACIA CLASSES
$comp = new Competicao();
$inscr = new Inscricao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'salvar' :
		$conn->connection->autocommit(false);
		$inscr->atualizarValoresInscricoes();
		$conn->connection->commit();
        $_SESSION['fmj.mensagem'] = 83;
        header("Location:admin_competicao");
        exit();
		break;
}
}
