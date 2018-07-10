<?php
include("includes/include.lockPortal.php");
$pag = new Pagamento();
header('Location: ' . 'portal_servicos-guia?id='.$pag->md5_encrypt($_SESSION['idPagamento']));
unset($_SESSION['idPagamento']);

?>