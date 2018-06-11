<?php

class Twitter {
	
	// Atributos
	
	public $username;             // nome do usuário
	public $password;             // senha de acesso
	public $errors = array();     // array de erros
	public $sucess = array();     // array de sucessos
	
	// Método __construct
	
	public function __construct($user, $pass) {
		
		// Verifica se os dados não são nulos
		if ( !empty($user) && !empty($pass) ) {
			
			// Atribui os valores aos atributos
			$this->username = $user;
			$this->password = $pass;
			
		}else{
			
			// Define uma mensagem de erro
			$this->errors[] = "Erro: Dados de acesso insuficientes.";
			
		}
		
	}
	
	// Método post
	// @escopo: void post(string message);
	
	public function post($message) {
		
		// Verifica se a mensagem não é nula
		if ( !empty($message) ){
			
			// Verifica se a quantidade de caracteres é válida
			if ( strlen($message) <= 140 ) {
				
				// Verifica se não ocorreu erros
				if ( count($this->errors) == 0 ) {
					
					// Tenta enviar a mensagem
					$api = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($message)));

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $api);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_exec($ch);
					
					// Recupera o resultado do envio
					$result = curl_getinfo($ch);
					
					curl_close($ch);
					
					// Verifica o status do envio
					if ( $result["http_code"] == "200" ) {
						
						// Define uma mensagem de sucesso
						$this->sucess[]  = "Mensagem enviada com sucesso.<br>Acesse e confira: <a href='http://twitter.com/$this->username'><strong>@$this->username</strong></a>";
						
					}else{
						
						// Define uma mensagem de erro
						$this->errors[] = "Erro: Não foi possível enviar a mensagem.";
						
					}
					
				}
				
			}else{
				
				// Define uma mensagem de erro
				$this->errors[] = "Erro: Digite uma mensagem de até 140 caracteres.";
				
			}
			
		}else{
			
			// Define uma mensagem de erro
			$this->errors[] = "Erro: Mensagem em branco.";
			
		}
		
	}
	
}

?>