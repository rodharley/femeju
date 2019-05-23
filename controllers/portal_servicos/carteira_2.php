<?php
include("includes/include.lockPortal.php");
include("plugins/wideimage/WideImage.php");
include('plugins/phpqrcode/qrlib.php');

$conf = new Configuracoes();
$atleta = new Atleta();
$associacao = new Associacao();
$conf->getById(10);
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
//gera a imagem de fundo;
$rgb= $conf->hex2rgb($conf->valor);
$imagem = imagecreatetruecolor(643,209);
$red = imagecolorallocate($imagem, $rgb[0],$rgb[1],$rgb[2]);
imagefill($imagem,0,0,$red);

$logo = WideImage::load('img/carteirinha.png');
$img = WideImage::load($imagem);
$carteira = $img->merge($logo,0,0,100);
$imagemAtleta = $atleta->pessoa->foto != "" ? $atleta->pessoa->foto : "pessoa.png";
$foto = WideImage::load('img/pessoas/'.$imagemAtleta);
$fotoresize = $foto->resize(84, 113, 'fill');
$carteiracomfoto = $carteira->merge($fotoresize,541,18,100);


//gera o qrcode
QRcode::png($atleta->getId(),"img/pessoas/".$atleta->getId().".png",4,8,2);
$qrcode = WideImage::load('img/pessoas/'.$atleta->getId().".png");
$qrcoderesize = $qrcode->resize(70, 70, 'fill');
$carteiracomfotoeqrcode = $carteiracomfoto->merge($qrcoderesize,547,133,100);

//assinatura do presidente
$assinatura = WideImage::load('img/assinatura.png');
$assintauraresize = $assinatura->resize(84, 100, 'fill');
$carteiracomfotoeqrcodeAssinada = $carteiracomfotoeqrcode->merge($assintauraresize,130,138,100);


//escreve na carteirinha
$canvas = $carteiracomfotoeqrcodeAssinada->getCanvas();

//verso
$canvas->useFont(URI.'/fonts/SourceSansPro-Regular.ttf', '10', $carteiracomfotoeqrcodeAssinada->allocateColor(0, 0, 0));
$canvas->writeText('20', '34', $atleta->associacao->nome, 0);
$canvas->writeText('20', '70', $atleta->pessoa->getNomeCompleto(), 0);
$canvas->writeText('20', '106', $atleta->graduacao->descricao." - ".$atleta->graduacao->faixa, 0);
$canvas->writeText('220', '106', $atleta->convdata($atleta->pessoa->dataNascimento, "mtn"), 0);
$dttime = strtotime($atleta->dataEmissaoCarteira);
$ano = date("Y",$dttime);
$val = mktime(0,0,0,12,31,$ano);
$canvas->writeText('20', '142', date("d",$val)." de ".$atleta->mesExtenso(date("m",$val))." de ".date("Y",$val), 0);
//registro
$canvas->useFont(URI.'/fonts/SourceSansPro-Bold.ttf', '12', $carteiracomfotoeqrcodeAssinada->allocateColor(0, 0, 0));
$canvas->writeText('350', '140', $atleta->pessoa->nome. ' ' . $atleta->pessoa->sobrenome, 0);
$canvas->writeText('350', '160', 'Registro N�:'.$atleta->getId(), 0);


$carteiracomfotoeqrcodeAssinada->saveToFile("img/pessoas/carteira".$atleta->getId().".png");
header("Location:relatorios/carteira.php?id=".$atleta->getId());
exit;

//header('Content-type: image/png');
//imagepng($imagem);
?>