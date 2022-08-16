<?php

namespace src\oop\app\src\Transporters;

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
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url, [
            'auth' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        echo $res->getBody();
        // {"type":"User"...' 
    }
    

}
}
