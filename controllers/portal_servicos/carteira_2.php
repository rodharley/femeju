<?php
include("includes/include.lockPortal.php");
include("plugins/wideimage/WideImage.php");
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

$foto = WideImage::load('img/pessoas/'.$atleta->pessoa->foto);
$fotoresize = $foto->resize(84, 113, 'fill');


$carteiracomfoto = $carteira->merge($fotoresize,541,18,100);

    $carteiracomfoto->output('jpg', 100);


//header('Content-type: image/png');
//imagepng($imagem);
?>