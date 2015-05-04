<?php
class Usuario extends Persistencia {
	var $perfil = NULL;
	var $empresa = NULL;
	var $condominio = NULL;
	var $nome;
	var $senha;
	var $email;
	var $ativo;
	var $cpf;
	var $foto;
	var $assinatura;
	var $telefone;
	var $celular;
	var $registro;

	function LogOff() {
		
		//grava a log
				$log = new Log();
				$log->gerarLog("Sair do Sistema");
		
		unset($_SESSION['grc.empresaId']);
		unset($_SESSION['grc.condominioId']);
		unset($_SESSION['grc.userId']);
		unset($_SESSION['grc.userLogin']);
		unset($_SESSION['grc.userNome']);
		unset($_SESSION['grc.userFoto']);
		unset($_SESSION['grc.userPerfil']);
		unset($_SESSION['grc.userPerfilId']);
		unset($_SESSION['grc.menu']);
	}

	function recuperaTotal($busca = "") {
		switch ($_SESSION['grc.userPerfilId']) {
			case 0 :
				$sql = "select count(id) as total from grc_usuario WHERE 1 = 1 ";
				break;
			case 1 :
				$sql = "select count(id) as total from grc_usuario where empresa =" . $_SESSION['grc.empresaId'];
				break;
			default :
				$sql = "select count(id) as total from grc_usuario where empresa =" . $_SESSION['grc.empresaId'] . " and grc_perfil_id > " . $_SESSION['grc.userPerfilId'];
				break;
		}
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}


	function recuperaTotalPerfil($idPerfil, $busca = "") {
		switch ($_SESSION['grc.userPerfilId']) {
			case 0 :
				$sql = "select count(id) as total from grc_usuario WHERE grc_perfil_id = $idPerfil";
				break;
			case 1 :
				$sql = "select count(id) as total from grc_usuario where grc_perfil_id = $idPerfil and empresa =" . $_SESSION['grc.empresaId'];
				break;
			default :
				$sql = "select count(id) as total from grc_usuario where  grc_perfil_id = $idPerfil and empresa =" . $_SESSION['grc.empresaId'];
				break;
		}
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}
	
