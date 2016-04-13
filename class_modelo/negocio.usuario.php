<?php
class Usuario extends Persistencia {
    const TABELA = "fmj_usuario";
	var $perfil = NULL;	
	var $senha;
	var $ativo;
	var $pessoa = null;
	

	function LogOff() {
		
		//grava a log
		$log = new Log();
		$log->gerarLog("Sair do Sistema");
		unset($_SESSION['fmj.userId']);
		unset($_SESSION['fmj.userNome']);
		unset($_SESSION['fmj.userFoto']);
		unset($_SESSION['fmj.userPerfil']);
		unset($_SESSION['fmj.userPerfilId']);
		unset($_SESSION['fmj.menu']);
        unset($_SESSION['start']);
        unset($_SESSION['expire']);
         session_destroy();
	}

	function recuperaTotal($busca = "",$perfil = "") {
				$sql = "select count(u.id) as total from fmj_usuario u inner join fmj_pessoa p on p.id = u.id WHERE u.idPerfil != ".Perfil::RESPONSAVEL;
		if ($busca != "")
			$sql .= " and (p.nome like '$busca%' or p.cpf like '$busca%')";
        if($perfil != "")
        $sql .= " and (u.idPerfil = $perfil)";
		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}


	function recuperaTotalPerfil($idPerfil, $busca = "") {
		
				$sql = "select count(u.id) as total from fmj_usuario u inner join fmj_pessoa p on p.id = u.id WHERE u.idPerfil = $idPerfil";
		
		if ($busca != "")
			$sql .= " and (p.nome like '$busca%' or p.cpf like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}
	
	function listarUsuariosPerfil($idPerfil = "", $primeiro = 0, $quantidade = 9999, $busca = "") {

		
				$sql = "select u.* from fmj_usuario u inner join fmj_pessoa p on p.id = u.id where 1 = 1 ";
		if ($idPerfil != "")
            $sql .= " and (u.idPerfil = $idPerfil) ";
        
		if ($busca != "")
			$sql .= " and (p.nome like '$busca%' or p.cpf like '$busca%')";

		$sql .= "  order by p.nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	function listarUsuarios($primeiro = 0, $quantidade = 9999, $busca = "", $perfil = "") {

				$sql = "select u.* from fmj_usuario u inner join fmj_pessoa p on p.id = u.id where u.idPerfil != ".Perfil::RESPONSAVEL;
		
		if ($busca != "")
			$sql .= " and (p.nome like '$busca%' or p.cpf like '$busca%')";
        if($perfil != "")
        $sql .= " and (u.idPerfil = $perfil)";
		$sql .= "  order by p.nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	
	function login($login, $senha) {
			
		
		
		if ($this ->recuperaPorLogin($login)) {
			    
			if ($this -> ativo == 1) {
				if ($this -> senha == md5($senha)) {
					$_SESSION['fmj.userId'] = $this -> id;
					$_SESSION['fmj.userNome'] = $this -> pessoa->nome;
					$_SESSION['fmj.userPerfil'] = $this -> perfil -> descricao;
					$_SESSION['fmj.userFoto'] = $this -> pessoa->foto;
					$_SESSION['fmj.userPerfilId'] = $this -> perfil -> id;		
					$_SESSION['start'] = time(); // Taking now logged in time.
                        // Ending a session in 30 minutes from the starting time.
                    $_SESSION['expire'] = $_SESSION['start'] + (1800);			
					//grava a log
				$log = new Log();
                
				$log->gerarLog("Entrou no Sistema");
					
                    
					//carrega os itens de menu do perfil
					$a = new Acesso();                    
					$lista = $a -> recuperaMenuAcessos($this -> perfil -> id);					
					$_SESSION['fmj.menu'] = "0";					
					foreach ($lista as $key => $acesso) {
						$_SESSION['fmj.menu'] .= "," . $acesso -> menu -> id;
					}
					
					return true;
				} else {
					
					//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, senha inválida");
					
					$_SESSION['fmj.mensagem'] = 2;
					return false;
				}
			} else {
				//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, usuário inativo");
				
				$_SESSION['fmj.mensagem'] = 12;
				return false;
			}
		} else {
			//login invalido
			//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, Login inválido");
			
			$_SESSION['fmj.mensagem'] = 1;
			return false;
		}

	}

	function EnviarSenha($email) {
		$lista = $this -> recuperaPorEmail($email);
		if (count($lista) > 0) {

			foreach ($lista as $key => $user) {
				$senha = $this -> makePassword(8);
				$user -> senha = md5($senha);
				$objEmail = new Email();
				
				if ($objEmail->enviarEmailNovaSenha($user->pessoa->nome,$user->pessoa->email,$senha)) {
					$user -> save();
					$_SESSION['fmj.mensagem'] = 15;
				} else {
					$_SESSION['fmj.mensagem'] = 11;
				}
			}

		} else {
			$_SESSION['fmj.mensagem'] = 1;
		}
	}

	function recuperaPorEmail($email, $idExclusao = "0") {
		$sql = "select u.* from fmj_usuario u inner join fmj_pessoa p on p.id = u.id where p.email = '$email' and u.id != $idExclusao";
        $rs = $this->getSQL($sql);
		return $rs;
	}

	function recuperaPorLogin($login, $idExclusao = "0") {
	    $sql = "select u.* from fmj_usuario u inner join fmj_pessoa p on p.id = u.id where p.email = '$login' and u.id != $idExclusao";
	    $rs = $this->getSQL($sql);
        if(count($rs) > 0){
	       $this->getById($rs[0]->id);		
			return true;
		}else
			return false;
	}
    
    
    
    function recuperaPorIdPessoa($idPessoa) {
        $sql = "select u.* from fmj_usuario u where u.id = $idPessoa";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
           $this->getById($rs[0]->id);      
            return true;
        }else
            return false;
    }
    
	function Excluir($id) {
	    $this->getById($this -> md5_decrypt($id));
		if($this -> delete($this->id))
		$_SESSION['fmj.mensagem'] = 8;
        else
        $_SESSION['fmj.mensagem'] = 17;
		header("Location:admin_usuario-main");
		exit();
	}
	function Redefinir($idUser){
		$this->getById($this->md5_decrypt($idUser));
		$this -> senha = "";
		$this -> ativo = 0;
		$this -> save();
		
		$email = new Email();
		$email->enviarEmailRedefinirSenha($this->pessoa->nome,$this->pessoa->email,$this->id);
		$_SESSION['fmj.mensagem'] = 10;
		header("Location:admin_usuario-main");
		exit();
	}
	function Incluir() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		$p = new Perfil();
		$p -> id = $_REQUEST['perfil'];
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
		$this -> perfil = $p;
		$this -> senha = "";
        $this -> ativo = 0;
		//$senha = $_REQUEST['senha'] != "" ? $_REQUEST['senha'] : md5($this -> makePassword(8));
		$pessoa = new Pessoa();
        $pessoa->ConsultaCPFExistente($strCPF);            
		$pessoa->nome = $_REQUEST['nome'];
        $pessoa->sobrenome = $_REQUEST['sobreNome'];
        $pessoa->nomeMeio = $_REQUEST['nomeMeio'];
		$pessoa-> cpf = $strCPF;
		$pessoa-> email = $_REQUEST['email'];
		$pessoa-> telResidencial = str_replace("_","",$_REQUEST['telefone']);
		$pessoa-> telCelular = str_replace("_","",$_REQUEST['celular']);
        $pessoa-> foto = "pessoa.png";
		$pessoa->bitVerificado = 1;
		$pessoa->endereco = $_REQUEST['endereco'];
        $pessoa->bairro = $_REQUEST['bairro'];
        $pessoa->cidade = $cidadeEndereco;
        $pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);
		if ($_FILES['foto']['name'] != "") {
			//incluir imagem se ouver
			$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
			$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
			$pessoa-> foto = $nomefoto;
		}	
        $this->id = $pessoa->save(); 
        $this->pessoa = $pessoa;	
		$this -> save();
        
