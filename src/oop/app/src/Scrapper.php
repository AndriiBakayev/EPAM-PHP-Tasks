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

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

/**
 * Initializes own private vars $Transporter and $Parser l by supplied objects
 * and using them in method GetMovie to get and parce content to set Movie obgect
 * Scrapper
 */
class Scrapper
{
    private mixed $transporter;
    private mixed $parser;
    private mixed $movie;

    /**
     * Sets transporter and parser objects for future getMogie routine
     * @param  TransportInterface  $transporter object
     * @param  ParserInterface  $parser object
     */
    public function __construct(TransportInterface $transporter, ParserInterface $parser, Movie $movie)
    {
        $this->transporter = $transporter;
        $this->parser = $parser;
        $this->movie = $movie;
    }
    /**
     * Gets content from url, prrses using Parser class object and sets Movie object
     * @param  string  $url url of the site
     * @return Movie Movie is an object with title,poster and description of Movie
     */
    public function getMovie(string $url): Movie
    {
        $getHtml = $this->transporter->getContent($url);
        $this->movie = $this->parser->parseContent($getHtml);

        return $this->movie;
    }
}
