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
$TPL->addFile("CONTEUDO", "templates/admin/inscricao/main.html");

//$oInsc = new Inscricao();
$oPag = new Pagamento();
$oComp = new Competicao();
$rscomp = $oComp->listaAtivas();
foreach ($rscomp as $key => $competicao) {
	$TPL->COMPETICAO_NOME = $competicao->titulo;
	$TPL->COMPETICAO_ID = $oComp->md5_encrypt($competicao->id);
	$TPL->block("BLOCK_ITEM_COMP");
	
}
if(isset($_REQUEST['idCompeticao'])){
$rspag = $oPag->getPagamentosEspeciaisPendentes($oPag->md5_decrypt($_REQUEST['idCompeticao']));
foreach ($rspag as $key => $pagamento) {
	$TPL->ID_PAGAMENTO_HASH = $oPag->md5_encrypt($pagamento->id);
	//$rs = $oInsc->getInscricoes(0,$pagamento->id);
	$TPL->DATA_INSCRICAO = $oPag->convdata($pagamento->dataVencimento,"mtn");
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
	
	
	
	
		
/*
foreach ($rs as $key2 => $inscricao) {
	$TPL->NOME_EVENTO = $inscricao->competicao->titulo;	
	$TPL->NOME_ATLETA = $inscricao->nomeAtleta;
	
	$TPL->block("BLOCK_INSCRICAO");
}*/

$TPL->block("BLOCK_PAGAMENTO");
}

}
$TPL->show();
?>