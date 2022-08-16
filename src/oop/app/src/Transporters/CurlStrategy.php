<?php

namespace src\oop\app\src\Transporters;

/**
 * For Class CurlStrategy use simple СURL PHP Library for getting the page content.
 * Note: Use next namespace for CurlStrategy Class - 
 * "namespace src\oop\app\src\Transporters;" (Like in this Interface)
 * Note: About СURL PHP you can read here:
 * https://www.php.net/manual/ru/book.curl.php
 * Attention: Think about why this Transporter might have a Strategy word in name!!!
 */
Class CurlStrategy implements TransportInterface
{
    /**
     * @param  string $url
     * @return string
     */
    public function getContent(string $url): string
    {
        $url_one = $url;

        $user_agent = 'Mozilla HotFox 1.0';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_one);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;

    }

        
        
        
    


}
