<?php
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
	case 'inscricaoa' :
        if($atletas = json_decode(utf8_encode(str_replace(",]", "]",$_REQUEST['itens'])),true)){
            $conn->connection->autocommit(false);
            $comp->getById($_REQUEST['idCompeticao']);
            $idPagamento = $comp->gerarInscricaoA($atletas);
            $_SESSION['fmj.mensagem'] = 52;
            header("Location:portal_servicos-guia?id=".$obj->md5_encrypt($idPagamento));
            $conn->connection->commit();
        }else{
            $_SESSION['fmj.mensagem'] = 55;
            header("Location:portal_home_index");
        }
            
        break;
         
}
}
?>