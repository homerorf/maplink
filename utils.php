<?php
/**
 * PHP Console App - Maplink Demo
 * @description Funçoes de apoio para o código principal.
 * @author Homero Romão Filho
 * @copyright Maplink 2015
 * @version 1.0
 */

// Função replaceAccents - função para substituir os acentos nas palavras já que os recursos utf8_decode e iconv não funcionam para todos os consoles de todos os sistemas operacionais.
function replaceAccents($str)
{
	$accents_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	$str = strtr($str, $accents_array);
	return $str;
}

// Função checkInternetConnection - função para checar se há acesso ao webservice Maplink.
function checkInternetConnection()
{	
	$cmdCheckSoapAvaibility = exec('C:\PHP\php.exe -r "phpinfo();"');
	if(strpos($cmdCheckSoapAvaibility, 'Soap Client => enabled'))
	{
		return true;
	}
	else
	{
		return false;		
	}
}

// Função checkCurlAvaibility - checa se o CURL da instalação local do PHP está habilitada.
function checkCurlAvaibility()
{	
	if(extension_loaded('curl'))
	{
		return true;
	}
	else
	{
		return false;		
	}
}

// Função checkSoapAvaibility - checa se o SOAP nativo da instalação local do PHP está habilitada.
function checkSoapAvaibility()
{	
	if(extension_loaded('soap'))
	{
		return true;
	}
	else
	{
		return false;		
	}
}

// Função convertISOTime - converte a duração no formato ISO para a apresentação final do programa.
function convertISOTime($duration)
{
    $di  = new DateInterval($duration);
    $dt  = new DateTime('1970-01-01 00:00:00');
    $str = date_add($dt, $di)->format('YmdHis');

    $arr['hours']   = (int) substr($str, 8, 2);
    $arr['minutes'] = (int) substr($str, 10, 2);
    $arr['seconds'] = (int) substr($str, -2);
	
	if($arr['hours']>0)
	{
		return $arr['hours'].' horas, '.$arr['minutes'].' minutos e '.$arr['seconds'].'segundos';
	}
	else
	{
		return $arr['minutes'].' minutos e '.$arr['seconds'].' segundos.';		
	}
	
    return $arr;
} 

// Função convertISOTime - faz a pesquisa no webservice gratuito do http://viacep.com.br para a cidade digitada e retorna a sigla do Estado, para que o usuario nao tenha que digita-la.
function getAddressByZipCode($zipCode, $address)
{
	if(checkCurlAvaibility())
	{
		$ch = curl_init();
		$url = "http://viacep.com.br/ws/".trim($zipCode)."/xml/";
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);     
		$response = curl_exec($ch);
		curl_close($ch);
		
		if((strlen($response)>0)||(!(strpos($response)=="Bad Request")))
		{
			$xml = simplexml_load_string($response);
			$address->setStreet(replaceAccents($xml->{'logradouro'}));
			$address->setDistrict(replaceAccents($xml->{'bairro'}));
			$address->city->setName(replaceAccents($xml->{'localidade'}));
			$address->city->setState(replaceAccents($xml->{'uf'}));
			$address->setIBGE(replaceAccents($xml->{'ibge'}));
			return true;
		}
		else
		{
			return false;			
		}
	}
	else
	{
		return false;
	}		
}