	function listarUsuariosPerfil($idPerfil, $primeiro = 0, $quantidade = 9999, $busca = "") {

		switch ($_SESSION['grc.userPerfilId']) {
			case 0 :
				$sql = "select * from grc_usuario where grc_perfil_id = $idPerfil";
				break;
			case 1 :
				$sql = "select * from grc_usuario where grc_perfil_id = $idPerfil and empresa =" . $_SESSION['grc.empresaId'];

				break;
			default :
				$sql = "select * from grc_usuario where grc_perfil_id = $idPerfil and empresa =" . $_SESSION['grc.empresaId'];
				break;
		}

		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	function listarUsuarios($primeiro = 0, $quantidade = 9999, $busca = "") {

		switch ($_SESSION['grc.userPerfilId']) {
			case 0 :
				$sql = "select * from grc_usuario where 1 = 1";
				break;
			case 1 :
				$sql = "select * from grc_usuario where empresa =" . $_SESSION['grc.empresaId'];

				break;
			default :
				$sql = "select * from grc_usuario where empresa =" . $_SESSION['grc.empresaId'] . " and grc_perfil_id > " . $_SESSION['grc.userPerfilId'];
				break;
		}

		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	function PesquisaPerfilEmpresaCondominio($empresa = "", $condominio = "",$perfil = "",$contador= false, $primeiro = 0, $quantidade = 99999) {
		$sqlWhere = " where 1 = 1 ";
        if($perfil != "")
            $sqlWhere .= "and grc_perfil_id = " . $perfil;
        
        if ($empresa != "")
            $sqlWhere .= " and empresa = " . $empresa;
        if ($condominio != "")
            $sqlWhere .= " and condominio = " . $condominio;
            
       if($contador){
               $sql = "select count(*) as total from grc_usuario ";               
               $rs = $this -> DAO_ExecutarQuery($sql.$sqlWhere);
                return $this -> DAO_Result($rs, "total", 0);               
       }   else{
               $sql = "select * from grc_usuario ";
               $sqlOrder = "  order by nome limit $primeiro, $quantidade";
               return $this -> getSQL($sql.$sqlWhere.$sqlOrder);   
       }  
            
		
        
        
		

	}

	function listarUsuariosPorPerfil($perfil) {

		switch ($_SESSION['grc.userPerfilId']) {
			case 0 :
				$sql = "select * from grc_usuario where grc_perfil_id = $perfil  order by nome";
				break;
			case 1 :
				$sql = "select * from grc_usuario where empresa = " . $_SESSION['grc.empresaId'] . " and grc_perfil_id = $perfil order by nome";
				break;
			case 2 :
				$sql = "select * from grc_usuario where empresa = " . $_SESSION['grc.empresaId'] . " and grc_perfil_id = $perfil order by nome";
				break;
			default :
				$sql = "select * from grc_usuario where condominio = " . $_SESSION['grc.condominioId'] . " and grc_perfil_id = $perfil";
				break;
		}

		return $this -> getSQL($sql);

	}

	function login($login, $senha) {
			
		
		
		if ($this -> recuperaPorLogin($login)) {
			if ($this -> ativo == 1) {
				if ($this -> senha == md5($senha)) {
					$_SESSION['grc.empresaId'] = $this -> empresa != null ? $this -> empresa -> id : 0;
					$_SESSION['grc.condominioId'] = $this -> condominio != null ? $this -> condominio -> id : 0;
					$_SESSION['grc.userLogin'] = $this -> login;
					$_SESSION['grc.userId'] = $this -> id;
					$_SESSION['grc.userNome'] = $this -> nome;
					$_SESSION['grc.userPerfil'] = $this -> perfil -> descricao;
					$_SESSION['grc.userFoto'] = $this -> foto;
					$_SESSION['grc.userPerfilId'] = $this -> perfil -> id;					
					//grava a log
				$log = new Log();
                
				$log->gerarLog("Entrou no Sistema");
					
					//carrega os itens de menu do perfil
					$a = new Acesso();
					$lista = $a -> recuperaMenuAcessos($this -> perfil -> id);
					$_SESSION['grc.menu'] = "0";
					foreach ($lista as $key => $acesso) {
						$_SESSION['grc.menu'] .= "," . $acesso -> menu -> id;
					}
					return true;
				} else {
					
					//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, senha inválida");
					
					$_SESSION['grc.mensagem'] = 2;
					return false;
				}
			} else {
				//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, usuário inativo");
				
				$_SESSION['grc.mensagem'] = 60;
				return false;
			}
		} else {
			//login invalido
			//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, Login inválido");
			
			$_SESSION['grc.mensagem'] = 1;
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
				$objEmail -> getById(Email::RECUPERAR_SENHA);
				$mensagem = str_replace("#URL#", $_SERVER['HTTP_HOST'],str_replace("#NOME#", $user -> nome,str_replace("#login#", $user -> login, str_replace("#novaSenha#", $senha, $objEmail -> conteudo))));
				$tplEmail = new Template("templates/email.html");
				$tplEmail -> ASSINATURA = Email::ASSINATURA;
				$tplEmail -> MENSAGEM = $mensagem;
				if ($this -> mail_html($email, $this -> remetente, $objEmail -> assunto, $tplEmail -> showString())) {
					$user -> save();
					$_SESSION['grc.mensagem'] = 18;
				} else {
					$_SESSION['grc.mensagem'] = 19;
				}
			}

		} else {
			$_SESSION['grc.mensagem'] = 1;
		}
	}

	function recuperaPorEmail($email, $idExclusao = "0") {
		$lista = $this -> getRows(0, 20, array(), array("email" => "='" . $email . "'", "id" => "!=" . $idExclusao));
		return $lista;
	}

	function recuperaPorLogin($login, $idExclusao = "0") {
		$this -> getRow(array("login" => "='" . $login . "'", "id" => "!=" . $idExclusao));
		if ($this -> id != NULL)
			return true;
		else
			return false;
	}

	function Excluir($id) {
	    $this->getById($this -> md5_decrypt($id));
		if($this -> delete($this->id))
		$_SESSION['grc.mensagem'] = 8;
        else
        $_SESSION['grc.mensagem'] = 70;
		header("Location:usuario-listar?idPerfil=".$this->md5_encrypt($this->perfil->id));
		exit();
	}
	function Redefinir($idUser){
		$this->getById($this->md5_decrypt($idUser));
		$this -> login = "";
		$this -> senha = "";
		$this -> ativo = 0;
		$this -> save();
		
		$email = new Email();
		$email->enviarEmailRedefinirSenha($this->nome,$this->email,$this->id);
		$_SESSION['grc.mensagem'] = 68;
		header("Location:usuario-listar?idPerfil=".$this->md5_encrypt($this->perfil->id));
		exit();
	}
	function Incluir() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		$p = new Perfil();
		$p -> id = $_REQUEST['perfil'];
		$this -> perfil = $p;
		//$senha = $_REQUEST['senha'] != "" ? $_REQUEST['senha'] : md5($this -> makePassword(8));
		$this -> nome = $_REQUEST['nome'];
		$this -> login = "";
		$this -> cpf = $strCPF;
		$this -> email = $_REQUEST['email'];
		$this -> telefone = str_replace("_","",$_REQUEST['telefone']);
		$this -> celular = str_replace("_","",$_REQUEST['celular']);
		$this -> registro = $_REQUEST['registro'];
		$this -> senha = "";
		$this -> ativo = 0;
		$this -> empresa = null;
		$this -> condominio = null;
		if (isset($_REQUEST['empresa'])) {
			$e = new Empresa();
			$e -> getById($_REQUEST['empresa']);
			$this -> empresa = $e;

		}
		if (isset($_REQUEST['condominio'])) {
			$c = new Condominio();
			$c ->getById($_REQUEST['condominio']);
			$this -> condominio = $c;

		}

		$this -> foto = "avatar.png";
		if ($_FILES['foto']['name'] != "") {
			//incluir imagem se ouver
			$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
			$this -> uploadImagem($_FILES['foto'], $nomefoto, "img/users/");
			$this -> foto = $nomefoto;
		}

		//incluir assinatura se ouver
		$this -> assinatura = "assinatura.jpg";
		if ($_FILES['assinatura']['name'] != "") {			
			$nomefoto = $this -> retornaNomeUnico($_FILES['assinatura']['name'], "img/assinaturas/");
			$this -> SalvarAssinatura($_FILES['assinatura'], $nomefoto, "img/assinaturas/");
			$this -> assinatura = $nomefoto;
		}

		$this -> save();
		$email = new Email();
		switch ($this->perfil->id) {
			case Perfil::GESTOR:
				$email->enviarEmailCadastroAdm($this->nome,$this->email,$this->id);
				break;
			case Perfil::PROPRIETARIO:
				$email->enviarEmailCadastroUsuario($c,$this->nome,$this->email,"Sem Unidade", $this->id);
				break;
			case Perfil::ENG_ADM:
				$email->enviarEmailCadastroEngenheiro($e,$this->nome,$this->email,$this->id);
				break;
			case Perfil::ENG_MAN:
				$email->enviarEmailCadastroEngenheiro($e,$this->nome,$this->email,$this->id);
				break;
			case Perfil::COND_ADM:
				$email-> enviarEmailCadastroSindico($c, $this->nome,$this->email,$this->id);
				break;
			case Perfil::COND_MAN:
				$email-> enviarEmailCadastroSindico($c, $this->nome,$this->email,$this->id);
				break;
			default:
				$email->enviarEmailCadastroPorteiro($this->nome,$this->email,$this->id);
				break;
		}

		$_SESSION['grc.mensagem'] = 4;
		header("Location:usuario-listar?idPerfil=".$this->md5_encrypt($p -> id));
		exit();

	}

	

