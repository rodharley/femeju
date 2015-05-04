<?php
if(isset($_SESSION['grc.mensagem'])){
	$msg = new Mensagem();
	$TPL->MENSAGEM = $msg->echoMensagem($_SESSION['grc.mensagem']);
	$msg->unSetMensagem();
}
?>