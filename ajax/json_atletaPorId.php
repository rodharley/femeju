<?php
header("Content-Type: application/json", true);
$menu = 0;
include("configuraAjax.php");
$pessoa= new Atleta();
$pessoa->getById($_REQUEST['id']);
$pessoa->pessoa->dataNascimento = $pessoa->convdata($pessoa->pessoa->dataNascimento,"mtn");
echo json_encode($pessoa->objectToArray($pessoa));
