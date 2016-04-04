<?php
$menu = 43;
include ("includes/include.lock.php");
include ("plugins/wideimage/WideImage.php");
include ('plugins/phpqrcode/qrlib.php');
include ("plugins/mpdf/mpdf.php");

//INSTACIA CLASSES
 $objH = new HistoricoGraduacao();
    $conf = new Configuracoes();
    $atleta = new Atleta();
    $associacao = new Associacao();
    $conf -> getById(10);
//ACOES
if (isset($_REQUEST['acao'])) {
    switch ($_REQUEST['acao']) {
        case 'carteira' :
            $numeros = "";
            //echo "<html><body style='margin:0;'>";
            foreach ($_REQUEST['atletas'] as $key => $value) {
                $atleta -> getById($value);
                $numeros .= $atleta ->numeroFemeju.",";    
                //gera a imagem de fundo;
                $rgb = $conf -> hex2rgb($conf -> valor);
                $imagem = imagecreatetruecolor(650, 408);
                $red = imagecolorallocate($imagem, $rgb[0], $rgb[1], $rgb[2]);
                imagefill($imagem, 0, 0, $red);

                $logo = WideImage::load('img/carteirinha_frente.png');
                $carteiraf = $logo -> resize(650, 408, 'fill');
                $img = WideImage::load($imagem);
                $carteira = $img -> merge($carteiraf, 0, 0, 100);
                $imagemAtleta = $atleta -> pessoa -> foto != "" ? $atleta -> pessoa -> foto : "pessoa.png";
                $foto = WideImage::load('img/pessoas/' . $imagemAtleta);
                $fotoresize = $foto -> resize(160, 216, 'fill');
                $carteiracomfoto = $carteira -> merge($fotoresize, 460, 28, 100);

                //gera o qrcode
                QRcode::png($atleta -> getId() . "-" . $atleta -> pessoa -> getNomeCompleto(), "img/pessoas/" . $atleta -> getId() . ".png", 4, 8, 2);
                $qrcode = WideImage::load('img/pessoas/' . $atleta -> getId() . ".png");
                $qrcoderesize = $qrcode -> resize(140, 140, 'fill');
                $carteiracomfotoeqrcode = $carteiracomfoto -> merge($qrcoderesize, 470, 260, 100);
                unlink('img/pessoas/' . $atleta -> getId() . ".png");
                
                

                //escreve na carteirinha
                $canvas = $carteiracomfotoeqrcode -> getCanvas();
                
                
                //registro
                $canvas -> useFont('fonts/SourceSansPro-Bold.ttf', '20', $carteiracomfotoeqrcode -> allocateColor(0, 0, 0));
                $strnomeFrente = $atleta -> pessoa -> getNomeCompleto();
                if (strlen($strnomeFrente) > 20) {
                    $str_linha1 = "";
                    $str_linha2 = "";
                    $arraynome = explode(" ", $strnomeFrente);
                    $controle = 0;
                    foreach ($arraynome as $key => $nome) {

                        if (strlen($str_linha1 . $arraynome[$key]) >= 20)
                            $controle = 1;

                        if ($controle == 1) {
                            $str_linha2 .= $arraynome[$key] . " ";
                        } else {
                            $str_linha1 .= $arraynome[$key] . " ";
                        }

                    }

                    $canvas -> writeText('80', '270', $str_linha1, 0);
                    $canvas -> writeText('80', '310', $str_linha2, 0);
                    $canvas -> writeText('80', '350', 'Registro Nº:' . $atleta -> getId(), 0);
                } else {
                    $canvas -> writeText('80', '270', $atleta -> pessoa -> getNomeCompleto(), 0);
                    $canvas -> writeText('80', '270', 'Registro Nº:' . $atleta -> getId(), 0);
                }
                
                $carteiracomfotoeqrcode = $carteiracomfotoeqrcode -> roundCorners(12);
                
                $carteiracomfotoeqrcode = $carteiracomfotoeqrcode -> rotate(270);
                
                
                
                
                $carteiracomfotoeqrcode -> saveToFile("img/pessoas/carteira_frente" . $atleta -> getId() . ".png", 0, PNG_NO_FILTER);
                
                //verso
                $verso = WideImage::load('img/carteirinha_verso.png');
                $carteirav = $verso -> resize(650, 408, 'fill');
                //escreve na carteirinha
                $canvas = $carteirav -> getCanvas();
                
                //verso displays
                $canvas -> useFont('fonts/SourceSansPro-Regular.ttf', '16', $carteirav -> allocateColor(0, 0, 0));
                $canvas -> writeText('40', '32', "Associação", 0);
                $canvas -> writeText('40', '104', "Nome", 0);
                $canvas -> writeText('40', '178', "Graduação", 0);
                $canvas -> writeText('400', '178', "Data de Nascimento", 0);
                $canvas -> writeText('40', '248', "Validade", 0);
                $canvas -> writeText('240', '354', "Assinatura Femeju", 0);

                //verso
                $canvas -> useFont('fonts/SourceSansPro-Regular.ttf', '20', $verso -> allocateColor(0, 0, 0));
                $canvas -> writeText('40', '68', $atleta -> associacao -> nome, 0);
                $canvas -> writeText('40', '140', $atleta -> pessoa -> getNomeCompleto(), 0);
                $canvas -> writeText('40', '212', $atleta -> graduacao -> descricao . " - " . $atleta -> graduacao -> faixa, 0);
                $canvas -> writeText('440', '212', $atleta -> convdata($atleta -> pessoa -> dataNascimento, "mtn"), 0);
                $canvas -> writeText('40', '284', '31 de Dezembro de ' . Date('Y'), 0);
            
            //assinatura do presidente
                $assinatura = WideImage::load('img/assinatura.png');
                $assintauraresize = $assinatura -> resize(168, 200, 'fill');
                $carteiraverso = $carteirav -> merge($assintauraresize, 260, 276, 100);
            
                $carteiraverso = $carteiraverso -> roundCorners(12);
                
                $carteiraverso = $carteiraverso -> rotate(90);
                
                $carteiraverso-> saveToFile("img/pessoas/carteira_verso" . $atleta -> getId() . ".png", 0, PNG_NO_FILTER);
                
                
            //echo "<img src='img/pessoas/carteira_frente".str_pad($atleta ->numeroFemeju,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>";
            //echo "<span style='page-break-after: always;'></span>";
            //echo "<img src='img/pessoas/carteira_verso".str_pad($atleta ->numeroFemeju,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>";
            //echo "<span style='page-break-after: always;'></span>";
            
            }
            //echo "</body></html>";
            
            
            header("Location:plugins/mpdf/relatorios/carteiras.php?atletas=".substr($numeros,0,strlen($numeros)-1));
             
             
            exit ;
            break;
    }
}
?>