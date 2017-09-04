<?php
$menu =37;
include("includes/include.lock.php");
//INSTACIA CLASSES
$comp = new Competicao();
$inscr = new Inscricao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'alterar' :
		$conn->connection->autocommit(false);
        $idComp = $comp->Alterar();
         $conn->connection->commit();
		 $_SESSION['fmj.mensagem'] = 61;
        header("Location:admin_competicao");
        exit();
		break;
     case 'incluir' :
         $conn->connection->autocommit(false);
        $idComp = $comp->Incluir();
        $conn->connection->commit();
        if($_REQUEST['competicao'] == 1){
		$_SESSION['fmj.mensagem'] = 60;        
        header("Location:admin_competicao-configuracao?id=".$comp->md5_encrypt($idComp));
        }else{
            $_SESSION['fmj.mensagem'] = 70;     
        header("Location:admin_competicao");    
        }
        exit();
        break;
	case 'excluir' :
        $comp->Excluir($_REQUEST['id']);
		exit();
        break;  
    case 'excluir_competicao' :		
        $conn->connection->autocommit(false);
        $idComp = $inscr->ExcluirInscricao($inscr->md5_decrypt($_REQUEST['idPag']));        
		if($idComp != 0){
			$conn->connection->commit();
		$_SESSION['fmj.mensagem'] = 74;
		}else{
		$_SESSION['fmj.mensagem'] = 75;	
		}		
        header("Location:admin_competicao-inscricoes?id=".$_REQUEST['idComp']);
        exit();
		break;
}
}

?>