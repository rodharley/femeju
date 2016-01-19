<?php
include("configuraAjaxSemLogin.php");
$obj = new Email();
$obj->enviarEmailPortal(utf8_decode($_REQUEST['email']),utf8_decode($_REQUEST['texto']));
?>
<div class="alert alert-success" role="alert">Email enviado com sucesso!</div>
