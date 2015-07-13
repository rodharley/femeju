<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/post/main.html");

$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$categoria = isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : 1;
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : Date("Y");

$obj = new Post();
$objCat = new Categoria($categoria);
$objFormato = new Formato();



$totalPesquisa = $obj->listar3PortalTotal($ano,$categoria);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina,3);
$rspost = $obj->listar3Portal($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$ano,$categoria);
$ARRano = $obj->listarArrayAnos($categoria);
foreach ($rspost as $key => $post) {
    $TPL->post_data = $obj->convdata($post->data,"mtn");
	$TPL->post_titulo = $post->titulo;
	$TPL->post_mensagem = $post->mensagem;	
    if($post->imagem != ""){
		$TPL->post_imagem = "img/".$objCat->pasta."/".$post->imagem;
		$TPL->block("BLOCK_POST_IMAGEM");		
	}else{
		$TPL->block("BLOCK_POST_SEM_IMAGEM");
	}
	if($post->arquivo != ""){
		$TPL->post_link = "documentos/".$objCat->pasta."/".$post->arquivo;
		$TPL->post_tipoArquivo = "fb_".$obj->retornaTipo($post->arquivo);
		$TPL->post_arquivo = $post->arquivo;
		$TPL->block("BLOCK_POST_ARQUIVO");
	}    
    //$template = $objFormato->retornaTemplate($post->formato,"img/".$objCat->pasta."/".$post->imagem,$post->titulo,$post->mensagem,"documentos/".$objCat->pasta."/".$post->arquivo,"fb_".$obj->retornaTipo($post->arquivo),$post->arquivo,$obj->convdata($post->data,"mtn"));
    //$TPL->ETIQUETA = $template;
    $TPL->block("BLOCK_POST");
    
}

//$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
$TPL->ANO = $ano;
$TPL->CATEGORIA = $objCat->id;   
$TPL->TITULO = $objCat->retornaDescricao($objCat->id);
foreach ($ARRano as $key => $ano) {
        $TPL->ANO_V = $ano;
        $TPL->block("BLOCK_ANO");
}
    if($pagina == 1)
    $TPL->DISABLEL = "disabled";
    
    if($pagina == $configPaginacao['totalPaginas'])
    $TPL->DISABLER = "disabled";

$TPL->show();

exit();
?>

