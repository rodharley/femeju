<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/associacao/detalhe.html");
$obj = new Associacao();
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$TPL->NOME_ASSOCIACAO = $obj->nome;
$TPL->DESCRICAO = $obj->descricao;
$TPL->LOGOTIPO = $obj->logomarca != "" ? $obj->logomarca : "nologo.png";
$TPL->SIGLA = $obj->sigla;        
$TPL->BAIRRO = $obj->bairro;
$TPL->ENDERECO = $obj->endereco;
if($obj->cidade != null){
$TPL->CIDADE = $obj->cidade->nome;
$TPL->ESTADO = $obj->cidade->uf->uf;
}
$TPL->CEP = $obj->formataCep($obj->cep);
$TPL->NOME_RESPONSAVEL = $obj->responsavel->pessoa->getNomeCompleto();
$TPL->CELULAR = $obj->formataTelefone($obj->responsavel->pessoa->telCelular);
$TPL->TELEFONE1 = $obj->formataTelefone($obj->telefone1);
$TPL->TELEFONE2 = $obj->formataTelefone($obj->telefone2);
$TPL->EMAIL = $obj->email;     
$TPL->URL_MIDIA = $obj->midiaSocial; 
$TPL->WEB_SITE = $obj->webSite;   
$TPL->CNPJ = $obj->cnpj;
$TPL->IDENTIFICACAO = $obj->identificacao;
//fotos
foreach ($obj->fotos as $key => $foto) {
        $TPL->IMAGEM_FOTO = $foto->imagem;
        $TPL->block("BLOCK_FOTO");
    }            
$TPL->show();
?>