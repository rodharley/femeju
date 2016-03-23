<?php
include("includes/include.lockPortal.php");
include("plugins/wideimage/WideImage.php");
include('plugins/phpqrcode/qrlib.php');
include("plugins/mpdf/mpdf.php");

$conf = new Configuracoes();
$atleta = new Atleta();
$associacao = new Associacao();
$conf->getById(10);
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
if($atleta->ativo == 1 ){
//gera a imagem de fundo;
$rgb= $conf->hex2rgb($conf->valor);
$imagem = imagecreatetruecolor(650,204);
$red = imagecolorallocate($imagem, $rgb[0],$rgb[1],$rgb[2]);
imagefill($imagem,0,0,$red);

$logo = WideImage::load('img/carteirinha.png');
$carteiraf = $logo -> resize(650, 204, 'fill');
$img = WideImage::load($imagem);
$carteira = $img->merge($carteiraf,0,0,100);
$imagemAtleta = $atleta->pessoa->foto != "" ? $atleta->pessoa->foto : "pessoa.png";
$foto = WideImage::load('img/pessoas/'.$imagemAtleta);
$fotoresize = $foto->resize(84, 113, 'fill');
$carteiracomfoto = $carteira->merge($fotoresize,552,12,100);


//gera o qrcode
QRcode::png($atleta->getId()."-".$atleta->pessoa->getNomeCompleto(),"img/pessoas/".$atleta->getId().".png",4,8,2);
$qrcode = WideImage::load('img/pessoas/'.$atleta->getId().".png");
$qrcoderesize = $qrcode->resize(70, 70, 'fill');
$carteiracomfotoeqrcode = $carteiracomfoto->merge($qrcoderesize,558,130,100);

//assinatura do presidente
$assinatura = WideImage::load('img/assinatura.png');
$assintauraresize = $assinatura->resize(84, 100, 'fill');
$carteiracomfotoeqrcodeAssinada = $carteiracomfotoeqrcode->merge($assintauraresize,130,138,100);


//escreve na carteirinha
$canvas = $carteiracomfotoeqrcodeAssinada->getCanvas();

//verso displays
$canvas->useFont('fonts/SourceSansPro-Regular.ttf', '8', $carteiracomfotoeqrcodeAssinada->allocateColor(0, 0, 0));
$canvas->writeText('20', '16', "Associa��o", 0);
$canvas->writeText('20', '52', "Nome", 0);
$canvas->writeText('20', '88', "Gradua��o", 0);
$canvas->writeText('200', '88', "Data de Nascimento", 0);
$canvas->writeText('20', '124', "Validade", 0);
$canvas->writeText('120', '178', "Assinatura Femeju", 0);

//verso
$canvas->useFont('fonts/SourceSansPro-Regular.ttf', '10', $carteiracomfotoeqrcodeAssinada->allocateColor(0, 0, 0));
$canvas->writeText('20', '34', $atleta->associacao->nome, 0);
$canvas->writeText('20', '70', $atleta->pessoa->getNomeCompleto(), 0);
$canvas->writeText('20', '106', $atleta->graduacao->descricao." - ".$atleta->graduacao->faixa, 0);
$canvas->writeText('220', '106', $atleta->convdata($atleta->pessoa->dataNascimento, "mtn"), 0);
$canvas->writeText('20', '142', '31 de Dezembro de '.Date('Y'), 0);

//registro
$canvas->useFont('fonts/SourceSansPro-Bold.ttf', '12', $carteiracomfotoeqrcodeAssinada->allocateColor(0, 0, 0));
$strnomeFrente = $atleta->pessoa->getNomeCompleto();
if(strlen($strnomeFrente) > 20){
$str_linha1 = "";
$str_linha2 = "";    
$arraynome = explode(" ", $strnomeFrente);
$controle = 0;
foreach ($arraynome as $key => $nome) {
    
    if(strlen($str_linha1.$arraynome[$key]) >= 20)
        $controle = 1;    
    
    if($controle == 1){      
        $str_linha2 .= $arraynome[$key]." ";
    }else{      
        $str_linha1 .= $arraynome[$key]." ";
    }    
        
}    


$canvas->writeText('350', '140', $str_linha1, 0);
$canvas->writeText('350', '160', $str_linha2, 0);
$canvas->writeText('350', '180', 'Registro N�:'.$atleta->getId(), 0);    
}else{
$canvas->writeText('350', '140', $atleta->pessoa->getNomeCompleto(), 0);
$canvas->writeText('350', '160', 'Registro N�:'.$atleta->getId(), 0);
}
$carteiracomfotoeqrcodeAssinada = $carteiracomfotoeqrcodeAssinada -> roundCorners(12);
$carteiracomfotoeqrcodeAssinada->saveToFile("img/pessoas/carteira".$atleta->getId().".png", 0, PNG_NO_FILTER);
header("Location:plugins/mpdf/relatorios/carteira.php?id=".$atleta->getId());
exit;
}else{
    echo "Situa��o Irregular, favor procurar a Femeju.";
}
//header('Content-type: image/png');
//imagepng($imagem);
?>