<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Competi��es
                        <small>Nova Competi��o</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="#"><i class="fa fa-trophy"> </i> Competi��es</a></li>
                                         <li class="active">Nova Competi��o</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/competicao/nova_etapa1.html");
$obj = new Competicao();
$t = new TipoCampeonato(TipoCampeonato::ABERTO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->block("BLOCK_TIPO");
$t = new TipoCampeonato(TipoCampeonato::FECHADO);
$TPL->ID_TIPO = $t->id;
$TPL->DESC_TIPO = $t->descricao;
$TPL->block("BLOCK_TIPO");
$TPL->show();
?>