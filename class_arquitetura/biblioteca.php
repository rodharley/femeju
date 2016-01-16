<?php
class Biblioteca {

var $HASH_URL = 'femejubruno';
var $PAGINACAO = 15;

function retorna_hora($data){
	return substr($data, 10);
}

function salvarFoto($file, $nome, $diretorio) {
        $return = $this -> createthumb($file['name'], $file['tmp_name'], $diretorio . $nome, 215, 215);
    }


function limpaCpf($cpf){
return str_replace(".","",str_replace("-","", str_replace("/","", $cpf)));
}

function criaLogin($sufixo){
	return $sufixo."-".date("y-mdhis");
}
function getEnvs( $s_var ){
		$rs = false;
		if( @getenv( $s_var ) ){
		$rs = strtolower( getenv( $s_var ) );
		}else{
			if( isset( $_SERVER[$s_var] ) ){
			$rs = strtolower( $_SERVER[$s_var] );
			}
		}
		return $rs;
	}


function ultimoDiaMes($data){
$tsData = strtotime($data);
$ultimoDiaMes = date("t",$tsData);
return  date("Y",$tsData)."-".date("m",$tsData)."-".$ultimoDiaMes;
}

function mesExtenso($int){
switch($int){
case 1:
$str = "Janeiro";
break;
case 2:
$str = "Fevereiro";
break;
case 3:
$str = "MarÁo";
break;
case 4:
$str = "Abril";
break;
case 5:
$str = "Maio";
break;
case 6:
$str = "Junho";
break;
case 7:
$str = "Julho";
break;
case 8:
$str = "Agosto";
break;
case 9:
$str = "Setembro";
break;
case 10:
$str = "Outubro";
break;
case 11:
$str = "Novembro";
break;
case 12:
$str = "Dezembro";
break;
}
return  $str;
}

function limpaDigitos($texto){
return str_replace(".","",str_replace("-","",str_replace("/","",str_replace("_","",str_replace("(","",str_replace(")","",str_replace("+","",str_replace(" ","",$texto))))))));
}


function ValidaData($dat){
	$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como refer?ncia
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	// verifica se a data ? v?lida!
	// 1 = true (v?lida)
	// 0 = false (inv?lida)
	return checkdate($m,$d,$y);
}


function paginar ($total,$pagina,$paginacao = ""){

if($paginacao == "")
     $qtdPagina = $this->PAGINACAO;
else
    $qtdPagina = $paginacao;
if($pagina == "")
$pagina = 1;
$paginas = $total > 0 ? ceil($total / $qtdPagina) : 1;
$inicio =  $qtdPagina *($pagina-1);
if($pagina < $paginas)
$proximaPagina = $pagina+1;
else
$proximaPagina =  $paginas;

if($pagina > 1)
$paginaAnterior = $pagina-1;
else
$paginaAnterior = $pagina;
return array('totalPaginas'=>$paginas,'primeiroRegistro'=>$inicio,'proximaPagina'=>$proximaPagina,'paginaAnterior'=>$paginaAnterior,'quantidadePorPagina'=>$qtdPagina);
}






function resultadoAleatorio($array,$quantObjetos){



	$indiceArray = array_rand($array,$quantObjetos);



	return $indiceArray;

}





/*

================================================================

	RETIRA A UTIMA VIRGULA DA STRING DA CAMPO DA QUERY DO UPDATE

================================================================

*/



function substituiUtimaVirgula($palavra){



	 if($palavra = substr_replace($palavra,' ', strlen($palavra) - 1,  strlen($palavra)))

	 return  $palavra;

	 else false;

}





/*

================================================================

	DIFERENA ENTRE DATAS

	na pagina que chamar esta funao, colocar a data no seguinte formato

	$inicial = 00/00/0000

	$final = 00/00/0000

================================================================

*/

function diferenca_dias($inicial, $final) {

  list($dia_inicial, $mes_inicial, $ano_inicial) = explode("/", $inicial);

  list($dia_final, $mes_final, $ano_final) = explode("/", $final);



  $inicial2 = mktime(0,0,0,$mes_inicial,$dia_inicial,$ano_inicial);

  $final2 = mktime(0,0,0,$mes_final,$dia_final,$ano_final);



  $dias = ($final2 - $inicial2)/86400;



  return round($dias);

}

function diffDate($d1, $d2, $type='', $sep='-')
	{
	 $d1 = explode($sep, substr($d1,0,10));
	 $d2 = explode($sep, substr($d2,0,10));
	 switch ($type)
	 {
	 case 'A':
	 $X = 31536000;
break;
	 case 'M':
	 $X = 2592000;
	 break;
	 case 'D':
	 $X = 86400;
	 break;
 case 'H':
	 $X = 3600;
	 break;
	 case 'MI':
	 $X = 60;
	 break;
	 default:
	 $X = 1;
	 }
	 return floor((( mktime(0, 0, 0, $d2[1], $d2[2], $d2[0])- mktime(0, 0, 0, $d1[1], $d1[2], $d1[0]) ) / $X ) );
}

/*

================================================================

	CONVERSO DE VALORES

================================================================

*/



