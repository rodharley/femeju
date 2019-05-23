<?php
include("includes/include.lockPortal.php");
include("plugins/wideimage/WideImage.php");
include('plugins/phpqrcode/qrlib.php');

$conf = new Configuracoes();
$atleta = new Atleta();
$associacao = new Associacao();
$conf->getById(10);
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
if($atleta->ativo == 1 ){



//gera a imagem de fundo na cor das configuracoes;
$rgb= $conf->hex2rgb($conf->valor);
$fundo = imagecreatetruecolor(318,550);
$cor = imagecolorallocate($fundo, $rgb[0],$rgb[1],$rgb[2]);
imagefill($fundo,0,0,$cor);

//recupera a carteirinha vertical
$carteira = WideImage::load('img/carteirinha_v.png');
$imgfundo = WideImage::load($fundo);
$carteira = $imgfundo->merge($carteira,0,0,100);

//coloca a foto
$foto = WideImage::load('img/pessoas/'.$atleta->pessoa->foto);
$fotoresize = $foto->resize(84, 113, 'fill');
$carteiracomfoto = $carteira->merge($fotoresize,218,13,100);


//gera o qrcode
QRcode::png($atleta->getId()."-".$atleta->pessoa->getNomeCompleto(),"img/pessoas/".$atleta->getId().".png",4,8,2);
$qrcode = WideImage::load('img/pessoas/'.$atleta->getId().".png");
$qrcoderesize = $qrcode->resize(150, 150, 'fill');
$carteiracomfotoeqrcode = $carteiracomfoto->merge($qrcoderesize,'50%-75',390,100);

//escreve na carteirinha
$canvas = $carteiracomfotoeqrcode->getCanvas();

//registro
$canvas->useFont(URI.'/fonts/SourceSansPro-Bold.ttf', '15', $carteiracomfotoeqrcode->allocateColor(0, 0, 0));
$canvas->writeText('15', '160', 'Registro NК:'.$atleta->getId(), 0);

$canvas->useFont(URI.'/fonts/SourceSansPro-Regular.ttf', '10', $carteiracomfotoeqrcode->allocateColor(255, 255, 255));
$canvas->writeText('15', '200', 'Associaчуo', 0);
$canvas->writeText('15', '240', 'Atleta', 0);
$canvas->writeText('15', '280', 'Graduaчуo', 0);
$canvas->writeText('150', '280', 'Data de Nascimento', 0);
$canvas->writeText('15', '320', 'Validade', 0);
$canvas->useFont(URI.'/fonts/SourceSansPro-Regular.ttf', '12', $carteiracomfotoeqrcode->allocateColor(0, 0, 0));
$canvas->writeText('15', '215', $atleta->associacao->nome, 0);
$canvas->writeText('15', '255', $atleta->pessoa->getNomeCompleto(), 0);
$canvas->writeText('15', '295', $atleta->graduacao->descricao." - ".$atleta->graduacao->faixa, 0);
$canvas->writeText('150', '295',$atleta->convdata($atleta->pessoa->dataNascimento, "mtn"), 0);
$canvas->writeText('15', '335', '31 de Dezembro de '.Date("Y"), 0);
$canvas->writeText('15', '355',"Vсlida CBJ", 0);
  
 
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $atleta->getId().".png" ); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

 $carteiracomfotoeqrcode->output('jpg', 100);
}else{
    echo "Situaчуo Irregular, favor procurar a Femeju.";
}

//header('Content-type: image/png');
//imagepng($imagem);
?>