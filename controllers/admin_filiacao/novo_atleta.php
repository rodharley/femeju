<?php
$menu = 5;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$atleta = new Atleta();
$academia = new Academia();
$uf = new Uf();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Filiação
			                            <small>Cadastro de novo Atleta</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                        <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
                                        <li><a href="admin_noticia-main"><i class="fa fa-pencil"> </i> Filiação</a></li>
			                            <li class="active">Novo Atleta</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/filiacao/novo.html");

$rsufs = $uf->getrows();
$rsAcademias = $academia->listaPermissoes($_SESSION['fmj.userId']);
$rsInstrutores = $atleta->listaTodosInstrutores();
foreach ($rsufs as $key => $uf) {
	$TPL->idUf = $uf->id;
    $TPL->lblUf = $uf->uf;
    $TPL->block("BLOCK_UF1");
    $TPL->block("BLOCK_UF2");   
}
$lacademia = new Academia();
foreach ($rsAcademias as $key => $lacademia) {
    $TPL->idAcademia = $lacademia->id;
    $TPL->lblAcademia = $lacademia->nome;
    $TPL->block("BLOCK_ACADEMIA");     
}

foreach ($rsInstrutores as $key => $instrutor) {
    $TPL->idInstrutor = $instrutor->id;
    $TPL->lblInstrutor = $instrutor->nome;
    $TPL->block("BLOCK_INSTRUTOR");     
}

$TPL->show();
?>