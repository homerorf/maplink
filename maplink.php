<?php
/**
 * PHP Console App - Maplink Demo
 * @description Programa principal - Run: php maplink.php.
 * @author Homero Romão Filho
 * @copyright Maplink 2015
 * @version 1.0
 */

//Set do timezone para ocultar mensagem de erro em algumas versão do PHP.
date_default_timezone_set("America/Sao_Paulo");
//Aumenta o limite de tempo do script.
set_time_limit(0);
//Arquivo PHP com as funções de apoio ao código principal.
require("utils.php");
//Arquivo de classes contendo os objetos do sistema.
require("classes.php");

//Principal tratamento de exceções.
try
{
	//Inicia o fluxo principal do programa.
	
	echo "\n";
	
	//Faz a saudação ao usuário de acordo com o horário do dia.
	if(date("H") < 12) 
	{
		$welcome = 'Bom dia!';
	} 
	else if(date('H') > 11 && date("H") < 18)
	{
		$welcome = 'Boa tarde!';
		
	}
	else if(date('H') > 17)
	{
		$welcome = 'Boa noite!';
	}
	
	echo $welcome. " Obrigado por utilizar o aplicativo demo de calculo de rota da Maplink.";
	echo "\n\n";

	//Instancia objeto que armazena o token Maplink.
	$token = new Token();
	$token->setToken('c13iyCvmcC9mzwkLd0LCbCBHcXYD5mUA5m2jNGutNXK6NJc6NJt=');
		
	//Instancia objeto do primeiro endereco.
	$firstAddress = new Address();

	//Instancia objeto do segundo endereco.
	$secondAddress = new Address();
		
	//Instancia o objeto Ao para ambos os enderecos, ja que os valores dos parametros sao iguais.
	$ao = new Ao(); 
	$ao->setMatchType('0');
	$ao->setUsePhonetic('false');
	$ao->setSearchType('2');
	$ao->resultRange->setPageIndex('1');
	$ao->resultRange->setRecordsPerPage('10');
	
	//Instancia o objeto contendo os resultados do desafio.
	$results = new Results();
		
	//Faz o loop utilizando do/while para melhor performance, e coleta o primeiro endereco de pesquisa.
	do
	{
		do
		{			
			echo "Insira o CEP do primeiro Endereco para pesquisa (somente numeros): ";
			$handleFirstZipCode = fopen("php://stdin","r");
			$firstZipCode = fgets($handleFirstZipCode);
			
			//Validação do CEP digitado para o primeiro endereço.
			if(strlen(trim($firstZipCode))>1)
			{
				break;
			}
			elseif(!is_numeric(trim($firstZipCode)))
			{
				echo "Por favor, digite somente numeros.";
				echo "\n";
			}
			else
			{
				echo "O CEP digitado esta incorreto.";
				echo "\n";
			}
		}
		while(true);
	
		//Popula o objeto de endereço com o CEP informado.
		$addressData = getAddressByZipCode($firstZipCode, $firstAddress);
		
		//Finaliza a primeira etapa do primeiro endereco.
		if($addressData)
		{		
			echo "\n";
			echo "O endereco digitado foi:";
			echo "\n";
			echo "Endereco: ". $firstAddress->getStreet() . "\n";
			echo "Bairro: ". $firstAddress->getDistrict() . "\n";
			echo "Cidade: ". $firstAddress->city->getName() . "\n";
			echo "Estado: ". $firstAddress->city->getState() . "\n";
			echo "IBGE: ". $firstAddress->getIBGE() . "\n";
			echo "\n";
			
			do
			{
				echo "Caso o endereco esteja correto, insira o Numero do mesmo. Caso contrario, digite E: ";
				$handleFirstNumber = fopen ("php://stdin","r");
				$firstNumber = fgets($handleFirstNumber);	
				
				//Validação do numero do endereco digitado para o primeiro endereço.
				if(trim($firstNumber)=="E")
				{
					echo "Ok, vamos comecar novamente.";
					break;
				}
				elseif(strlen(trim($firstNumber))>1)
				{
					$firstAddress->setHouseNumber($firstNumber);
					break;
				}
				elseif(!is_numeric(trim($firstNumber)))
				{
					echo "Desculpe mas voce nao digitou um numero.";
					echo "\n";
				}
				else
				{
					echo "O Numero do endereco digitado esta incorreto.";
					echo "\n";
				}
			}
			while(true);
			
			echo "Voce digitou o numero ".$firstNumber;
			echo "Digite C caso o primeiro endereco esteja correto, e pressione Enter. Caso contrario digite E: ";
			$handleGo = fopen("php://stdin","r");
			$go = fgets($handleGo);
			
			if(trim($go)=="C")
			{
				//Pesquisa latitude e longitude para o endereco digitado.
				$setLatitudeLongitude = getLatitudeLongitude($firstAddress, $ao, $token);
				if($setLatitudeLongitude)
				{
					break;
				}
				else
				{
					echo "Houve um erro na validacao do endereco.\n";
					exit();	
				}
			}
		}
		else
		{
			echo "Nenhum endereco foi encontrado para o CEP digitado.\n";
			exit();		
		}
	}
	while(true);
	
	echo "\nOk, agora vamos seguir para o segundo endereco de pesquisa.\n";
	
	//Coleta o segundo endereco de pesquisa.
	do
	{
		do
		{			
			echo "Insira o CEP do segundo Endereco para pesquisa (somente numeros): ";
			$handleSecondZipCode = fopen("php://stdin","r");
			$secondZipCode = fgets($handleSecondZipCode);
			
			//Validação do CEP digitado para o second endereço.
			if(strlen(trim($secondZipCode))>1)
			{
				break;
			}
			elseif(!is_numeric(trim($secondZipCode)))
			{
				echo "Por favor, digite somente numeros.";
				echo "\n";
			}
			else
			{
				echo "O CEP digitado esta incorreto.";
				echo "\n";
			}
		}
		while(true);
	
		//Popula o objeto de endereço com o CEP informado.
		$addressData = getAddressByZipCode($secondZipCode, $secondAddress);
		
		//Finaliza a primeira etapa do segundo endereco.
		if($addressData)
		{		
			echo "\n";
			echo "O endereco digitado foi:";
			echo "\n";
			echo "Endereco: ". $secondAddress->getStreet() . "\n";
			echo "Bairro: ". $secondAddress->getDistrict() . "\n";
			echo "Cidade: ". $secondAddress->city->getName() . "\n";
			echo "Estado: ". $secondAddress->city->getState() . "\n";
			echo "IBGE: ". $secondAddress->getIBGE() . "\n";
			echo "\n";
			
			do
			{
				echo "Caso o endereco esteja correto, insira o Numero do mesmo. Caso contrario, digite E: ";
				$handleSecondNumber = fopen ("php://stdin","r");
				$secondNumber = fgets($handleSecondNumber);	
				
				//Validação do numero do endereco digitado para o primeiro endereço.
				if(trim($firstNumber)=="E")
				{
					echo "Ok, vamos comecar novamente.";
					break;
				}
				elseif(strlen(trim($firstNumber))>1)
				{
					$secondAddress->setHouseNumber($secondNumber);
					break;
				}
				elseif(!is_numeric(trim($$secondNumberNumber)))
				{
					echo "Desculpe mas voce nao digitou um numero.";
					echo "\n";
				}
				else
				{
					echo "O Numero do endereco digitado esta incorreto.";
					echo "\n";
				}
			}
			while(true);
			
			echo "Voce digitou o numero ".$secondNumber;
			echo "Digite C caso o segundo endereco esteja correto, e pressione Enter. Caso contrario digite E: ";
			$handleGo = fopen("php://stdin","r");
			$go = fgets($handleGo);
			
			if(trim($go)=="C")
			{
				//Pesquisa a latitude e longitude para o endereco digitado.
				$setLatitudeLongitude = getLatitudeLongitude($secondAddress, $ao, $token);
				if($setLatitudeLongitude)
				{
					break;
				}
				else
				{
					echo "Houve um erro na validacao do endereco.\n";
					exit();	
				}
			}
		}
		else
		{
			echo "Nenhum endereco foi encontrado para o CEP digitado.\n";
			exit();		
		}
	}
	while(true);
	
	//Faz o loop utilizando do/while para melhor performance, coleta a opcao desejada pelo usuario com relacao a rota (Rota padrão mais rápida ou Rota evitando o trânsito), e apresenta os valores finais.
	do
	{
		do
		{
			echo "\n";			
			echo "Escolha a opcao de rota desejada.\n";
			echo "Digite 1 para uma rota padrao mais rapida.\n";
			echo "Digite 2 para uma rota evitando o transito.\n";
			$handleRoute = fopen("php://stdin","r");
			$route = fgets($handleRoute);
			
			//Validação da rota digitada.
			if(strlen(trim($route))>0)
			{
				if($route==1)
				{
					$usedRoute = '0';
				}
				else
				{
					$usedRoute = '23';
				}
				
				//Instancia os objetos da rota que serao usados nesse desafio.
				$ro = new Ro();
				$ro->setLanguage('portugues');
				$ro->routeDetails->setDescriptionType('1');
				$ro->routeDetails->setRouteType($usedRoute);
				$ro->routeDetails->setOptimizeRoute('0');
				
				$vehicle = new Vehicle();
				$vehicle->setTankCapacity('20');
				$vehicle->setAverageConsumption('9');
				$vehicle->setFuelPrice('3');
				$vehicle->setAverageSpeed('60');
				$vehicle->setTollFeeCat('2');
				
				$radius = new Radius();
				$radius->setRadius('100');
	
				$returned = getRouteProximityTotals($firstAddress, $secondAddress, $ro, $vehicle, $radius, $token, $results);
	
				if($returned)
				{
					//Finaliza apresentando os resultados finais.
					echo "Seguem os valores totais da rota calculados pelo servico Maplink:\n\n";
					echo "Tempo total da rota: ".convertISOTime(trim($results->getTotalTime()))."\n";
					echo "Distancia total: ".number_format(trim($results->getTotalDistance()), 2, ',', '.')." KM.\n";
					echo "Custo de combustivel: R$ ".number_format(trim($results->getTotalFuelCost()), 2, ',', '.').".\n";
					echo "Custo total considerando pedagio: R$ ".number_format(trim($results->getTotalCost()), 2, ',', '.').".\n";
					echo "\n";
					exit();
				}
				else
				{
					echo "Houve um erro no processamento dos resultados finais para as rotas escolhidas.";
					exit();
				}
				break;
			}
			elseif(!is_numeric(trim($route)))
			{
				echo "Por favor, digite a rota desejada.";
				echo "\n";
			}
			else
			{
				echo "A rota digitada esta incorreta.";
				echo "\n";
			}		
		}
		while(true);
	}
	while(true);	
}
catch(Exception $e)
{
	echo('Erro na execucao do programa Maplink: '. $e->getMessage());
	exit();	
}
?>