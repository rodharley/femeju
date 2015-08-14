<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/diretoria/main.html");
$obj = new Diretoria();
$rs = $obj->getRows();
foreach ($rs as $key => $dir) {
	$TPL->NOME = $dir->descricao;
    $TPL->ID_HASH = $obj->md5_encrypt($dir->id);
    $TPL->block("BLOCK_DIRETORIA");
}
$TPL->show();
?>