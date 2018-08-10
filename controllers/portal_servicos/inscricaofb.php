<?php
include ("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");
include ("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$objGrupoCompeticao = new GrupoCompeticao();
$objA = new Atleta();
$objConf = new Configuracoes();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL -> addFile("CONTEUDO", "templates/portal/inscricao/inscricaofb.html");
$objAssociacao -> getById($_REQUEST['idAssociacao']);
$objc -> getById($_REQUEST['idCompeticao']);
$taxas = $objConf->recuperaConfiguracoesTaxa();
$TPL->TAXA_PP = $taxas[13];
$TPL->TAXA_GN = $taxas[12];

$TPL -> LABEL = "Preencha as informações adicionais da inscrição e confirme";
$TPL -> ID_ASSOCIACAO = $objAssociacao -> id;
$TPL -> ID_COMPETICAO = $objc -> id;
$TPL -> TITULO_COMP = $objc -> titulo;
$TPL -> DATA_COMP = $objc -> convdata($objc -> dataEvento, "mtn");
if ($objc -> percentDesconto > 0) {
	$TPL -> PERCENT = $objc -> percentDesconto;
	$TPL -> DATA_DESCONTO = $objc -> convdata($objc -> dataDesconto, "mtn");
	$TPL -> block("BLOCK_DESCONTO");
}
$TPL -> ESPECIAL = 0;
if (isset($_REQUEST['especial'])) {
	$TPL -> ESPECIAL = 1;
	$TPL -> block("BLOCK_ESPECIAL");
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
		$anoatual = Date("Y");
		$anoNascimento = substr($value -> pessoa -> dataNascimento, 0, 4);
		$TPL -> ANO_ATUAL = $anoatual;
		$idade = $anoatual - $anoNascimento;
		$TPL -> IDADE = $idade;
		$TPL -> DATA_NASCIMENTO_ATLETA = $objA -> convdata($value -> pessoa -> dataNascimento, "mtn");
		$TPL -> GRAD_ATLETA = $value -> graduacao -> id;
		$TPL -> GENERO_ATLETA = $value -> pessoa -> sexo;

		//classes
		foreach ($rsClasses as $key2 => $grupo) {
			if ($idade <= $grupo -> classe -> maximo && $idade >= $grupo -> classe -> minimo) {
				$objClassGrad = new ClasseGraduacao();
				if ($objClassGrad -> getRow(array("classe" => "=" . $grupo -> classe -> id, "graduacao" => "=" . $value -> graduacao -> id))) {

					$TPL -> ID_CLA = $grupo -> classe -> id . ";" . $grupo -> classe -> maximo . ";" . $grupo -> classe -> minimo;
					$TPL -> LABEL_CLA = $grupo -> classe -> descricao . " - de " . $grupo -> classe -> minimo . " à " . $grupo -> classe -> maximo . " anos";
					;
					$TPL -> block("BLOCK_CLA");

					$categoria = new CategoriaPeso();
					$rsCategs = $categoria -> listaAtivasPorClasseGenero($grupo -> classe -> id, $value -> pessoa -> sexo);
					foreach ($rsCategs as $key3 => $value2) {
						$TPL -> ID_CAT = $value2 -> id . ";" . $grupo -> classe -> maximo . ";" . $grupo -> classe -> minimo;
						$TPL -> DESC_CAT = $value2 -> descricao." Peso:".$value2 -> minimo."Kg até ".$value2 -> maximo . "Kg";
						$TPL -> block("BLOCK_DOBRA1_CAT");
						$TPL -> block("BLOCK_DOBRA2_CAT");
						$TPL -> block("BLOCK_DOBRA3_CAT");
					}

					$TPL -> block("BLOCK_DOBRA1_CL");
					$TPL -> block("BLOCK_DOBRA2_CL");
					$TPL -> block("BLOCK_DOBRA3_CL");
				}
			}
		}

		$TPL -> block("BLOCK_ATLETAS");

	}
}

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP -> getRows(0, 10, array(), array("ativo" => "=1"));
//$TPL -> CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
	$TPL -> ID_PAG = $value -> id;
	$TPL -> IMG_PAG = $value -> imagem;
	$TPL -> NOME_PAG = $value -> descricao;
	$TPL -> block("BLOCK_TIPO_PAG");
	$TPL -> CHECKED = "";
}

$TPL -> show();
?>