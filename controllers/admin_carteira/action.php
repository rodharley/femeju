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
            foreach ($_REQUEST['atletas'] as $key => $value) {
                $atleta -> getById($value);
                $numeros .= $atleta ->numeroFemeju.",";    
                //gera a imagem de fundo;
                $rgb = $conf -> hex2rgb($conf -> valor);
                $imagem = imagecreatetruecolor(322, 209);
                $red = imagecolorallocate($imagem, $rgb[0], $rgb[1], $rgb[2]);
                imagefill($imagem, 0, 0, $red);

                $logo = WideImage::load('img/carteirinha_frente.png');
                $img = WideImage::load($imagem);
                $carteira = $img -> merge($logo, 0, 0, 100);
                $imagemAtleta = $atleta -> pessoa -> foto != "" ? $atleta -> pessoa -> foto : "pessoa.png";
                $foto = WideImage::load('img/pessoas/' . $imagemAtleta);
                $fotoresize = $foto -> resize(84, 113, 'fill');
                $carteiracomfoto = $carteira -> merge($fotoresize, 220, 18, 100);

                //gera o qrcode
                QRcode::png($atleta -> getId() . "-" . $atleta -> pessoa -> getNomeCompleto(), "img/pessoas/" . $atleta -> getId() . ".png", 4, 8, 2);
                $qrcode = WideImage::load('img/pessoas/' . $atleta -> getId() . ".png");
                $qrcoderesize = $qrcode -> resize(70, 70, 'fill');
                $carteiracomfotoeqrcode = $carteiracomfoto -> merge($qrcoderesize, 225, 133, 100);
                unlink('img/pessoas/' . $atleta -> getId() . ".png");
                
                

                //escreve na carteirinha
                $canvas = $carteiracomfotoeqrcode -> getCanvas();
                
                
                //registro
                $canvas -> useFont('fonts/SourceSansPro-Bold.ttf', '12', $carteiracomfotoeqrcode -> allocateColor(0, 0, 0));
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

                    $canvas -> writeText('40', '140', $str_linha1, 0);
                    $canvas -> writeText('40', '160', $str_linha2, 0);
                    $canvas -> writeText('40', '180', 'Registro NК:' . $atleta -> getId(), 0);
                } else {
                    $canvas -> writeText('40', '140', $atleta -> pessoa -> getNomeCompleto(), 0);
                    $canvas -> writeText('40', '160', 'Registro NК:' . $atleta -> getId(), 0);
                }

                $carteiracomfotoeqrcode -> saveToFile("img/pessoas/carteira_frente" . $atleta -> getId() . ".png");
                
                //verso
                $verso = WideImage::load('img/carteirinha_verso.png');
                
                //escreve na carteirinha
                $canvas = $verso -> getCanvas();
                
                //verso displays
                $canvas -> useFont('fonts/SourceSansPro-Regular.ttf', '8', $verso -> allocateColor(0, 0, 0));
                $canvas -> writeText('20', '16', "Associaчуo", 0);
                $canvas -> writeText('20', '52', "Nome", 0);
                $canvas -> writeText('20', '88', "Graduaчуo", 0);
                $canvas -> writeText('200', '88', "Data de Nascimento", 0);
                $canvas -> writeText('20', '124', "Validade", 0);
                $canvas -> writeText('120', '184', "Assinatura Femeju", 0);

                //verso
                $canvas -> useFont('fonts/SourceSansPro-Regular.ttf', '10', $verso -> allocateColor(0, 0, 0));
                $canvas -> writeText('20', '34', $atleta -> associacao -> nome, 0);
                $canvas -> writeText('20', '70', $atleta -> pessoa -> getNomeCompleto(), 0);
                $canvas -> writeText('20', '106', $atleta -> graduacao -> descricao . " - " . $atleta -> graduacao -> faixa, 0);
                $canvas -> writeText('220', '106', $atleta -> convdata($atleta -> pessoa -> dataNascimento, "mtn"), 0);
                $canvas -> writeText('20', '142', '31 de Dezembro de ' . Date('Y'), 0);
            
            //assinatura do presidente
                $assinatura = WideImage::load('img/assinatura.png');
                $assintauraresize = $assinatura -> resize(84, 100, 'fill');
                $carteiraverso = $verso -> merge($assintauraresize, 130, 138, 100);
            
                
                
                $carteiraverso-> saveToFile("img/pessoas/carteira_verso" . $atleta -> getId() . ".png");
                
                

            }

            header("Location:plugins/mpdf/relatorios/carteiras.php?atletas=".substr($numeros,0,strlen($numeros)-1));
             
             
            exit ;
            break;
    }
}
?>