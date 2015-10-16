<?php
$menu = 31;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Anuidade();

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
}
}
?>