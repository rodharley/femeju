<?php
$menu = 32;
include("includes/include.lock.php");
//INSTACIA CLASSES
$pag = new Pagamento();
$custa = new Custa();
$comp = new Competicao;
$inscricao = new Inscricao();
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
  case 'inscricao' :
        if($atletas = json_decode(utf8_encode(str_replace(",]", "]",$_REQUEST['itens'])),true)){
            $conn->connection->autocommit(false);
            $comp->getById($_REQUEST['idCompeticao']);
            $idPagamento = $comp->gerarInscricaoA($atletas);
            $_SESSION['fmj.mensagem'] = 52;
            header("Location:admin_pagamento-guia?id=".$comp->md5_encrypt($idPagamento));
            $conn->connection->commit();
        }else{
            $_SESSION['fmj.mensagem'] = 55;
            header("Location:admin_home-home");
        }
        exit();
        break;     
}
}
?>