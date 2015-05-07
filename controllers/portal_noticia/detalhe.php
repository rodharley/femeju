<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/noticia/detalhe.html");
$obj = new Noticia();
$TPL->BREADCRUMB = '<ol class="breadcrumb">
                                <li>
                                    <a href="portal_home-index">Home</a>
                                </li>
                                <li>
                                    <a href="portal_noticia-main">Notícias</a>
                                </li>
                                <li class="active">
                                    <a href="#">Detalhe</a>
                                </li>
                            </ol>';

                            $obj->getById($obj->md5_decrypt($_REQUEST['id']));
                            $TPL->foto = $obj->foto;
                            $TPL->titulo = $obj->titulo;
                            $TPL->texto = $obj->texto;
                            $TPL->data = $obj->convdata($obj->data,"mtnh");
                            $TPL->show();
?>