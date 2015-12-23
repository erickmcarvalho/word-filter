# Word Filter

Este programa tem como objeto de obter uma lista de palavras digitadas incorretamente, alterar em etapas e retornar sugestões em base de um dicionário.

Após receber a lista, cada palavra passará por 3 operações:

1. Retirar uma letra em todas as posições;
2. Adicionar uma letra em qualquer posição;
3. Trocar qualquer letra na mesma posição.

Cada retorno das operações 1, 2 e 3, será consultado no dicionário e retornado sugestões para correção.

**Exemplos:**

* A palavra 'crto' pode se referir à palavra do dicionário 'corte', realizando uma vez a operação 2 e uma vez a operação 3.
* A palavra 'crto' pode se referir à palavra do dicionário 'curto', realizando uma vez a operação 2.
* A palavra 'hortgrafea' não pode se referir à palavra do dicionário 'ortografia'.


## Requisitos ##

* PHP 5.4
* SQLite 3
* Composer

**Testes:**

* PHP 5.6
* PHPUnit

## Instalação ##

Após extrair os arquivos em um diretório, faça a instalação via composer.  
Exemplo:

```
php composer.phar install --no-dev
```

## Modo de uso ##

Execute o programa através do PHP CLI.

```
php run.php
```

**Gerenciando Dicionários:**

Execute o programa através do comando: *php run.php*  
Selecione a opção: *dictionary*

Ações:

* Adicionando palavras
  1. Selecione a opção *add*.
  2. Digite as palavras desejadas separando-as através do *enter*.
  3. Digite o comando *--save* para salvar.

* Removendo palavras
  1. Selecione a opção *remove*.
  2. Digite as palavras desejadas separando-as através do *enter*.
  3. Digite o comando *--save* para salvar.
  4. Digite o comando *--save* para salvar.

* Consultando palavra da base de dados
  1. Selecione a opção *query*.
  2. Digite a palavra desejada e pressione *enter* para consultar.

* Listando todas as palavras da base de dados
  1. Selecione a opção *list*.
  2. Esta irá exibir todas as palavras cadastradas.

**Corretor:**

Execute o programa através do comando: *php run.php*  
Selecione a opção: *corrector*

1. Digite as palavras desejadas separando-as através do *enter*.
2. Digite o comando *--run* para rodar as sugestões e exibir a tabela.

* Utilize o comando *--reset* para limpar a lista das palavras informadas.
* Utilize o comando *--list* para exibir todas as palavras listadas.
* Utilize o comando *--close* para retornar ao menu principal.