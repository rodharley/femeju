<?php
$TPL = NEW Template("templates/admin/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/admin/home/login.html");
if(isset($_GET['gestu']) && strlen($_GET['gestu']) > 0)
$TPL->URL = $_GET['gestu'];
$TPL->show();
?>
