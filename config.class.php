<?php

/**
 * Classe conexao tem como objetivo realizar a conex�o com o banco de dados
 * diminuindo o trabalho de configura��o na aplica��o, utiliza m�todos de 
 * abstra��o do banco de dados para melhorar interface com o cliente,
 * proporcionando exce��es para possiveis erros de programa��o
 *
 * @author 	Edicarlos S. Barbosa
 * @version	1.0.0 2010-01-18 21:49:40
 * @revision 	1
 * @copiright	Todos os direitos reservados. Proibida c�pia, distribui��o ou uso indevido.
**/ 

class Conexao{
	//Login de acesso ao banco de dados mysql
	private $login;
	
	//Senha de acesso ao banco de dados
	private $senha;
	
	//Endere�o do servidor de banco de dados
	private $local;
	
	//Nome do banco de dados da aplica��o
	private $banco;

	/**
	 * M�todo construtor que recebe as variaveis necess�rias para conexao
	 * @param String $local 	Endere�o do banco de dados Mysql
	 * @param String $login 	Nome de usu�rio do Mysql
	 * @param String $senha 	Senha de acesso ao banco de dados Mysql
	 * @param String $banco		Nome do banco de dados no Mysql
	**/		
	function __construct($local, $login, $senha, $banco){
		if($this->ChecaDados($local) != false)
			$this->local = $local;
		else
			throw new Exception("Erro na conex�o. Endere�o do banco de dados inv�lido. Endere�o: $local");
		
		if($this->ChecaDados($login) != false)
			$this->login = $login;
		else
			throw new Exception("Erro na conex�o. Login do banco de dados inv�lido. Login: $login");
					
		if($this->ChecaDados($banco) != false)
			$this->banco = $banco;
		else
			throw new Exception("Erro na conex�o. Banco de dados inv�lido. Banco de dados: $banco");
		
		$this->senha = $senha;
		$this->Conecta();
	}
	
	//M�todo que verifica os dados passados para o construtor da classe
	private function ChecaDados($var){
		if($var == "")
			return false;
		else 
			return true;
	}

	//M�todo que tem como fun��o realizar a conex�o com o banco de dados
	public function Conecta(){
		if(@mysql_connect($this->local, $this->login, $this->senha)){
			//Seleciona banco de dados ap�s a conex�o
			$this->SelectBd();
		}else{
			throw new Exception("Erro na conex�o. Houve um erro ao estabelecer a conex�o!<br/>". mysql_error());
		}	
	}

	//M�todo seleciona o banco de dados
	private function SelectBd(){
		if(!@mysql_select_db($this->banco)){
			throw new Exception("Erro na conex�o. Houve um erro ao definir o banco de dados: ". $this->banco);
		}
	}
}
?>
