<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class API
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.sejm.gov.pl/eli/',
        ]);
    }

    /**
     * Generic fetch function
     * @throws GuzzleException
     */
    protected function fetch($method, $uri, $options = [])
    {
        return json_decode($this->client->request($method, $uri, $options)->getBody());
    }

    /**
     * Fetches list of recently changed acts
     * @throws GuzzleException
     */
    public function fetchChangedActs(string $since, int $offset = 0, int $limit = 50)
    {
        return $this->fetch('GET', 'changes/acts', [
            'query' => compact('since', 'offset', 'limit'),
        ]);
    }

    /**
     * Fetches details of a given act
     * @throws GuzzleException
     */
    public function fetchActDetails(string $publisher, int $year, int $position)
    {
        return $this->fetch('GET', 'acts/' . $publisher . '/' . $year . '/' . $position);
    }

    /**
     * Searches and filters acts
     * @throws GuzzleException
     */
    public function searchActs(array $options)
    {
        return $this->fetch('GET', 'acts/search', [
            'query' => $options,
        ]);
    }
}