        //altera as permissoes de academias
        //    $this->apagaPermissoes();
        //    $this->salvaPermissoes($_REQUEST['academias']);
        
        $email = new Email();
        $email->enviarEmailNovoUsuario($this->pessoa->nome,$this->pessoa->email,$this->id);
		$_SESSION['fmj.mensagem'] = 4;
		header("Location:admin_usuario-main");
		exit();

	}

	function Alterar() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['email'], $_REQUEST['id'])) {
			$_SESSION['fmj.mensagem'] = 3;
			header("Location:admin_usuario-editar?id=" . $this -> md5_encrypt($_REQUEST['id']));
			exit();
		} else {
			$this -> getById($_REQUEST['id']);
			$p = new Perfil();
			$p -> id = $_REQUEST['perfil'];
            $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
			$this -> perfil = $p;
			$this -> pessoa -> nome = $_REQUEST['nome'];
            $this->pessoa->nome = $_REQUEST['nome'];
            $this->pessoa->sobrenome = $_REQUEST['sobreNome'];
            $this->pessoa->nomeMeio = $_REQUEST['nomeMeio'];
			$this -> pessoa -> telResidencial = str_replace("_","",$_REQUEST['telefone']);
			$this -> pessoa -> telCelular = str_replace("_","",$_REQUEST['celular']);
			$this -> pessoa -> cpf = $strCPF;
			$this -> pessoa -> email = $_REQUEST['email'];
            $this-> pessoa->endereco = $_REQUEST['endereco'];
            $this-> pessoa->bairro = $_REQUEST['bairro'];
            $this-> pessoa->cidade = $cidadeEndereco;
            $this-> pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);
			$this -> ativo = $_REQUEST['ativo'];

			
			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this ->  pessoa -> foto != "pessoa.png")
					$this -> apagaImagem($this -> pessoa-> foto, "img/pessoas/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
				$this -> pessoa -> foto = $nomefoto;
			}		
            
            $this -> pessoa ->save();    
			$this -> save();    
            
            //altera as permissoes de academias
            //$this->apagaPermissoes();
            //$this->salvaPermissoes($_REQUEST['academias']);
                                
			$_SESSION['fmj.mensagem'] = 5;
			header("Location:admin_usuario-main?idPerfil=".$this->md5_encrypt($p -> id));
			exit();
		}
	}

	


	function AlterarMeusDados() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['email'], $_SESSION['fmj.userId'])) {
			$_SESSION['fmj.mensagem'] = 3;
			header("Location:admin_usuario-dados");
			exit();
		} else {
			$this -> getById($_SESSION['fmj.userId']);
            $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
            $this -> pessoa -> nome = $_REQUEST['nome'];
            $this->pessoa->nome = $_REQUEST['nome'];
            $this->pessoa->sobrenome = $_REQUEST['sobreNome'];
            $this->pessoa->nomeMeio = $_REQUEST['nomeMeio'];
            $this -> pessoa -> telResidencial = str_replace("_","",$_REQUEST['telefone']);
            $this -> pessoa -> telCelular = str_replace("_","",$_REQUEST['celular']);
            $this -> pessoa -> cpf = $strCPF;
            $this -> pessoa -> email = $_REQUEST['email'];
            $this-> pessoa->endereco = $_REQUEST['endereco'];
            $this-> pessoa->bairro = $_REQUEST['bairro'];
            $this-> pessoa->cidade = $cidadeEndereco;
            $this-> pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);
            if ($_REQUEST['senha'] != "")
                $this -> senha = md5($_REQUEST['senha']);
            
			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> pessoa -> foto != "pessoa.png")
					$this -> apagaImagem($this -> pessoa ->  foto, "img/pessoas/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
				$this ->  pessoa -> foto = $nomefoto;
			}
			
            $this->pessoa->Save();
			$this -> save();
			$_SESSION['fmj.mensagem'] = 5;
			header("Location:admin_home-home");
			exit();
		}
	}

	
    public function apagaPermissoes(){
        $SQL = "delete from fmj_permissao where idUsuario = ".$this->id;
        $this->DAO_ExecutarDelete($SQL);
    }
    
    public function salvaPermissoes($permissoes){
        $arrayP = explode(",", $permissoes);
        foreach ($arrayP as $key => $value) {
            $p = new Permissao();
            $p->usuario = $this;
            $p->academia = new Academia($value);
            $p->save();
        }
    }
    function loginMd5($param1, $param2) {
            
       $login = $this->md5_decrypt($param1);
       $senha = $this->md5_decrypt($param2);
        
        if ($this -> recuperaPorLogin($login)) {
            if ($this -> ativo == 1) {
                if ($this -> senha == $senha) {
                    $_SESSION['fmj.userId'] = $this -> id;
                    $_SESSION['fmj.userNome'] = $this -> nome;
                    $_SESSION['fmj.userPerfil'] = $this -> perfil -> descricao;
                    $_SESSION['fmj.userFoto'] = $this -> foto;
                    $_SESSION['fmj.userPerfilId'] = $this -> perfil -> id;                  
                    //grava a log
                $log = new Log();
                
                $log->gerarLog("Entrou no Sistema através de link de email.");
                    
                    //carrega os itens de menu do perfil
                    $a = new Acesso();
                    $lista = $a -> recuperaMenuAcessos($this -> perfil -> id);
                    $_SESSION['fmj.menu'] = "0";
                    foreach ($lista as $key => $acesso) {
                        $_SESSION['fmj.menu'] .= "," . $acesso -> menu -> id;
                    }
                    return true;
                } else {
                    
                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, senha inválida");
                    
                    $_SESSION['fmj.mensagem'] = 2;
                    return false;
                }
            } else {
                //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, usuário inativo");
                
                $_SESSION['fmj.mensagem'] = 12;
                return false;
            }
        } else {
            //login invalido
            //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, Login inválido");
            
            $_SESSION['fmj.mensagem'] = 1;
            return false;
        }

    }


function ConsultaCPFExistente($cpf, $idExclusao = "0") {
        $sql = "select u.* from fmj_usuario u inner join fmj_pessoa p on p.id = u.id where p.cpf = '$cpf' and p.id != $idExclusao";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
            $this->getById($rs[0]->id);
            return true;
        }else
            return false;
    }

}
?>