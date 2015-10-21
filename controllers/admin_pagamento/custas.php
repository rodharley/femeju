<?php
$menu = 33;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$custa = new Custa();
$grupo = new GrupoCusta();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Tabela de Custas</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade"><i class="fa fa-credit-card"> </i> Pagamentos</a></li>
                                         <li class="active">Tabela de Custas</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/pagamento/custas.html");

  
 $TPL->checked_ativo = "checked='checked'";
 $TPL->LOADING = $custa->carregando;
 $TPL->block("BLOCK_PESQUISAR");

$TPL->ID_GRUPO = GrupoCusta::ANUIDADE;
$TPL->DESC_GRUPO = $grupo->getDescricao(GrupoCusta::ANUIDADE);
$TPL->block("BLOCK_TIPO_CUSTA");

$TPL->ID_GRUPO = GrupoCusta::COMPETICAO;
$TPL->DESC_GRUPO = $grupo->getDescricao(GrupoCusta::COMPETICAO);
$TPL->block("BLOCK_TIPO_CUSTA");

$TPL->ID_GRUPO = GrupoCusta::OUTROS;
$TPL->DESC_GRUPO = $grupo->getDescricao(GrupoCusta::OUTROS);
$TPL->block("BLOCK_TIPO_CUSTA");
$TPL->show();
?>