		function money($valor,$tipo){
			
				
			
			if($tipo == "bta"){
					
				if($valor != ""){
				$number = str_replace('.','',$valor);
				$final1 = str_replace(',','.',$number);
				$final = $final1;
				}else{
				$final = "0.00";
				}

			}elseif($tipo == "atb"){
				if($valor != ""){
				$final = number_format($valor, 2, ',','.');
				}else{
				$final = "0,00";
				}

			}else{

				$final = "2 parmetro deve ser bta ou atb";

			}
			

			return $final;

		}





















		/*

================================================================

 Verifica e-mail

================================================================

*/









		function verificar_email($email){

   $mail_correcto = 0;

   //verifico umas coisas

   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){

      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {

         //vejo se tem caracter .

         if (substr_count($email,".")>= 1){

            //obtenho a terminao do dominio

            $term_dom = substr(strrchr ($email, '.'),1);

            //verifico que a terminao do dominio seja correcta

         if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){

            //verifico que o de antes do dominio seja correcto

            $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);

            $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);

            if ($caracter_ult != "@" && $caracter_ult != "."){

               $mail_correcto = 1;

            }

         }

      }

   }

}



if ($mail_correcto)

   return 1;

else

   return 0;

}















/*

================================================================

	CONVERSO DE DATA

================================================================

*/





		function convdata($dataentra,$tipo){
		if(strlen($dataentra) > 0 ){
		  if ($tipo == "mtn") {

			$datasentra = explode("-",$dataentra);

			$indice=2;

			while($indice != -1){

			  $datass[$indice] = $datasentra[$indice];

			  $indice--;

			}

			$datasaida=implode("/",$datass);

		  } elseif ($tipo == "ntm") {

			$datasentra = explode("/",$dataentra);

			$indice=2;

			while($indice != -1){

			  $datass[$indice] = $datasentra[$indice];

			  $indice--;

			}

			$datasaida = implode("-",$datass);

		  } elseif ($tipo == "mtnh") {

			$datasentra = explode("-",substr($dataentra,0,10));

			$indice=2;

			while($indice != -1){

			  $datass[$indice] = $datasentra[$indice];

			  $indice--;

			}

			$datasaida= implode("/",$datass);
			$datasaida .= substr($dataentra,10);

		  } else {

			$datasaida = "";

		  }
		
		}else{
			$datasaida = "";
		}
		  return $datasaida;

		}



		function valida_datas($d1,$d2){

			$data1 = explode('/',$d1);

			$primeira = $data1[2].$data1[1].$data1[0];



			$data2 = explode('/',$d2);

			$segunda = $data2[2].$data2[1].$data2[0];



			if ($segunda > $primeira) {

				$maior = false;

				}else{$maior = true;

			}



			if(!checkdate(substr($d1,3,2),substr($d1,0,2),substr($d1,6,4))|| !checkdate(substr($d2,3,2),substr($d2,0,2),substr($d2,6,4)) || $maior){

				$final = true;}else{

				$final = false;}

				return $final;

			}





		function valida_data($d1){

			if(!checkdate(substr($d1,3,2),substr($d1,0,2),substr($d1,6,4))){

			$final = true;}else{

			$final = false;}

			return $final;

		}



