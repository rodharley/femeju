<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$pessoa= new Pessoa();
$pessoa->getRow(array("id"=>"=".$_REQUEST['id']));
echo json_encode($pessoa->objectToArray($pessoa));
