<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/noticia/detalhe.html");
$obj = new Noticia();


                            $obj->getById($obj->md5_decrypt($_REQUEST['id']));
                            $TPL->foto = $obj->foto;
                            $TPL->titulo = $obj->titulo;
                            $TPL->texto = $obj->texto;
                            $TPL->SUMARIO = $obj->sumario;
                            $TPL->data = $obj->convdata($obj->data,"mtnh");
                            if($obj->foto != "")
                                $TPL->block("BLOCK_IMG");
                            $TPL->show();
?>