/*

================================================================

	CONEXAO

================================================================

*/

		function makeSQL($sql){

		$result = mysql_query($sql)or die('

		<table width="300" height="200" border="0" align="center" cellpadding="0" cellspacing="0">

          <thead>

		  <tr>

            <td width="9" height="37"><img src="img/pc5.gif" width="9" height="37" /></td>

            <td background="img/pc11.gif">Erro</td>

            <td width="9"><img src="img/pc6.gif" width="9" height="37" /></td>

          </tr>

		  </thead>

		  <tbody>

          <tr>

            <td background="img/pc9.gif">&nbsp;</td>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="8" class="tbForm">

              <tr>

                <td>'.mysql_error().'</td>

              </tr>

			  <tr>

                <td>'.$sql.'</td>

              </tr>

            </table>

              </td>

            <td background="img/pc10.gif">&nbsp;</td>

          </tr>

		  </tbody>

		  <tfoot>

          <tr>

            <td height="9"><img src="img/pc7.gif" width="9" height="9" /></td>

            <td background="img/pc12.gif"></td>

            <td><img src="img/pc8.gif" width="9" height="9" /></td>

          </tr>

		  </tfoot>

        </table>');

		return $result;

		}





//----------------------------------------------------------------------------------------------------------------------

function mail_html($destinatario,$origem, $titulo, $mensagem)

{


	try{
	$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Femeju <$origem>"."\n"; // remetente
$headers .= "Return-Path: Femeju <$origem>"."\n"; // return-path
$email = @mail("$destinatario", "$titulo", "$mensagem", $headers, "-r".$origem);	
			
	return $email;
	}catch(exception $e){
		return false;
	}

}

function makePassword($digitos){

$alpha = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","w","x","y","z","0","1","2","3","4","5","6","7","8","9");

	$senha = "";

	for ($i=0;$i<$digitos;$i++){

	$key = array_rand($alpha);

	$senha .= $alpha[$key];

	}

	return $senha;

}



function alert($mensagem){

echo '<script>window.alert("'.$mensagem.'");</script>';

return true;

}

function jsReturn($pagina){

echo '<script>history.go('.$pagina.');</script>';

return true;

}


function location($url,$mensagem){

$str = '<script>';

if($mensagem != ""){

$str .= 'window.alert("'.$mensagem.'");';

}

if($url != ""){

$str .= 'window.location.href="'.$url.'";';

}



$str .= '</script>';

echo $str;

exit();

}

function locationNewPage($url,$parametros){

$str = '<script>';

$str .= 'window.open("'.$url.'","'.$parametros.'")';

$str .= '</script>';

echo $str;

}



function locationOpener($url,$mensagem){

$str = '<script>';

if($mensagem != ""){

$str .= 'window.alert("'.$mensagem.'");';

}

if($url != ""){

$str .= 'window.opener.location.href="'.$url.'";';

$str .= 'window.close();';

}



$str .= '</script>';

echo $str;

return  true;

}



function javascript($script){

echo '<script>'.$script.'</script>';

return true;

}



function listObject($recset){

$arrayObj = array();

	while($row = mysql_fetch_array($recset)){

	array_push($arrayObj,$row);

	}

return $arrayObj;

}



function removeSQL($param){

$string = str_replace(";","",$param);

$string = str_replace("'","",$string);

$string = str_replace("\"","",$string);

return $string;

}

//CONVERTE MINUTOS EM DIA HORA MINUTOS

function convmin($m){

if($m > 1440){

$dias = floor($m/1440);

$resto = $m -($dias*1440);

	if($resto > 60){

	$horas = floor($resto/60);

	$resto = $resto -($horas*60);

	}else{

	$horas = 0;

	$resto = $resto;

	}

}else{

$dias = 0;

$resto = $m;

	if($resto > 60){

	$horas = floor($resto/60);

	$resto = $resto -($horas*60);

	}else{

	$horas = 0;

	$resto = $resto;

	}

}

$string = "";

if ($dias > 0)

$string .= $dias." dia(s) ";

if($horas > 0)

$string .= $horas." hora(s) ";

if($resto > 0)

$string .=  $resto." minutos ";

return $string;

}



//-------------------------------------



//CONVERTE GRAMAS EM KILOS----------------



function convKilo($valor,$tipo){

if($tipo == "gtk"){

return number_format($valor/1000,3,",",".");

}else{

return number_format($valor*1000);

}



}



function convKiloAmericano($valor,$tipo){

if($tipo == "gtk"){

return number_format($valor/1000,1,".",",");

}else{

return number_format($valor*1000);

}



}

//----------------------------------------

//mtodos get e set genrico

function setCampo($valor,$campo){

$this->$campo = $valor;

return true;

}



function getCampo($campo){

return $this->$campo;

}

function setAllFieldsTheClass($Array){

	foreach ($Array as $field => $value) {

		$this->setCampo($value,$field);

	}

	return true;

}



/*
================================================================
	REMOVE CARACTERE
================================================================
*/
function removerAcento($palavra){

	return	preg_replace( '/[`^~\'"]/', null, iconv( 'ISO-8859-1', 'ASCII//TRANSLIT', $palavra ) );
	
	}



function apagaImagem($nomeImagem,$diretorio)	{
	if($nomeImagem != ""){
	if(file_exists($diretorio.$nomeImagem)){


		if(unlink($diretorio . $nomeImagem)) {
			return(true);
		} else {
			return(false);
		}

		}else{
		return(false);
		}
	}else{
		return(false);
	}

	}

function retornaNomeUnico($nomeImagem,$diretorio,$i=0)	{
		$nomeImagem = $this->removerAcento($nomeImagem);
		if(file_exists($diretorio.$nomeImagem)){
		$i++;
		$pos = strpos($nomeImagem,".");
		$nome = substr($nomeImagem,0,$pos).$i.substr($nomeImagem,$pos);
		return $this->retornaNomeUnico($nome,$diretorio,$i);
		}else{
		return $nomeImagem;
		}


	}

/*
================================================================
	UPLOAD DE IMAGEM: basta passar como parametros  a diretiva $_FILES, nome da imagem tratado e o caminho do diretorio.
================================================================
*/
function uploadImagem($file,$nomeImagem,$diretorio){

if($file['name'] != ""){
		if($file["type"] == "image/gif" || $file["type"] == "image/pjpeg" || $file["type"] == "image/jpeg" || $file["type"] == "image/png"  || $file["type"] == "image/x-png" ){

		copy($file['tmp_name'],$diretorio."".$nomeImagem);
			return true;
	    }// fim if 2 type file
		else {
		$_SESSION['fmj.mensagem'] = 16;
		return false;
	 }

	}// fim if 1 file name
	else{
	return false;
	}
}
function uploadImagemArray($file,$key,$nomeImagem,$diretorio){

if($file['name'][$key] != ""){
        if($file["type"][$key] == "image/gif" || $file["type"][$key] == "image/pjpeg" || $file["type"][$key] == "image/jpeg" || $file["type"][$key] == "image/png"  || $file["type"][$key] == "image/x-png" ){
         
          copy($file['tmp_name'][$key],$diretorio."".$nomeImagem);
            return true;
        }// fim if 2 type file
        else {
        $_SESSION['fmj.mensagem'] = 16;
        return false;
     }

    }// fim if 1 file name
    else{
    return false;
    }
}


function uploadArquivo($file,$nomeImagem,$diretorio){
	if($file['name'] != ""){		
		copy($file['tmp_name'],$diretorio."".$nomeImagem);
	}// fim if 1 file name





}


function formataTelefone($tel){
if(strlen($tel) > 12){
$p1 = substr($tel,0,2);
$p2 = substr($tel,2,2);
$p3 = substr($tel,4,5);
$p4 = substr($tel,9);
}else{
$p1 = substr($tel,0,2);
$p2 = substr($tel,2,2);
$p3 = substr($tel,4,4);
$p4 = substr($tel,8);    
}
return '+'.$p1.' '.$p2." ".$p3."-".$p4;

}

function formataCep($cep){

$p1 = substr($cep,0,5);

$p2 = substr($cep,5,3);

return $p1.'-'.$p2;

}

function formataCPFCNPJ($cpf){

	if (strlen($cpf) == 11){

		$p1 = substr($cpf,0,3);

		$p2 = substr($cpf,3,3);

		$p3 = substr($cpf,6,3);

		$p4 = substr($cpf,9,2);

		return $p1.'.'.$p2.'.'.$p3.'-'.$p4;

	}

	else{

		if (strlen($cpf) == 14){

			$p1 = substr($cpf,0,2);

			$p2 = substr($cpf,2,3);

			$p3 = substr($cpf,5,3);

			$p4 = substr($cpf,8,4);

			$p5 = substr($cpf,12,2);

			return $p1.'.'.$p2.'.'.$p3.'/'.$p4.'-'.$p5;

		}

		else{

			$cpf;

		}

	}

}







//*********************************************************************************

/*

================================================================

	retorna valor por extenso em reais passar os parametros: $valor como string e $maiusculas como

	true ou false

================================================================

*/



function extenso($valor,$maiusculas)

{

    // verifica se tem virgula decimal

    if (strpos($valor,",") > 0)

    {

      // retira o ponto de milhar, se tiver

      $valor = str_replace(".","",$valor);



      // troca a virgula decimal por ponto decimal

      $valor = str_replace(",",".",$valor);

    }



        $singular = array("centavo", "real", "mil", "milh„o", "bilh„o", "trilh„o", "quatrilh„o");

        $plural = array("centavos", "reais", "mil", "milh√µes", "bilh√µes", "trilh√µes",

"quatrilh√µes");



        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",

"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");

        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",

"sessenta", "setenta", "oitenta", "noventa");

        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",

