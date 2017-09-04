<?php
include ("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");
include ("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$objGrupoCompeticao = new GrupoCompeticao();
$objA = new Atleta();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL -> addFile("CONTEUDO", "templates/portal/inscricao/inscricaofb.html");
$objAssociacao -> getById($_REQUEST['idAssociacao']);
$objc -> getById($_REQUEST['idCompeticao']);

$TPL -> LABEL = "Preencha as informaчѕes adicionais da inscriчуo e confirme";
$TPL -> ID_ASSOCIACAO = $objAssociacao -> id;
$TPL -> ID_COMPETICAO = $objc -> id;
$TPL -> TITULO_COMP = $objc -> titulo;
$TPL -> DATA_COMP = $objc -> convdata($objc -> dataEvento, "mtn");
if($objc->percentDesconto > 0){
	$TPL->PERCENT = $objc->percentDesconto;
	$TPL->DATA_DESCONTO = $objc -> convdata($objc -> dataDesconto, "mtn");
	$TPL->block("BLOCK_DESCONTO");
}
if (isset($_REQUEST['todos']))
	$rsAtletas = $objA -> listaPorAssociacaoAtivos($objAssociacao -> id);
else
	$rsAtletas = $objA -> listaPorArrayIds($_REQUEST['atleta']);
$rsClasses = $objc -> listaClasses();
$TPL -> DOBRA1 = $objc -> dobra1;
$TPL -> DOBRA2 = $objc -> dobra2;
$TPL -> DOBRA3 = $objc -> dobra3;
$TPL -> VALOR_CUSTA = $objc -> money($objc -> custa -> valor, "atb");

foreach ($rsAtletas as $key => $value) {
	if ($value -> graduacao != null) {
		$TPL -> ATLETA = $value -> pessoa -> getNomeCompleto();
		$TPL -> ID_ATLETA = $value -> id;
		$TPL -> GRAD_ATLETA = $value -> graduacao -> id;

		//classes
		foreach ($rsClasses as $key2 => $grupo) {
			$TPL -> ID_CLA = $grupo -> classe -> id;
			$TPL -> LABEL_CLA = $grupo -> classe -> descricao;
			$TPL -> block("BLOCK_CLA");

			$categoria = new CategoriaPeso();
			$rsCategs = $categoria -> listaAtivasPorClasse($grupo -> classe -> id);
			foreach ($rsCategs as $key3 => $value2) {
				$TPL -> ID_CAT = $value2 -> id;
				$TPL -> DESC_CAT = $value2 -> descricao;
				$TPL -> block("BLOCK_DOBRA1_CAT");
				$TPL -> block("BLOCK_DOBRA2_CAT");
				$TPL -> block("BLOCK_DOBRA3_CAT");
			}

			$TPL -> block("BLOCK_DOBRA1_CL");
			$TPL -> block("BLOCK_DOBRA2_CL");
			$TPL -> block("BLOCK_DOBRA3_CL");
		}

		$TPL -> block("BLOCK_ATLETAS");

	}
}

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP -> getRows(0, 10, array(), array("ativo" => "=1"));
$TPL -> CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
	$TPL -> ID_PAG = $value -> id;
	$TPL -> IMG_PAG = $value -> imagem;
	$TPL -> NOME_PAG = $value -> descricao;
	$TPL -> block("BLOCK_TIPO_PAG");
	$TPL -> CHECKED = "";
}

$TPL -> show();
?>