<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Competições
                        <small>Inscrições</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_competicao"><i class="fa fa-trophy"> </i> Competições</a></li>
                                         <li class="active">Inscrições</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/competicao/inscricoes.html");

$obj = new Competicao();
$oInsc = new Inscricao();
$oPag = new Pagamento();
$idComp = $obj->md5_decrypt($_REQUEST['id']);
$obj->getById($idComp);
$rspag = $oPag->getPagamentosDeCompeticao($idComp);
foreach ($rspag as $key => $pagamento) {
	$rs = $oInsc->getInscricoes($idComp,$pagamento->id);
	$TPL->DATA_INSCRICAO = $obj->convdata($pagamento->dataVencimento,"mtn");
	$TPL->NOME_RESP = $pagamento->nomeSacado;
	if($pagamento->bitPago == 0){
		$TPL->PAGO = 'Não';
		$TPL->COLOR_PAGO = 'danger';
	}else{
		$TPL->PAGO = 'Sim';
		$TPL->COLOR_PAGO = 'success';
	}
	if($pagamento->bitEspecial == 1){	
	$TPL->especial = "Sim";
		if($pagamento->bitResolvido == 1){
			$TPL->colorEspecial = "success";
		}else{
			$TPL->block("BLOCK_EDITAR");
			$TPL->colorEspecial = "danger";
		}
	}else{
	$TPL->especial = "Não";
	$TPL->colorEspecial = "default";
	}
	
	
	
	
	$TPL->ID_PAGAMENTO_HASH = $obj->md5_encrypt($pagamento->id);	
foreach ($rs as $key2 => $inscricao) {
	$TPL->ID_COMP_HASH = $obj->md5_encrypt($inscricao-> competicao->id);	
	$TPL->NOME_ATLETA = $inscricao->nomeAtleta;
	
	$TPL->block("BLOCK_INSCRICAO");
}
$TPL->block("BLOCK_PAGAMENTO");
}
$TPL->NOME_EVENTO = "Evento: ".$obj->titulo;

$TPL->show();
?>