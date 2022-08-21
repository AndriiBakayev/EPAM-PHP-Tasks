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
 * and using them in method Getmovie to get and parce content to set Movie obgect
 * Scrapper
 */
class Scrapper
{
    private mixed $Transporter;
    private mixed $Parser;

    /**
     * Sets transporter and parser objects for future getMogie routine
     * @param  TransportInterface  $transporter object
     * @param  ParserInterface  $parser object
     */
    public function __construct(TransportInterface $transporter, ParserInterface $parser)
    {
        $this->Transporter = $transporter;
        $this->Parser = $parser;
    }
    /**
     * Gets content from url, prrses using Parser class object and sets movie object
     * @param  string  $url url of the site
     * @return Movie Movie is an object with title,poster and description of movie
     */
    public function getMovie(string $url): Movie
    {
        $getHtml = $this->Transporter->getContent($url);
        $parced = $this->Parser->parseContent($getHtml);
        $movie = new Movie();
        if (is_object($parced)) {
            $movie->setTitle($parced->title);
            $movie->setPoster($parced->poster);
            $movie->setDescription($parced->description);
        }
        return $movie;
    }
}
