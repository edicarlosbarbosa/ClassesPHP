<?php

/**
 * Classe conexao tem como objetivo realizar a conexão com o banco de dados
 * diminuindo o trabalho de configuração na aplicação, utiliza métodos de 
 * abstração do banco de dados para melhorar interface com o cliente,
 * proporcionando exceções para possiveis erros de programação
 *
 * @author 	Edicarlos S. Barbosa
 * @version	1.0.0 2010-01-18 21:49:40
 * @revision 	1
 * @copiright	Todos os direitos reservados. Proibida cópia, distribuição ou uso indevido.
**/ 

class Conexao{
	//Login de acesso ao banco de dados mysql
	private $login;
	
	//Senha de acesso ao banco de dados
	private $senha;
	
	//Endereço do servidor de banco de dados
	private $local;
	
	//Nome do banco de dados da aplicação
	private $banco;

	/**
	 * Método construtor que recebe as variaveis necessárias para conexao
	 * @param String $local 	Endereço do banco de dados Mysql
	 * @param String $login 	Nome de usuário do Mysql
	 * @param String $senha 	Senha de acesso ao banco de dados Mysql
	 * @param String $banco		Nome do banco de dados no Mysql
	**/		
	function __construct($local, $login, $senha, $banco){
		if($this->ChecaDados($local) != false)
			$this->local = $local;
		else
			throw new Exception("Erro na conexão. Endereço do banco de dados inválido. Endereço: $local");
		
		if($this->ChecaDados($login) != false)
			$this->login = $login;
		else
			throw new Exception("Erro na conexão. Login do banco de dados inválido. Login: $login");
					
		if($this->ChecaDados($banco) != false)
			$this->banco = $banco;
		else
			throw new Exception("Erro na conexão. Banco de dados inválido. Banco de dados: $banco");
		
		$this->senha = $senha;
		$this->Conecta();
	}
	
	//Método que verifica os dados passados para o construtor da classe
	private function ChecaDados($var){
		if($var == "")
			return false;
		else 
			return true;
	}

	//Método que tem como função realizar a conexão com o banco de dados
	public function Conecta(){
		if(@mysql_connect($this->local, $this->login, $this->senha)){
			//Seleciona banco de dados após a conexão
			$this->SelectBd();
		}else{
			throw new Exception("Erro na conexão. Houve um erro ao estabelecer a conexão!<br/>". mysql_error());
		}	
	}

	//Método seleciona o banco de dados
	private function SelectBd(){
		if(!@mysql_select_db($this->banco)){
			throw new Exception("Erro na conexão. Houve um erro ao definir o banco de dados: ". $this->banco);
		}
	}
}
?>