	function Alterar() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['login'], $_REQUEST['id'])) {
			$_SESSION['grc.mensagem'] = 3;
			header("Location:usuario-editar?id=" . $this -> md5_encrypt($_REQUEST['id']));
			exit();
		} else {
			$this -> getById($_REQUEST['id']);
			$p = new Perfil();
			$p -> id = $_REQUEST['perfil'];
			$this -> perfil = $p;
			$this -> nome = $_REQUEST['nome'];
			$this -> login = $_REQUEST['login'];
			$this -> telefone = str_replace("_","",$_REQUEST['telefone']);
			$this -> celular = str_replace("_","",$_REQUEST['celular']);
			$this -> registro = $_REQUEST['registro'];
			$this -> cpf = $strCPF;
			$this -> email = $_REQUEST['email'];
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);
			$this -> ativo = $_REQUEST['ativo'];

			if (isset($_REQUEST['empresa'])) {
				$e = new Empresa();
				$e -> id = $_REQUEST['empresa'];
				$this -> empresa = $e;

			}
			if (isset($_REQUEST['condominio'])) {
				$c = new Condominio();
				$c -> id = $_REQUEST['condominio'];
				$this -> condominio = $c;

			}

			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> foto != "avatar.png")
					$this -> apagaImagem($this -> foto, "img/users/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
				$this -> foto = $nomefoto;
			}

			//incluir assinatura se ouver
			if ($_FILES['assinatura']['name'] != "") {
				$nomefoto = $this -> retornaNomeUnico($_FILES['assinatura']['name'], "img/assinaturas/");
				$this -> SalvarAssinatura($_FILES['assinatura'], $nomefoto, "img/assinaturas/");
				$this -> assinatura = $nomefoto;
			}

			$this -> save();    
                    
			$_SESSION['grc.mensagem'] = 5;
			header("Location:usuario-listar?idPerfil=".$this->md5_encrypt($p -> id));
			exit();
		}
	}

	function salvarFoto($file, $nome, $diretorio) {
		$return = $this -> createthumb($file['name'], $file['tmp_name'], $diretorio . $nome, 215, 215);
	}

	function SalvarAssinatura($file, $nome, $diretorio) {
		$return = $this -> createthumb($file['name'], $file['tmp_name'], $diretorio . $nome, 215, 120);
	}

	function AlterarMeusDados() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['login'], $_SESSION['grc.userId'])) {
			$_SESSION['grc.mensagem'] = 3;
			header("Location:usuario-dados");
			exit();
		} else {
			$this -> getById($_SESSION['grc.userId']);
			$this -> nome = $_REQUEST['nome'];
			$this -> login = $_REQUEST['login'];
			$this -> cpf = $strCPF;
			$this -> email = $_REQUEST['email'];
			$this -> telefone = $_REQUEST['telefone'];
			$this -> celular = $_REQUEST['celular'];
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);

			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> foto != "avatar.png")
					$this -> apagaImagem($this -> foto, "img/users/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
				$this -> foto = $nomefoto;
			}

			//incluir assinatura se ouver
			if ($_FILES['assinatura']['name'] != "") {				
				$nomefoto = $this -> retornaNomeUnico($_FILES['assinatura']['name'], "img/assinaturas/");
				$this -> SalvarAssinatura($_FILES['assinatura'], $nomefoto, "img/assinaturas/");
				$this -> assinatura = $nomefoto;
			}

			$this -> save();
			$_SESSION['grc.mensagem'] = 5;
			header("Location:home-home");
			exit();
		}
	}

	function listarDestinatariosPorProcesso($idProcesso) {
		$processo = new Processo();
		$processo -> getById($idProcesso);

		$this -> getById($processo -> proprietario -> id);

		$condominio = new Condominio;
		$condominio -> getById($processo -> unidade -> condominio -> id);

		$listaDest = $this -> nome . "<" . $this -> email . ">";
		//recuperar o sindico e adms do processo

		$lista = $this -> getRows(0, 999, array(), array("condominio" => "=" . $processo -> unidade -> condominio -> id, "perfil" => "in(" . Perfil::COND_ADM . "," . Perfil::COND_MAN . ")"));

		foreach ($lista as $key => $user) {
			$listaDest .= "," . $user -> nome . "<" . $user -> email . ">";
		}
		//recupera os engenheiros do condominio
		$lista = $this -> getRows(0, 999, array(), array("perfil" => "in(" . Perfil::ENG_ADM . "," . Perfil::ENG_MAN . ")", "empresa" => "=" . $condominio -> empresa -> id));
		foreach ($lista as $key => $user) {
			$listaDest .= "," . $user -> nome . "<" . $user -> email . ">";
		}

		return $listaDest;

	}
    
    function loginMd5($param1, $param2) {
            
       $login = $this->md5_decrypt($param1);
       $senha = $this->md5_decrypt($param2);
        
        if ($this -> recuperaPorLogin($login)) {
            if ($this -> ativo == 1) {
                if ($this -> senha == $senha) {
                    $_SESSION['grc.empresaId'] = $this -> empresa != null ? $this -> empresa -> id : 0;
                    $_SESSION['grc.condominioId'] = $this -> condominio != null ? $this -> condominio -> id : 0;
                    $_SESSION['grc.userLogin'] = $this -> login;
                    $_SESSION['grc.userId'] = $this -> id;
                    $_SESSION['grc.userNome'] = $this -> nome;
                    $_SESSION['grc.userPerfil'] = $this -> perfil -> descricao;
                    $_SESSION['grc.userFoto'] = $this -> foto;
                    $_SESSION['grc.userPerfilId'] = $this -> perfil -> id;                  
                    //grava a log
                $log = new Log();
                
                $log->gerarLog("Entrou no Sistema através de link de email.");
                    
                    //carrega os itens de menu do perfil
                    $a = new Acesso();
                    $lista = $a -> recuperaMenuAcessos($this -> perfil -> id);
                    $_SESSION['grc.menu'] = "0";
                    foreach ($lista as $key => $acesso) {
                        $_SESSION['grc.menu'] .= "," . $acesso -> menu -> id;
                    }
                    return true;
                } else {
                    
                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, senha inválida");
                    
                    $_SESSION['grc.mensagem'] = 2;
                    return false;
                }
            } else {
                //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, usuário inativo");
                
                $_SESSION['grc.mensagem'] = 60;
                return false;
            }
        } else {
            //login invalido
            //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, Login inválido");
            
            $_SESSION['grc.mensagem'] = 1;
            return false;
        }

    }

}
?>