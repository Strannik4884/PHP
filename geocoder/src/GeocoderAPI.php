<?php

require_once ('GeoObject.php');
require_once ('Config.php');

class GeocoderAPI
{
    private $config;

    public function __construct()
    {
        // load config
        $this->config = new Config();
    }

    // get nearest metro for geoobject by coordinates
    private function searchMetro(string $coordinates): array
    {
        // query parameters
        $queryParameters = [
            'apikey' => $this->config->getKey(),
            'geocode' => $coordinates,
            'kind' => 'metro',
            'results' => 1,
            'format' => 'json'
        ];
        // read response from API
        $response = file_get_contents($this->config->getDomain() . '?' . http_build_query($queryParameters));
        // if error
        if($response === false){
            throw new APIException('Error while accessing the API service');
        }
        // decode response from json to array
        $response = json_decode($response, true);
        $metro = array();
        $metro['count'] = (int) $response['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'];
        // if metro not found
        if($metro['count'] == 0)
        {
            return $metro;
        }
        // set metro properties
        $metro['metroName'] = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];
        $metro['metroCoordinates'] = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        return $metro;
    }

    // search geoobject by address
    public function searchAddress(string $address): array
    {
        // query parameters
        $queryParameters = [
            'apikey' => $this->config->getKey(),
            'geocode' => $address,
            'format' => 'json',
        ];
        // read response from API
        $response = file_get_contents($this->config->getDomain() . '?' . http_build_query($queryParameters));
        // if error
        if($response === false){
            throw new APIException('Error while accessing the API service');
        }
        // decode response from json to array
        $response = json_decode($response, true);
        $geoObjects = array();
        $results = $response['response']['GeoObjectCollection']['featureMember'];
        // create geoobjects array
        foreach ($results as $item)
        {
            $geoObject = new GeoObject();
            $geoObject->setStructuredAddress($item['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted']);
            $geoObject->setCoordinates($item['GeoObject']['Point']['pos']);
            $metro = $this->searchMetro($geoObject->getCoordinates());
            if($metro['count'] > 0)
            {
                $geoObject->setMetroName($metro['metroName']);
                $geoObject->setMetroCoordinates($metro['metroCoordinates']);
            }
            array_push($geoObjects, $geoObject);
        }
        return $geoObjects;
    }
}