<?php
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="pedidos.csv"');
$menu = 45;
include("includes/include.lock.php");

$ocomp = new Competicao();
$oass = new Associacao();
$oInsc = new Inscricao();
$csv = "";
$sql = "select a.* from " . Associacao::TABELA . " a inner join " . Atleta::TABELA . " b on b.idAssociacao = a.id inner join " . Inscricao::TABELA . " c on c.idAtleta = b.id where c.idCompeticao = " . $_REQUEST['evento'];
if($_REQUEST['associacao'] != ""){
$sql .= " and a.id = ".$_REQUEST['associacao'];
}
$sql .= " group by a.id";
$rs = $oass -> getSQL($sql);
foreach ($rs as $key => $value) {
	$sqli = "select i.* from ".Inscricao::TABELA." i inner join ".Atleta::TABELA." a on a.id = i.idAtleta where a.idAssociacao = ".$value->id." and i.idCompeticao = ".$_REQUEST['evento'];
	if(isset($_REQUEST['pago'])){
	$sqli .= " and i.situacao = 1 ";
	}
	$sqli .= " order by i.idClasse, i.idCategoria";
	$rsInsc = $oInsc -> getSQL($sqli);
	
	foreach ($rsInsc as $key2 => $inscricao) {
		$csv .= $inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome.",".$value -> nome.",".$inscricao->classe->descricao.",".$inscricao->categoria->descricao.chr(13);
		if($inscricao->dobra1 != null)
			$csv .= $inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome.",".$value -> nome.",".$inscricao->dobra1->classe->descricao.",".$inscricao->dobra1->descricao.chr(13);
		if($inscricao->dobra2 != null)
			$csv .= $inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome.",".$value -> nome.",".$inscricao->dobra2->classe->descricao.",".$inscricao->dobra2->descricao.chr(13);
		if($inscricao->dobra3 != null)
			$csv .= $inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome.",".$value -> nome.",".$inscricao->dobra3->classe->descricao.",".$inscricao->dobra3->descricao.chr(13);
						 
		
		 
	}
		
}
echo $csv;


?>