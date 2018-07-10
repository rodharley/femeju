<?php
include("includes/include.lockPortal.php");
$pag = new Pagamento();
$_SESSION['fmj.mensagem'] = 84;    
header('Location: ' . 'portal_servicos-guia?id='.$pag->md5_encrypt($_SESSION['idPagamento']));
unset($_SESSION['idPagamento']);
?>