"dezesseis", "dezesete", "dezoito", "dezenove");

        $u = array("", "um", "dois", "trs", "quatro", "cinco", "seis",

"sete", "oito", "nove");



        $z=0;



        $valor = number_format($valor, 2, ".", ".");

        $inteiro = explode(".", $valor);

        for($i=0;$i<count($inteiro);$i++)

                for($ii=strlen($inteiro[$i]);$ii<3;$ii++)

                        $inteiro[$i] = "0".$inteiro[$i];



        $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);

        for ($i=0;$i<count($inteiro);$i++) {

                $valor = $inteiro[$i];

                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];

                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];

                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";



                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&

$ru) ? " e " : "").$ru;

                $t = count($inteiro)-1-$i;

                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";

                if ($valor == "000")$z++; elseif ($z > 0) $z--;

                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];

                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&

($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;

        }



         if(!$maiusculas){

                          return($rt ? $rt : "zero");

         } elseif($maiusculas == "2") {

                          return (strtoupper($rt) ? strtoupper($rt) : "Zero");

         } else {

                          return (ucwords($rt) ? ucwords($rt) : "Zero");

         }



}



function removeCaracteres($str){
return strtr($str,"?????????????????????? ????????????????????????,;:?.","aaaaaeeeeiiiiooooouuuu_AAAAAEEEEIIIIOOOOOUUUUcC_____");
}


