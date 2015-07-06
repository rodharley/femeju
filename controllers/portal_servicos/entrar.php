<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/servicos/login.html");
if(isset($_GET['gestu']) && strlen($_GET['gestu']) > 0)
$TPL->URL = $_GET['gestu'];
$TPL->show();
?>
