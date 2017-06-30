<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

/**
 * @author Vladislav Iavorskii
 */
class NasaClient
{
    private $authKey;
    private $endpoint;

    public function __construct($endpoint, $authKey)
    {
        $this->authKey = $authKey;
        $this->endpoint = $endpoint;
    }

    public function getNearObjectsByDate(\DateTime $startDate, \DateTime $endDate)
    {
        $client = new Client();
        $parameters = [
            "start_date" => $startDate->format("Y-m-d"),
            "end_date"   => $endDate->format("Y-m-d"),
            "api_key"    => $this->authKey
        ];
        $response = $client->get($this->endpoint . "?" . \GuzzleHttp\Psr7\build_query($parameters));
        $dataJson = $response->getBody()->getContents();
        $data = \GuzzleHttp\json_decode($dataJson, true);
        $objects = isset($data["near_earth_objects"]) ? $data["near_earth_objects"] : [];

        return $objects;
    }
}
