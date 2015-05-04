<?php
$menu = 0;
$adm = $_SESSION['grc.userPerfilId'] < Perfil::COND_ADM ? true : false;
$issindico = ($_SESSION['grc.userPerfilId'] == Perfil::COND_ADM || $_SESSION['grc.userPerfilId'] == Perfil::COND_MAN) ? true : false;
include("includes/include.lock.php");
$TPL = NEW Template("templates/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Painel de Controle
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
                        <li class="active">Painel de Controle</li>
                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/home/home.html");
$pro = new Processo();
$comunicacao = new ComunicacaoObra();
$questionario = new Questionario();
$obUnidade = new UnidadeAutonoma();
$termo = new Termo();
$timeline = new TimeLine();
$BLOCO = "";
$TPL->LOADING = $pro->carregando;

//MONTAGEM DOS BOXES PARA GESTOR E ADM
switch ($_SESSION['grc.userPerfilId']) {
	case Perfil::ENG_ADM:
		$processos = $pro->listaProcessosAndamentoEmpresa(0,99999,$_SESSION['grc.empresaId']);
		$BLOCO = "BLOCK_ENG";

		//listar as pendencias de assinatura
		$ltpendEng = $comunicacao->pendenciaAssinaturaEng();
		foreach ($ltpendEng as $key => $value) {
			$TPL->TIPO = $value->getNumeroFormatado()." - Assinar comunicação";
			$TPL->ID_PROCESSO_HASH = $comunicacao->md5_encrypt($value->processo->id);
			$TPL->block("BLOCK_PENDENCIA");

		}
		$ltpendquestEng = $questionario->pendenciaAssinaturaEng();
		foreach ($ltpendquestEng as $key => $value) {
			$TPL->TIPO = $value->getNumeroFormatado()." - Assinar questionário";
			$TPL->ID_PROCESSO_HASH = $comunicacao->md5_encrypt($value->processo->id);
			$TPL->block("BLOCK_PENDENCIA");
		}

		$totalpend = count($ltpendEng)+count($ltpendquestEng);
		if($totalpend > 0){
		$TPL->QTD_PENDENCIAS = $totalpend;
			$TPL->block("BLOCK_POSSUI_PENDENCIA");
		}
		$TPL->block("BLOCK_AGENDA");
		$TPL->block("BLOCK_CONSULTA_PROCESSO");
		break;
	case Perfil::ENG_MAN:
		$processos = $pro->listaProcessosAndamentoEmpresa(0,99999,$_SESSION['grc.empresaId']);
		$BLOCO = "BLOCK_ENG";

		//listar as pendencias de assinatura
		$ltpendEng = $comunicacao->pendenciaAssinaturaEng();
		foreach ($ltpendEng as $key => $value) {
			$TPL->TIPO = $value->getNumeroFormatado()." - Assinar comunicação";
			$TPL->ID_PROCESSO_HASH = $comunicacao->md5_encrypt($value->processo->id);
			$TPL->block("BLOCK_PENDENCIA");

		}
		$ltpendquestEng = $questionario->pendenciaAssinaturaEng();
		foreach ($ltpendquestEng as $key => $value) {
			$TPL->TIPO = $value->getNumeroFormatado()." - Assinar questionário";
			$TPL->ID_PROCESSO_HASH = $comunicacao->md5_encrypt($value->processo->id);
			$TPL->block("BLOCK_PENDENCIA");
		}

		$totalpend = count($ltpendEng)+count($ltpendquestEng);
		if($totalpend > 0){
		$TPL->QTD_PENDENCIAS = $totalpend;
			$TPL->block("BLOCK_POSSUI_PENDENCIA");
		}
		$TPL->block("BLOCK_AGENDA");
		$TPL->block("BLOCK_CONSULTA_PROCESSO");
		break;
	case Perfil::GESTOR:
		$processos = $pro->listaProcessosAndamentoGeral(0,99999);
		$BLOCO = "BLOCK_GESTOR";
		$TPL->block("BLOCK_AGENDA");
		$TPL->block("BLOCK_CONSULTA_PROCESSO");
		break;
	case Perfil::PROPRIETARIO:
		$obUnidade->getRow(array("proprietario"=>"=".$_SESSION['grc.userId']));
		$processos = $pro->getRows(0,99999,array("dataCriacao"=>"desc"),array("unidade"=>"=".$obUnidade->id));
		$BLOCO = "BLOCK_PROPRIETARIO";
		$TPL->ID_UNIDADE = $obUnidade->id;
		$TPL->NUMERO_UNIDADE = $obUnidade->bloco." - ".$obUnidade->numero;
		$TPL->block("BLOCK__UNIDADE_PROP");
		$TPL->block("BLOCK_CONSULTA_PROCESSO");
		break;
	case Perfil::COND_PORT:
		$processos = $pro->listaProcessosAndamentoCondominio(0,99999,$_SESSION['grc.condominioId']);
		$BLOCO = "BLOCK_PORTARIA";
		break;

	default:
		$processos = $pro->listaProcessosAndamentoCondominio(0,99999,$_SESSION['grc.condominioId']);
		$BLOCO = "BLOCK_SINDICO";
		$TPL->ID_CONDOMINIO_HASH = $pro->md5_encrypt($_SESSION['grc.condominioId']);
		$TPL->block("BLOCK_COMUNICAR");
		$TPL->block("BLOCK_CONSULTA_UNIDADES");
		$TPL->block("BLOCK_CONSULTA_PROCESSO");
		//listar as pendencias de assinatura
		$ltpendEng = $termo->pendenciaAssinaturaSind();
		foreach ($ltpendEng as $key => $value) {
			$TPL->TIPO = $value->getNumeroFormatado()." - Assinar termo";
			$TPL->ID_PROCESSO_HASH = $comunicacao->md5_encrypt($value->processo->id);
			$TPL->block("BLOCK_PENDENCIA");

		}

		$totalpend = count($ltpendEng);
		if($totalpend > 0){
		$TPL->QTD_PENDENCIAS = $totalpend;
			$TPL->block("BLOCK_POSSUI_PENDENCIA");
		}

		break;
}

//carrega os processos em andamento
		foreach ($processos as $key2 => $processo) {
			$TPL->NOME_EMPRESA = $processo->unidade->condominio->empresa->nomeFantasia;
			$TPL->NOME_CONDOMINIO = $processo->unidade->condominio->nome;
			$TPL->UNIDADE_PROCESSO = $processo->unidade->numero;
			$TPL->NUMERO_PROCESSO = $processo->getNumeroFormatado();
			$TPL->STATUS_PROCESSO = $processo->status->descricao;
			$TPL->ID_PROCESSO_HASH = $processo->md5_encrypt($processo->id);

			if($_SESSION['grc.userPerfilId'] != Perfil::COND_PORT)
				$TPL->block("BLOCK_ENTRA_PROCESSO");
			$TPL->block("BLOCK_PROCESSO");
		}
		$TPL->block($BLOCO);



//carrega a agenda do usuario logado
if($_SESSION['grc.userPerfilId'] == Perfil::ENG_ADM || $_SESSION['grc.userPerfilId'] == Perfil::ENG_MAN){
$agenda = new Agenda();
$eventos = $agenda->listaEventosUsuario();
foreach ($eventos as $key => $evento) {
$TPL->EVENTO_TITULO = $evento->tipo." :: Condomínio ".$evento->processo->unidade->condominio->nome." Unidade ".$evento->processo->unidade->numero;
$start = $agenda->convdata($evento->data,"mtn");
$start .= $evento->periodo == 1 ? " 09:00 às 12:00 " : " 14:00 às 17:00";
$TPL->EVENTO_DATA = $start;
$TPL->block("BLOCK_EVENTOS");    
}

}

//carrega ultimos andamentos nos processos
if($_SESSION['grc.userPerfilId'] != Perfil::COND_PORT){
$listatl = $timeline->CarregaTimeLineTop10();
foreach ($listatl as $key => $tl) {
	$TPL -> DIAS = $timeline -> retorna_hora($tl -> data) . "  " . $timeline -> diffDate(date("Y-m-d"), $tl -> data, "D");
	$TPL->ID_PROCESSO_TL = $timeline->md5_encrypt($tl->processo->id);
	$TPL->PROCESSO_TL = $tl->processo->unidade->condominio->nome." - BLoco: ".$tl->processo->unidade->bloco." Apt.:".$tl->processo->unidade->numero;
	switch ($tl->tipo) {
		case TipoTimeline::COMUNICACAO_OBRA:
			$TPL->ICONE_TL = 'fa fa-check-square-o bg-purple';
			$TPL->TIPO_TL = 'Comunicação de Obra';
			break;
		case TipoTimeline::TERMO_AUTO_MANUTENCAO :
			$TPL->ICONE_TL = 'fa fa-file-text-o bg-purple';
			$TPL->TIPO_TL = 'Termo de Autorização de Manutenção';
			break;
		case TipoTimeline::TERMO_AUTO_REFORMA :
			$TPL->ICONE_TL = 'fa fa-file-text-o bg-purple';
			$TPL->TIPO_TL = 'Termo de Autorização de Reforma';
			break;
		case TipoTimeline::TERMO_CONC_MANUTENCAO :
			$TPL->ICONE_TL = 'fa fa-file-text-o bg-purple';
			$TPL->TIPO_TL = 'Termo de Conclusão de Manutenção';
			break;
		case TipoTimeline::TERMO_CONC_REFORMA :
			$TPL->ICONE_TL = 'fa fa-file-text-o bg-purple';
			$TPL->TIPO_TL = 'Termo de Conclusão de Reforma';
			break;
		case TipoTimeline::CLASSIFICACAO :
			$TPL->ICONE_TL = 'fa fa-check bg-green';
			$TPL->TIPO_TL = 'Classificação';
			break;
		case TipoTimeline::ASSINATURA :
			$TPL->ICONE_TL = 'fa fa-pencil bg-green';
			$TPL->TIPO_TL = 'Assinatura de documento';
			break;
		case TipoTimeline::ENVIO_MENSAGEM :
			$TPL->ICONE_TL = 'fa fa-comments bg-aqua';
			$TPL->TIPO_TL = 'Mensagem';
			break;
		case TipoTimeline::INFO_IMPORTANTE :
			$TPL->ICONE_TL = 'fa fa-info bg-fuchsia';
			$TPL->TIPO_TL = 'Informação';
			break;
		case TipoTimeline::DOCUMENTO :
			$TPL->ICONE_TL = 'fa fa-upload bg-green';
			$TPL->TIPO_TL = 'Alteração de Documentos de Projeto';
			break;
		case TipoTimeline::QUESTIONARIO :
			$TPL->ICONE_TL = 'fa fa-check-square-o bg-purple';
			$TPL->TIPO_TL = 'Criação de Questionário de início de reforma';
			break;
		case TipoTimeline::APROVAR_PROJETO :
			$TPL->ICONE_TL = 'fa fa-thumbs-up bg-fuchsia';
			$TPL->TIPO_TL = 'Aprovação de Projeto';
			break;
		default :
			break;
	}


	$TPL->block("BLOCK_TL");
	}
}
$TPL->show();
?>
