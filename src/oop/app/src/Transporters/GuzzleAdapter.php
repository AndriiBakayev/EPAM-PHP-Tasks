<?php

namespace src\oop\app\src\Transporters;
//use GuzzleHttp\Client;
/** 
 * For Class GuzzleAdapter use GuzzleHttp Client for getting the page content.
 * Note: Use next namespace for GuzzleAdapter Class - 
 * "namespace src\oop\app\src\Transporters;" (Like in this Interface) {
 * Note: About GuzzleHttp Client you can read here:
 * https://docs.guzzlephp.org/en/stable/
 * Attention: Think about why this Transporter might have a Adapter word in name!!!
 */
Class GuzzleAdapter implements TransportInterface
{
    /**
     * @param  string $url
     * @return string
     */
    public function getContent(string $url): string
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://httpbin.org/','timeout'  => 2.0]);
        $responce = $client->request('GET', $url);
        $html = (string) $responce->getBody();
       //echo $html; 
        return $html; 
    }
    

}

