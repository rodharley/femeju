<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$obj = new Custa();
if($_REQUEST['custa'] != ""){
$obj->getById($_REQUEST['custa']);
echo json_encode(array("valor"=>$obj->valor,"valorDesc"=>"R$ ".$obj->money($obj->valor, "atb")));
}else{
echo json_encode(array("valor"=>0,"valorDesc"=>"R$ ".$obj->money(0, "atb")));    
}
exit();
?>