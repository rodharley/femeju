<?php
class Categoria{
	const CALENDARIO = 6;
    const COMUNICADOS = 2;
    const FAIXA_PRETA = 3;
    const KATA = 4;
    const DOCUMENTOS = 5;
    const RANKING = 1;
    const BOLSA_ATLETA = 7;
    const TREINAMENTOS = 8;
    const COMPETICOES = 9;
    
    var $id;
    var $pasta;
    
    public function __construct($id = NULL){
        $this->id = $id;
        $this->pasta = $this->retornaPasta($id);                
    }
    
    function retornaPasta($id){
        switch ($id) {
            case $this::CALENDARIO:
                return 'calendario';
                break;
            case $this::COMUNICADOS:
                return 'comunicados';
                break;
            case $this::FAIXA_PRETA:
                return 'faixapreta';
                break;
                case $this::KATA:
                return 'kata';
                break;
                case $this::DOCUMENTOS:
                return 'documentos';
                break;
                case $this::RANKING:
                return 'ranking';
                break;
                case $this::BOLSA_ATLETA:
                return 'bolsaatleta';
                break;
                case $this::TREINAMENTOS:
                return 'treinamentos';
                break;
                case $this::COMPETICOES:
                return 'competicoes';
                break;
            default:
                return 'calendario';
                break;
        }
        
    }
    
	
}
?>