<?php
$menu = 44;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$tipo = new PagamentoTipo();
$alist = $tipo->getRows();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Tipos de Pagamento</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade"><i class="fa fa-credit-card"> </i> Pagamentos</a></li>
                                         <li class="active">Tipos de Pagamento</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/pagamento/tipos.html");

foreach($alist as $key => $n){
    $TPL->DESCRICAO= $n->descricao;
    $TPL->ID = $n->id;
	$TPL->CHECKED = $n->ativo == 1 ? "checked" : "";
    $TPL->block("BLOCK_ITEM");
    
}
$TPL->POSTSCRIPT = "$('input').on('ifClicked', function(event){
	$.ajax({
					url : 'admin_pagamento-action',
					data : {acao:'ativarTipo',ativar: $(this).prop('checked'),id:$(this).val()},
					type : 'POST'
				}).done(function(resposta) {
					
				}); 
});";
$TPL->show();
?>