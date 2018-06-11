<?php
	class Ftp{
		private $host_ftp;
		private $user_ftp;
		private $pass_ftp;
		private $ftp_con;
		
		function __construct($host, $user, $pass){
			if(!empty($host) && !empty($user) && !empty($pass)){
				$this->host_ftp = $host;
				$this->user_ftp = $user;
				$this->pass_ftp = $pass;
			}
			else
				throw new Exception("Dados de acesso est�o vazios");
		}
		
		public function gravar($arquivo, $arquivo_temp, $local){
			if(!empty($arquivo) && !empty($arquivo_temp) && !empty($local)){
				$this->conectar();
				$return = @ftp_put($this->ftp_con, $local.$arquivo, $arquivo_temp, FTP_BINARY);
				ftp_close($this->ftp_con);
				return $return;
			}
			else
				throw new Exception("Nome e local do arquivo est�o em branco!");
		}
		
		public function apagar($arquivo, $local){
			if(!empty($arquivo) && !empty($local)){
				$this->conectar();
				$return = @ftp_delete($this->ftp_con, $local.$arquivo);
				ftp_close($this->ftp_con);
				return $return;
			}
			else
				throw new Exception("Nome e local do arquivo est�o em branco!");
		}
		
		private function conectar(){
			$this->ftp_con = @ftp_connect($this->host_ftp);
			$ftp_log = @ftp_login($this->ftp_con, $this->user_ftp, $this->pass_ftp);
			if(!$this->ftp_con)
				throw new Exception("Erro na conex�o com o FTP!");
			else if(!$ftp_log)
				throw new Exception("Login ou senha de acesso do ftp inv�lidos!");
		}
	}
?>