function modCaixaAlta($str){

return strtr(strtoupper($str),"","");

}

function msg($id){

$sql = "select texto from msg where idMsg = ".$id;

$rs = $this->makeSQL($sql);



if($this->DAO_NumeroLinhas($rs) == 0)

return "Erro no sistema desconhecido!";

else{

$r = $this->DAO_GerarArray($rs);

return $r['texto'];

}

}



function notInjection($str){

$strFim = str_replace(" or ","",str_replace(" = ","",$str));

return $strFim;

}



function bloqueiaComandoStatusEvento($listaPermitida,$status,$retorno){
	if(stripos($listaPermitida,$status)=== false){

	$this->location($retorno,"Comando no pode ser executado, estatus do evento no permite.");

	exit();

	}

}



function convertImgUrls($texto){
if($_SERVER['SERVER_PORT'] == 80)
$url = "http://".$_SERVER['HTTP_HOST'];
else
$url = "https://".$_SERVER['HTTP_HOST'];
return str_replace("/imagens/images/",$url."/imagens/images/",$texto);
}


function antiInjection2($str) { #Remove palavras suspeitas de injection.
$sqlWords = "/([Ff][Rr][Oo][Mm]|[Ss][Ee][Ll][Ee][Cc][Tt]|[Cc][Oo][Uu][Nn][Tt]|[Tt][Rr][Uu][Nn][Cc][Aa][Tt][Ee]|[Ee][Xx][Pp][Ll][Aa][Ii][Nn]|[Ii][Nn][Ss][Ee][Rr][Tt]|[Dd][Ee][Ll][Ee][Tt][Ee]|[Ww][Hh][Ee][Rr][Ee]|[Uu][Pp][Dd][Aa][Tt][Ee]|[Ee][Mm][Pp][Tt][Yy]|[Dd][Rr][Oo][Pp] [Tt][Aa][Bb][Ll][Ee]|[Ll][Ii][Mm][Ii][Tt]|[Ss][Hh][Oo][Ww] [Tt][Aa][Bb][Ll][Ee][Ss]|[Oo][Rr]|[Oo][Rr][Dd][Ee][Rr] [Bb][Yy]|#|\*|--|\\\)/";
$value = preg_replace($sqlWords,'',$str);
//$str = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|or|from|select|insert|delete|where|drop table|show tables|show tables|\*|--|\\\\)/"), "", $str);
//$str = str_replace('../','',$str);
//$str = str_replace('/&#117;s&#101;rf&#105;&#108;&#101;s/','http://img.msisites.com.br/',$str);

//$str = str_replace('/&#117;s&#101;rf&#105;&#108;&#101;s/','http://img.msisites.com.br/',$str);
//$str = trim($str); # Remove espa?os vazios.
//$str = strip_tags($str); # Remove tags HTML e PHP.
//$str = addslashes($str); # Adiciona barras invertidas ? uma string.
return $value;
}


