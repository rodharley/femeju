<?php
class Categoria{
	const CALENDARIO = 7;
    const COMUNICADOS = 8;
    const FAIXA_PRETA = 9;
    const KATA = 10;
    const DOCUMENTOS = 11;
    const RANKING = 12;
    const BOLSA_ATLETA = 13;
    const PRESIDENCIA = 24;
    const COMPETICOES = 15;
    const ARBITRAGEM = 14;
    const AFEMEJU = 21;
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
                case $this::PRESIDENCIA:
                return 'presidencia';
                break;
                case $this::ARBITRAGEM:
                return 'arbitragem';
                break;
                case $this::COMPETICOES:
                return 'competicoes';
                break;
                case $this::AFEMEJU:
                return 'afemeju';
                break;
            default:
                return 'calendario';
                break;
        }
        
    }
    
	function retornaDescricao($id){
        switch ($id) {
            case $this::CALENDARIO:
                return 'Calendário';
                break;
            case $this::COMUNICADOS:
                return 'Comunicados';
                break;
            case $this::FAIXA_PRETA:
                return 'Curso Faixa Preta';
                break;
                case $this::KATA:
                return 'Kata';
                break;
                case $this::DOCUMENTOS:
                return 'Documentos';
                break;
                case $this::RANKING:
                return 'Ranking';
                break;
                case $this::BOLSA_ATLETA:
                return 'Bolsa Atleta';
                break;
                case $this::PRESIDENCIA:
                return 'Presidência';
                break;
                case $this::ARBITRAGEM:
                return 'Arbitragem';
                break;
                case $this::COMPETICOES:
                return 'Competições';
                break;
                case $this::AFEMEJU:
                return 'A Femeju';
                break;
            default:
                return 'Calendário';
                break;
        }
        
    }
}
?>