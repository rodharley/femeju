<?php
class libRelatorio {
	
	public function cabecalhoPadrao($titulo,$logo,$data = ""){
		$data = $data != "" ? $data :date("d/m/Y");
		
		$strheader = '<table class="header">
<tr>
<td rowspan="2" class="leftHeader"><img src="'.$logo.'" width="126px" /></td>
<td rowspan="2" class="centerHeader">'.$titulo.'</td>
<td class="rightHeader"></td>
</tr>
<tr>
<td class="rightHeader">Data:<br/>'.$data.'</td>
</tr>
</table>';
	return $strheader;
	}
	
	
public function rodapePadrao(){

$strfooter = '<table class="footer">
<tr>
<td>Judô Brasília - Federação Metropolitana de Judô - FEMEJU</td>
<td width="10%">Pág:<br/>{PAGENO} de {nbpg}</td>
</tr>
</table>
';
return $strfooter;
	}

public function setCabecalhoRodapePadrao($logo,$titulo,$data=""){
	$string = '<!--mpdf	';
	$string .= $this->cabecalhoPadrao($titulo,$logo,$data);
	$string .= $this->rodapePadrao();
$string .= '<sethtmlpageheader name="Header" page="O" value="on" show-this-page="1" />
<sethtmlpageheader name="Header" page="E" value="on" />
<sethtmlpagefooter name="Footer" page="O" value="on" show-this-page="1" />
<sethtmlpagefooter name="Footer" page="E" value="on" />
mpdf-->';
return $string;
}

}

?>