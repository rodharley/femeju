<?php
$menu =37;
include("includes/include.lock.php");
//INSTACIA CLASSES
$comp = new Competicao();
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
		  $_SESSION['fmj.mensagem'] = 60;
        header("Location:admin_competicao-configuracao?id=".$comp->md5_encrypt($idComp));
        exit();
        break;
	case 'excluir' :
        $comp->Excluir($_REQUEST['id']);
		header("Location:admin_competicao");
        exit();
        break;  
    case 'incluirCat' :
        $conn->connection->autocommit(false);
        $idComp = $comp->IncluirCategoria();
         $conn->connection->commit();
        break;	
    case 'editarCat' :
        $conn->connection->autocommit(false);
        $idComp = $comp->AlterarCategoria();
         $conn->connection->commit();
        break;
    case 'excluirCat' :
        $conn->connection->autocommit(false);
        $idComp = $comp->ExcluirCategoria();
         $conn->connection->commit();
        break;  
}
}

?>