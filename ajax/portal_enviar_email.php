<?php
include("configuraAjaxSemLogin.php");
$obj = new Email();
$obj->enviarEmailPortal($_REQUEST['email'],$_REQUEST['texto']);
?>
<div class="alert alert-success" role="alert">Email enviado com sucesso!</div>
