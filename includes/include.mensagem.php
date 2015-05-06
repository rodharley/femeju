<?php
if(isset($_SESSION['fmj.mensagem'])){
	$msg = new Mensagem();
	$TPL->MENSAGEM = $msg->echoMensagem($_SESSION['fmj.mensagem']);
	$msg->unSetMensagem();
}
?>