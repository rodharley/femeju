<?php
$menu = 31;
include ("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include ("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();
$objAn = new Ano();
include ("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL -> BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Anuidade</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade"><i class="fa fa-credit-card"> </i> Anuidade</a></li>
                                         <li class="active">Gerar Guia de Pagamento</li>
                                    </ol>
                </section>';

$TPL -> addFile("CONTEUDO", "templates/admin/anuidade/main.html");

//anuidade
$rsAnos = $objAn -> listaAnuidades();
foreach ($rsAnos as $key3 => $anuidade) {
    $TPL -> ID_ANO = $anuidade -> anoReferencia;
    $TPL -> LABEL_ANO = $anuidade -> anoReferencia;
    $TPL -> block("BLOCK_ANO");

}

$rsa = $obj -> listaAtivas("nome");
foreach ($rsa as $key => $value) {
    $TPL -> ASS_ID = $value -> id;
    $TPL -> ASS_LABEL = $value -> nome;
    $TPL -> block("BLOCK_ASSOCIACAO");
}
$TPL -> show();
?>