// Função getLatitudeLongitude - popula o objeto de endereço com a latitude e longitude.
function getLatitudeLongitude($address, $ao, $token)
{	
	try
	{
		if(checkSoapAvaibility())
		{
			$client = new SoapClient('http://services.maplink.com.br/webservices/v3/AddressFinder/AddressFinder.asmx?WSDL');	 
			$function = 'findAddress'; 
			$arguments= array(
							'findAddress' => array(
												'address' => 
															array(
															'street' => $address->getStreet(), 
															'houseNumber' => $address->getHouseNumber(), 
															'zip' => $address->getZip(),
															'district' => $address->getDistrict(),
															'city' => 
																array(
																	'name' => $address->city->getName(),
																	'state' => $address->city->getState()
																)
															), 
												'ao' => 
															array(
															'matchType' => $ao->getMatchType(),
															'usePhonetic' => $ao->getUsePhonetic(), 
															'searchType' => $ao->getSearchType(), 
															'resultRange' => 
																array(
																	'pageIndex' => $ao->resultRange->getPageIndex(), 
																	'recordsPerPage' => $ao->resultRange->getRecordsPerPage()
																)
															), 
												'token' => $token->getToken()
											)
						);					
			$options = array('location' => 'http://services.maplink.com.br/webservices/v3/AddressFinder/AddressFinder.asmx');	 
			$returned = $client->__soapCall($function, $arguments, $options);	 
			if($returned)
			{
				//Um pequeno workaround, pois verifiquei que o retorno do objeto pode ser tanto uma array, quanto um objeto.
				if(is_object($returned->findAddressResult->addressLocation->AddressLocation))
				{
					$address->setLatitude(trim($returned->findAddressResult->addressLocation->AddressLocation->point->x));
					$address->setLongitude(trim($returned->findAddressResult->addressLocation->AddressLocation->point->y));						
				}
				else
				{
					$address->setLatitude(trim($returned->findAddressResult->addressLocation->AddressLocation[0]->point->x));
					$address->setLongitude(trim($returned->findAddressResult->addressLocation->AddressLocation[0]->point->y));				
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e)
	{
		return false;	
	}
}

// Função getLatitudeLongitude - popula o objeto de resultado com os valores de total finais.
function getRouteProximityTotals($firstAddress, $secondAddress, $ro, $vehicle, $radius, $token, $results)
{	
	try
	{
		if(checkSoapAvaibility())
		{
			//Cria uma array em separado devido as limitacoes do PHP na implementacao nativa do SOAP do PHP para elementos com o nome da chave repetitivos.
			$routeStop = array();			
			$routeStop[0]->description = $firstAddress->getStreet();
			$routeStop[0]->point->x = $firstAddress->getLatitude();
			$routeStop[0]->point->y = $firstAddress->getLongitude();			
			$routeStop[1]->description = $secondAddress->getStreet();
			$routeStop[1]->point->x = $secondAddress->getLatitude();
			$routeStop[1]->point->y = $secondAddress->getLongitude();
						
			$client = new SoapClient('http://services.maplink.com.br/webservices/v1.1/routeproximity/routeproximity.asmx?WSDL');	 
			$function = 'getRouteProximityTotals'; 
			$arguments= array(
							'getRouteProximityTotals' => 
							array(
							'rs' => array(
									'RouteStop' =>
										$routeStop
								),	
							'ro' =>
								array(
										'language' => $ro->getLanguage(),
										'routeDetails' => 
										array(
												'descriptionType' => $ro->routeDetails->getDescriptionType(),
												'routeType' => $ro->routeDetails->getRouteType(),
												'optimizeRoute' => $ro->routeDetails->getOptimizeRoute()
										),
										'vehicle' => 
										array(
												'tankCapacity' => $vehicle->getTankCapacity(),
												'averageConsumption' => $vehicle->getAverageConsumption(),
												'fuelPrice' => $vehicle->getFuelPrice(),
												'averageSpeed' => $vehicle->getAverageSpeed(),
												'tollFeeCat' => $vehicle->getTollFeeCat()
										),
										'radius' => $radius->getRadius()
								),										  
							'token' => $token->getToken()
						)
					);										
			$options = array('location' => 'http://services.maplink.com.br/webservices/v1.1/routeproximity/routeproximity.asmx');	 
			$returned = $client->__soapCall($function, $arguments, $options);	 
			if($returned)
			{
				$results->setTotalDistance($returned->getRouteProximityTotalsResult->totalDistance);
				$results->setTotalTime($returned->getRouteProximityTotalsResult->totalTime);
				$results->setTotalFuelCost($returned->getRouteProximityTotalsResult->totalfuelCost);
				$results->setTotalCost($returned->getRouteProximityTotalsResult->totalCost);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e)
	{
		return false;	
	}
}
?>