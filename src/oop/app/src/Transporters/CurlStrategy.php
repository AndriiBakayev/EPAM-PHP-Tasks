<?php

namespace src\oop\app\src\transporters;

/**
 * For Class CurlStrategy use simple СURL PHP Library for getting the page content.
 * Note: Use next namespace for CurlStrategy Class - 
 * "namespace src\oop\app\src\Transporters;" (Like in this Interface)
 * Note: About СURL PHP you can read here:
 * https://www.php.net/manual/ru/book.curl.php
 * Attention: Think about why this Transporter might have a Strategy word in name!!!
 */
class CurlStrategy implements TransportInterface
{
    /** 
     * Gets content from site using CURL
     * 
     * @param string $url url to movie site
     * 
     * @return string returns string with site content
     */
    public function getContent(string $url): string
    {
        
        $user_agent = 'Mozilla HotFox 1.0';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CAINFO, 'src\oop\app\src\Transporters\cacert.pem');
        curl_setopt($ch, CURLOPT_CAPATH, 'src\oop\app\src\Transporters\cacert.pem');

        $res=curl_exec($ch);
        $res = iconv('CP1251', mb_detect_encoding($res), $res);
        curl_close($ch);

        return $res;

    }

        
        
        
    


}
