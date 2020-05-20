# Biblioteca Juno CodeIgniter	

Biblioteca da Juno para emissão de boletos com o framework Codeigniter

## Quick Start

Acessa a pasta app/library  e realize o clone do projeto

	git clone https://github.com/ylmenezes/codeigniter-php-juno.git 

## Inicialize	

Para iniciar a biblioteca, você precisa inserir o token da sua conta como parâmetro obrigatório e chamar na classe que trabalha com uma função de construção.
Se existir uma função __construct(), copie apenas esse conteúdo, no demais casos, crie uma função de __construct();
	
       $aJuno = array('token' => **token_where**);
	   $this->load->library('Juno', $aJuno);
    