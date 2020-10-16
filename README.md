# Biblioteca Juno Versão 1.0

Biblioteca da Juno para emissão de boletos

## Quick Start

Download da Class

	git clone https://github.com/ylmenezes/codeigniter-php-juno.git 

## Inicialize	

Para iniciar a biblioteca, você precisa inserir o token da sua conta como parâmetro obrigatório e chamar na classe que trabalha com uma função de construção.
Se existir uma função __construct(), copie apenas esse conteúdo, no demais casos, crie uma função de __construct();
	
   	$aJuno = array('token' => **token_where**);
	$juno = new Juno($aJuno);
    
