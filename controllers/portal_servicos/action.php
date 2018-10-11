<?php
include("includes/include.lockPortal.php");
//INSTACIA CLASSES
$usu = new Usuario();
$atleta = new Atleta();
$obj = new Anuidade();
$objAno = new Ano();
$pag = new Pagamento();
$comp = new Competicao;
$inscricao = new Inscricao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
		$usu->Alterar();
		break;
	case 'incluir' :
		$usu->IncluirPortal();
        
		break;
    case 'excluir' :
		$usu->Excluir($_REQUEST['id']);
		break;
	case 'redefinir':
		$usu->Redefinir($_REQUEST['id']);
		break;	
	case 'meusDados' :
		$usu->AlterarMeusDados();
		break;
    case 'incluirAtleta' :
        $atleta->IncluirPortal();
        header("Location:portal_servicos-main");
        break;
		case 'editaAtleta' :
        $atleta->EditaPortal();
        header("Location:portal_servicos-main");
        break;
    case 'inscricaof' :
         $conn->connection->autocommit(false);
        $comp->getById($_REQUEST['idCompeticao']);
        $idPagamento = $comp->gerarInscricaoF();
        $_SESSION['fmj.mensagem'] = 52;
        header("Location:portal_servicos-guia?id=".$obj->md5_encrypt($idPagamento));
        $conn->connection->commit();
        break;
     case 'guia' :
        if(isset($_REQUEST['atleta'])){
        $objAno->getByAno($_REQUEST['ano']);
        $conn->connection->autocommit(false);
        $itensPagamento = $obj->geraItensPagamento(); 
        $resp = new Pessoa();
        $arrayResp = $resp->gerarArraySacado($_SESSION['fmj.userId']);        
        $idPagamento = $pag->gerarPagamento(GrupoCusta::ANUIDADE,$_REQUEST['tipoPagamento'],$objAno->dataVencimento,$arrayResp,"Anuidade",$itensPagamento);
        $obj->atualizarAnuidades($idPagamento,$objAno);
         $_SESSION['fmj.mensagem'] = 52;
        $conn->connection->commit();
        header("Location:portal_servicos-guia?id=".$obj->md5_encrypt($idPagamento));
        }else{
         $_SESSION['fmj.mensagem'] = 55;
         header("Location:portal_servicos-anuidade?associacao=".$obj->md5_encrypt($_REQUEST['associacao']));   
        }
        exit();
        break;     
}
}
?>