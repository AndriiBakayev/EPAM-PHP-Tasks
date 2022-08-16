<?php
/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Dont forget to create variables for 
 * TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */
namespace src\oop\app\src

class Scrapper()
{
    protected Transport = new TransportInterface;
    protected Parser = new ParserInterface;
    public function getMovie(string $url):movie{

    }
}