function localizaType($tipo){
$retorno = "iconUKN.gif";
foreach ($this->mimeTypes2 as $key => $value) {
    $pos = strpos($value,$tipo);
	if($pos !== false){
	$retorno = $key;
	}
}
return $retorno;
}

function md5_encrypt($plain_text, $iv_len = 16)

{

   $plain_text .= "x13";

   $n = strlen($plain_text);

   if ($n % 16) $plain_text .= str_repeat("{TEXTO}", 16 - ($n % 16));

   $i = 0;

   $enc_text = $this->get_rnd_iv($iv_len);

   $iv = substr($this->HASH_URL ^ $enc_text, 0, 512);

   while ($i < $n) {

      $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));

      $enc_text .= $block;

      $iv = substr($block . $iv, 0, 512) ^ $this->HASH_URL;

      $i += 16;

   }
	return base64_encode($enc_text);
   ///return str_replace(" ","nbsp*",base64_encode($enc_text));

}



function get_rnd_iv($iv_len)

{

   $iv = '';

   while ($iv_len-- > 0) {

      $iv .= chr(mt_rand() & 0xff);

   }

   return $iv;

}



function md5_decrypt($enc_text, $iv_len = 16)

{

    //$enc_text = str_replace("nbsp*","+",$enc_text);

	$enc_text = str_replace(" ","+",$enc_text);

   $enc_text = base64_decode($enc_text);

   $n = strlen($enc_text);

   $i = $iv_len;

   $plain_text = '';

   $iv = substr($this->HASH_URL ^ substr($enc_text, 0, $iv_len), 0, 512);



   while ($i < $n) {

      $block = substr($enc_text, $i, 16);

      $plain_text .= $block ^ pack('H*', md5($iv));

      $iv = substr($block . $iv, 0, 512) ^ $this->HASH_URL;

      $i += 16;

   }



   $posF = strpos($plain_text,"x13{");

   if( strlen($posF) == 0)

   $posF = strpos($plain_text,"x13");

   //return preg_replace('/\x13\x00*$/', '', $plain_text);

   return substr($plain_text,0,$posF);

}

