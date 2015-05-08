<?php
/**
 * PHP Console App - Maplink Demo 
 * @description Classes dos principais objetos utilizados no sistema.
 * @author Homero Romão Filho
 * @copyright Maplink 2015
 * @version 1.0
 */

// Classe Address
class Address
{
	public $street;
	public $houseNumber;
	public $zip;
	public $district;
	public $city;
	public $ibge;
	public $latitude;
	public $longitude;
	
	public function __construct()
	{
        $this->city = new City();
    }
						
	public function setStreet($value)
	{
        $this->street = $value;
    }
	
	public function getStreet()
	{
        return $this->street;
    }	
	
	public function setHouseNumber($value)
	{
        $this->houseNumber = $value;
    }
	
	public function getHouseNumber()
	{
        return $this->houseNumber;
    }	
	
	public function setZip($value)
	{
        $this->zip = $value;
    }
	
	public function getZip()
	{
        return $this->zip;
    }	
	
	public function setDistrict($value)
	{
        $this->district = $value;
    }
	
	public function getDistrict()
	{
        return $this->district;
    }	

	public function setIBGE($value)
	{
        $this->ibge = $value;
    }
	
	public function getIBGE()
	{
        return $this->ibge;
    }
		
	public function setLatitude($value)
	{
        $this->latitude = $value;
    }
	
	public function getLatitude()
	{
        return $this->latitude;
    }
	
	public function setLongitude($value)
	{
        $this->longitude = $value;
    }
	
	public function getLongitude()
	{
        return $this->longitude;
    }							
}

// Classe City
class City
{
	public $name;
	public $state;
					
	public function setName($value)
	{
        $this->name = $value;
    }
	
	public function getName()
	{
        return $this->name;
    }	
	
	public function setState($value)
	{
        $this->state = $value;
    }
	
	public function getState()
	{
        return $this->state;
    }						
}

// Classe Ao
class Ao
{
	public $matchType;
	public $usePhonetic;
	public $searchType;
	public $resultRange;
	
	public function __construct()
	{
        $this->resultRange = new ResultRange();
    }
						
	public function setMatchType($value)
	{
        $this->matchType = $value;
    }
	
	public function getMatchType()
	{
        return $this->matchType;
    }	

	public function setUsePhonetic($value)
	{
        $this->usePhonetic = $value;
    }
	
	public function getUsePhonetic()
	{
        return $this->usePhonetic;
    }
	
	public function setSearchType($value)
	{
        $this->searchType = $value;
    }
	
	public function getSearchType()
	{
        return $this->searchType;
    }							
}

// Classe ResultRange
class ResultRange
{
	public $pageIndex;
	public $recordsPerPage;
	
	public function setPageIndex($value)
	{
        $this->pageIndex = $value;
    }
	
	public function getPageIndex()
	{
        return $this->pageIndex;
    }
	
	public function setRecordsPerPage($value)
	{
        $this->recordsPerPage = $value;
    }
	
	public function getRecordsPerPage()
	{
        return $this->recordsPerPage;
    }			
}

// Classe Token
class Token
{
	public $token;
	
	public function setToken($value)
	{
        $this->token = $value;
    }
	
	public function getToken()
	{
        return $this->token;
    }			
}

// Classe Ro
class Ro
{
	public $language;	
	public $routeDetails;
	
	public function __construct()
	{
        $this->routeDetails = new RouteDetails();
    }	
	
	public function setLanguage($value)
	{
        $this->language = $value;
    }
	
	public function getLanguage()
	{
        return $this->language;
    }		
}

// Classe RouteDetails
class RouteDetails
{
	public $descriptionType;	
	public $routeType;
	public $optimizeRoute;	
	public $poiRoute;
	public $barriersList;
	public $barriersPoints;
	
	public function __construct()
	{
        $this->poiRoute = new PoiRoute();
		$this->barriersList = new BarriersList();
    }
	
