<?php
class libRelatorio {
	
	public function cabecalhoPadrao($titulo,$logo,$data = ""){
		$data = $data != "" ? $data :date("d/m/Y");
		
		$strheader = '<htmlpageheader name="Header">
<table class="header">
<tr>
<td rowspan="2" class="leftHeader"><img src="'.$logo.'" width="126px" /></td>
<td rowspan="2" class="centerHeader">'.$titulo.'</td>
<td class="rightHeader" colspan="2"></td>
</tr>
<tr>
<td class="rightHeader">Pág:<br/>{PAGENO} de {nbpg}</td>
<td class="rightHeader">Data:<br/>'.$data.'</td>
</tr>
</table>
</htmlpageheader>';
	return $strheader;
	}
	
	
public function rodapePadrao($empresa){

if($empresa->id != NULL){
		$strfooter = '<htmlpagefooter name="Footer">
<table class="footer">
<tr>
<td>CNPJ:'.$empresa->cnpj.' - '.$empresa->razaoSocial.
'<br/>'.$empresa->logradouro.' - '.$empresa->bairro.' - '.$empresa->cidade->nome.'-'.$empresa->cidade->uf->uf.
'<br/>CEP: '.$empresa->cep.' - Telefone: '.$empresa->telefone.' - Email: '.$empresa->email.
'</td>
</tr>
</table>
</htmlpagefooter>';
}else{
		$strfooter = '<htmlpagefooter name="Footer">
<table class="footer">
<tr>
<td><center>
Cadmo Engenharia</center>
</td>
</tr>
</table>
</htmlpagefooter>';	
}
return $strfooter;
	}

public function setCabecalhoRodapePadrao($empresa,$logo,$titulo,$data=""){
	$string = '<!--mpdf	';
	$string .= $this->cabecalhoPadrao($titulo,$logo,$data);
	$string .= $this->rodapePadrao($empresa);
$string .= '<sethtmlpageheader name="Header" page="O" value="on" show-this-page="1" />
<sethtmlpageheader name="Header" page="E" value="on" />
<sethtmlpagefooter name="Footer" page="O" value="on" show-this-page="1" />
<sethtmlpagefooter name="Footer" page="E" value="on" />
mpdf-->';
return $string;
}

}

?>