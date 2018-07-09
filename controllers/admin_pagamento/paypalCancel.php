<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");
$TPL->addFile("CONTEUDO", "templates/admin/pagamento/paypalCancel.html");
unset($_SESSION['idPagamento']);
$TPL->show();
?>