	public function setDescriptionType($value)
	{
        $this->descriptionType = $value;
    }
	
	public function getDescriptionType()
	{
        return $this->descriptionType;
    }
	
	public function setRouteType($value)
	{
        $this->routeType = $value;
    }
	
	public function getRouteType()
	{
        return $this->routeType;
    }
	
	public function setOptimizeRoute($value)
	{
        $this->optimizeRoute = $value;
    }
	
	public function getOptimizeRoute()
	{
        return $this->optimizeRoute;
    }						
}

// Classe PoiRoute
class PoiRoute
{
	public $lat;	
	public $long;
	
	public function setLat($value)
	{
        $this->lat = $value;
    }
	
	public function getLat()
	{
        return $this->lat;
    }
	
	public function setLong($value)
	{
        $this->long = $value;
    }
	
	public function getLong()
	{
        return $this->long;
    }			
}

// Classe BarriersList
class BarriersList
{
	public $lat;	
	public $long;
	
	public function setLat($value)
	{
        $this->lat = $value;
    }
	
	public function getLat()
	{
        return $this->lat;
    }
	
	public function setLong($value)
	{
        $this->long = $value;
    }
	
	public function getLong()
	{
        return $this->long;
    }			
}

// Classe Vehicle
class Vehicle
{
	public $tankCapacity;
	public $averageConsumption;
 	public $fuelPrice;
	public $averageSpeed;
	public $tollFeeCat;
	
	public function setTankCapacity($value)
	{
        $this->tankCapacity = $value;
    }
	
	public function getTankCapacity()
	{
        return $this->tankCapacity;
    }
	
	public function setAverageConsumption($value)
	{
        $this->averageConsumption = $value;
    }
	
	public function getAverageConsumption()
	{
        return $this->averageConsumption;
    }	
	
	public function setFuelPrice($value)
	{
        $this->fuelPrice = $value;
    }
	
	public function getFuelPrice()
	{
        return $this->fuelPrice;
    }	
	
	public function setAverageSpeed($value)
	{
        $this->averageSpeed = $value;
    }
	
	public function getAverageSpeed()
	{
        return $this->averageSpeed;
    }		
	
	public function setTollFeeCat($value)
	{
        $this->tollFeeCat = $value;
    }
	
	public function getTollFeeCat()
	{
        return $this->tollFeeCat;
    }			
}

// Classe RouteLine
class RouteLine
{
	public $width;
	public $RGB;
	public $transparency;
	
	public function setWidth($value)
	{
        $this->width = $value;
    }
	
	public function getWidth()
	{
        return $this->width;
    }
	
	public function setRGB($value)
	{
        $this->rgb = $value;
    }
	
	public function getRGB()
	{
        return $this->rgb;
    }
	
	public function setTransparency($value)
	{
        $this->transparency = $value;
    }
	
	public function getTransparency()
	{
        return $this->transparency;
    }			
}

// Classe Radius
class Radius
{
	public $radius;

	public function setRadius($value)
	{
        $this->radius = $value;
    }
	
	public function getRadius()
	{
        return $this->radius;
    }
}

// Classe Results
class Results
{
	public $totalTime;
	public $totalDistance;
	public $totalFuelCost;
	public $totalCost;

	public function setTotalTime($value)
	{
        $this->totalTime = $value;
    }
	
	public function getTotalTime()
	{
        return $this->totalTime;
    }
	
	public function setTotalDistance($value)
	{
        $this->totalDistance = $value;
    }
	
	public function getTotalDistance()
	{
        return $this->totalDistance;
    }
	
	public function setTotalFuelCost($value)
	{
        $this->totalFuelCost = $value;
    }
	
	public function getTotalFuelCost()
	{
        return $this->totalFuelCost;
    }	
	
	public function setTotalCost($value)
	{
        $this->totalCost = $value;
    }
	
	public function getTotalCost()
	{
        return $this->totalCost;
    }					
}
?>