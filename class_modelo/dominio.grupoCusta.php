<?php
class GrupoCusta{
	const ANUIDADE = 1;
    const COMPETICAO = 2;
    const OUTROS = 3;
    var $id;
    var $descricao;
    
    public function __construct($id = NULL){
        $this->id = $id;
        $this->pasta = $this->getDescricao($id);                
    }
    
    function getDescricao($id){
        switch ($id) {
            case $this::ANUIDADE:
                return 'Anuidade';
                break;
            case $this::COMPETICAO:
                return 'Competicao';
                break;
            case $this::OUTROS:
                return 'Outros';
                break;                
            default:
                return '';
                break;
        }
        
    }
}
?>