function trataRequestAntiInjection(){
	$Array = $_REQUEST;
	$arrayName = array_keys($Array);
	$re ='';
	for($b=0;$b<count($arrayName);$b++){
		if(!is_array($_REQUEST[$arrayName[$b]])){
			@$_REQUEST[$arrayName[$b]] = $this->antiInjection2($_REQUEST[$arrayName[$b]]);
		}
	}
}

function setMensagem($id,$param1 = null,$param2= null,$param3= null){
	$_SESSION['fmj.mensagem'] = $id;
	if($param1 != null)
		$_SESSION['fmj.param1'] = $param1;
	if($param2 != null)
		$_SESSION['fmj.param2'] = $param2;
	if($param3 != null)
		$_SESSION['fmj.param3'] = $param3;
}

function unSetMensagem(){
	 unset($_SESSION['fmj.mensagem']);
	 unset($_SESSION['fmj.param1']);
	 unset($_SESSION['fmj.param2']);
	 unset($_SESSION['fmj.param3']);
}


function createthumb($orig_name, $name, $newname, $new_w, $new_h, $border=false, $transparency=true, $base64=false) {
    if(file_exists($newname))
        @unlink($newname);
    if(!file_exists($name))
        return false;
    $arr = explode(".",$orig_name);
    $ext = strtolower($arr[count($arr)-1]);	
	$img = false;
    if($ext=="jpeg" || $ext=="jpg"){
        $img = @imagecreatefromjpeg($name);
    } elseif($ext=="png"){
        $img = @imagecreatefrompng($name);
    } elseif($ext=="gif") {
        $img = @imagecreatefromgif($name);
    }
    if(!$img)
        return false;
    $old_x = imageSX($img);
    $old_y = imageSY($img);
    if($old_x < $new_w && $old_y < $new_h) {
       
	    $thumb_w = $old_x;
        $thumb_h = $old_y;
    } elseif ($old_x > $old_y) {
    	
        $thumb_w = $new_w;
        $thumb_h = floor(($old_y * $new_w)/$old_x);       
    } else{
    	
        $thumb_w = floor(($old_x*$new_h)/$old_y);
        $thumb_h = $new_h;
	}
	
    $thumb_w = ($thumb_w<1) ? 1 : $thumb_w;
    $thumb_h = ($thumb_h<1) ? 1 : $thumb_h;
	
    $new_img = ImageCreateTrueColor($thumb_w, $thumb_h);
   
    if($transparency) {
        if($ext=="png") {
            imagealphablending($new_img, false);
            $colorTransparent = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
            imagefill($new_img, 0, 0, $colorTransparent);
            imagesavealpha($new_img, true);
        } elseif($ext=="gif") {
            $trnprt_indx = imagecolortransparent($img);
            if ($trnprt_indx >= 0) {
                //its transparent
                $trnprt_color = imagecolorsforindex($img, $trnprt_indx);
                $trnprt_indx = imagecolorallocate($new_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                imagefill($new_img, 0, 0, $trnprt_indx);
                imagecolortransparent($new_img, $trnprt_indx);
            }
        }
    } else {
        Imagefill($new_img, 0, 0, imagecolorallocate($new_img, 255, 255, 255));
    }
   
    imagecopyresampled($new_img, $img, 0,0,0,0, $thumb_w, $thumb_h, $old_x, $old_y);
    if($border) {
        $black = imagecolorallocate($new_img, 0, 0, 0);
        imagerectangle($new_img,0,0, $thumb_w, $thumb_h, $black);
    }
    if($base64) {
        ob_start();
        imagepng($new_img);
        $img = ob_get_contents();
        ob_end_clean();
        $return = base64_encode($img);
    } else {
        if($ext=="jpeg" || $ext=="jpg"){
            imagejpeg($new_img, $newname);
            $return = true;
        } elseif($ext=="png"){
            imagepng($new_img, $newname);
            $return = true;
        } elseif($ext=="gif") {
            imagegif($new_img, $newname);
            $return = true;
        }
    }
    imagedestroy($new_img);
    imagedestroy($img);
    return $return;
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function rgb2hex($rgb) {
   $hex = "#";
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

   return $hex; // returns the hex value including the number sign (#)
}

}//FIM DA CLASSE
?>