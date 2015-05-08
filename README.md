Maplink Console App
======================================

Programa que gera os custos e distâncias totais entre duas rotas utilizando o webservice da Maplink.

## Rodando o Programa

Para executar o programa, basta digitar o seguinte comando: 

Linux - php maplink.php

Windows - [Caminho do Diretório PHP]\php.exe maplink.php

### Parametros de entrada

Assim que o programada é executado, é requistado ao usuário o CEP de ambos os endereços que constituem a rota. 

### Outros webservices

Para apresentação dos endereços digitados pelo usuário, o programa consome o webservice gratuito do <a href="http://viacep.com.br" target="_blank">viacep.com.br</a> 
Assim o usuário não precisa digitar todos os dados dos endereços.

### Escolha de rota

Após confirmar os dois endereços que compõe a rota, o usuário deve escolher entre as seguintes opções:

* Rota padrão mais rápida.
* Rota evitando o trânsito.

### Resultados

Como saída o programa apresenta as seguintes informações.

* Tempo total da rota.
* Distância total.
* Custo de combustível.
* Custo total considerando pedágio.

### Vantagens

O programa possui, entre outros, os seguintes benefícios:

* Tratamento de exceções.
* Documentação no padrão phpDocumentor.
* Valida se as extensões PHP necessárias para a execução do programa (CURL, SOAP) estão disponíveis no sistema do usuário.
* Implementação de alguns recursos para melhorar a performance, como o uso de objetos ao invés de arrays (30%-40% de ganho).
* Multiplataforma.
* Workaround para controle de arrays e objetos retornados pelo webservice Maplink.

### Observação

O link do primeiro endereço do webservice na página do desafio no GitHub está errado.
Deve ser atualizado para <a href="http://dev.maplink.com.br/webservices/geocodificacao/">AddressFinder</a>.
