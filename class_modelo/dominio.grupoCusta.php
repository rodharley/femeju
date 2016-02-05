<?php
class GrupoCusta{
	const ANUIDADE = 1;
    const COMPETICAO = 2;
    const OUTROS = 3;
    var $id;
    var $descricao;
    
    public function __construct($id = NULL){
        $this->id = $id;
        $this->descricao = $this->getDescricao($id);                
    }
    
    function getDescricao($id){
        switch ($id) {
            case $this::ANUIDADE:
                return 'Anuidade';
                break;
            case $this::COMPETICAO:
                return 'Evento/Competicao';
                break;
            case $this::OUTROS:
                return 'Geral';
                break;                
            default:
                return '';
                break;
        }
        
    }
}
?>