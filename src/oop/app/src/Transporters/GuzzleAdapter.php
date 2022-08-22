<?php

namespace src\oop\app\src\Transporters;

/**
 * Class GuzzleAdapter use GuzzleHttp Client for getting the page content.
 * Adopts site for parcing.
 * Note: About GuzzleHttp Client you can read here:
 * https://docs.guzzlephp.org/en/stable/
 */
class GuzzleAdapter implements TransportInterface
{
    /** gets the page content isung Guzzle libulary
     * @param  string $url for get
     * @return string Index.html source content
     */
    public function getContent(string $url): string
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://httpbin.org/','timeout'  => 2.0]);
        $responce = $client->request('GET', $url);
        $html = (string) $responce->getBody();

        return $html;
    }
}
