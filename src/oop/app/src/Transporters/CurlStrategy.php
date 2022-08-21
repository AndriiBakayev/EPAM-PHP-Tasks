<?php

namespace src\oop\app\src\transporters;

/**
 * For Class CurlStrategy use simple СURL PHP Library for getting the page content.
 * Uses Curl libulary strategy for ger pages'c content into a string
 * Note: About СURL PHP you can read here:
 * https://www.php.net/manual/ru/book.curl.php
 */
class CurlStrategy implements TransportInterface
{
    /**
     * Gets content from site using CURL and converts it into a string
     * Encoding into CP1251 is also included
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
        $res = curl_exec($ch);
        if ($res === false) {
                echo 'Error curl: ' . curl_error($ch);
                return '';
        }
        $res = iconv('CP1251', mb_detect_encoding($res), $res);

        return $res;
    }
}
