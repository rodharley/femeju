<?php
$menu = 31;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Anuidade();
$objAno = new Ano();
$pag = new Pagamento();

//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
    case 'guia' :
        if(isset($_REQUEST['atleta'])){
        $objAno->getByAno($_REQUEST['ano']);
        $conn->connection->autocommit(false);
        $itensPagamento = $obj->geraItensPagamento();        
        $idPagamento = $pag->gerarPagamento(GrupoCusta::ANUIDADE,$_REQUEST['tipoPagamento'],$objAno->dataVencimento,$_SESSION['fmj.userId'],"Anuidade",$itensPagamento);
        $obj->atualizarAnuidades($idPagamento,$objAno);
         $_SESSION['fmj.mensagem'] = 52;
        $conn->connection->commit();
        header("Location:admin_pagamento-guia?id=".$obj->md5_encrypt($idPagamento));
        }else{
         $_SESSION['fmj.mensagem'] = 55;
         header("Location:admin_anuidade");   
        }
        exit();
        break;			
}
}
?>