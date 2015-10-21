<?php
$menu = 30;
include("configuraAjax.php");
//INSTACIA CLASSES

$custa = new Custa();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
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
}
}
exit();
?>
