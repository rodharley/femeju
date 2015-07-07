<?php
class Formato{
	const COMPLETO = '
                 <div class="etiqueta"  value="3">
                    
                     <div class="row">
                    <div class="col-lg-2" >
                        <div class="thumb" style="background-image: url(\'{imagem}\');"></div>
                    </div>
                    <div class="col-lg-10" >
                        <span class="data pull-right">{data}</span>
                        <p>{titulo}</p>
                        <p><small>{mensagem}</small></p>
                        <a href="{link}"  target="_blank"><span class="fb_icon {tipoArquivo}" aria-hidden="true"></span> {arquivo}</a>
                        
                    </div>           
                    </div>
                </div>';
        const SEMIMAGEM = '
                 <div class="etiqueta"  value="4">                    
                     <div class="row">
                    <div class="col-lg-12" >
                        <span class="data pull-right">{data}</span>
                        <p>{titulo}</p>
                        <p><small>{mensagem}</small></p>
                        <a href="{link}" target="_blank"><span class="fb_icon {tipoArquivo}" aria-hidden="true"></span> {arquivo}</a>                        
                    </div>           
                    </div>
                </div>
                ';
        
        const SOMENTEARQUIVO = '<div class="etiqueta" value="2">
                                <span class="data pull-right">{data}</span>
                                <a href="{link}" target="_blank"><span class="fb_icon {tipoArquivo}" aria-hidden="true"></span> {arquivo}</a>
                                </div>
                                ';
        const TITULOEARQUIVO = '<div class="etiqueta" value="1">
                    <span class="data pull-right">{data}</span>
                    <p>{titulo}</p>
                    <a href="{link}" target="_blank"><span class="fb_icon {tipoArquivo}" aria-hidden="true"></span> {arquivo}</a>
                </div>';
	
    
    function retornaTemplate($formato, $imagem = "",$titulo = "",$mensagem = "",$link = "",$tipoArquivo = "",$arquivo = "",$data = ""){
        $template = "";
        switch ($formato) {
            case '1':
                $template = $this::TITULOEARQUIVO;
                break;
            case '2':
                $template = $this::SOMENTEARQUIVO;
                break;
            case '3':
                $template = $this::COMPLETO;
                break;
            case '4':
                $template = $this::SEMIMAGEM;
                break;                
            default:
                $template = $this::COMPLETO;
                break;
        }
                $template = str_replace("{imagem}", $imagem, $template);
                $template = str_replace("{mensagem}", $mensagem, $template);
                $template = str_replace("{titulo}", $titulo, $template);
                $template = str_replace("{link}", $link, $template);
                $template = str_replace("{tipoArquivo}", $tipoArquivo, $template);
                $template = str_replace("{arquivo}", $arquivo, $template);
                $template = str_replace("{data}", $data, $template);
    return $template;
    }
}
?>