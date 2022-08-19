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

class Scrapper
{
    private mixed $Transporter;
    private mixed $Parser;

    /**
     * @param  TransportInterface  $transporter
     * @param  ParserInterface  $parser
     */
    public function __construct(TransportInterface $transporter, ParserInterface $parser)
    {
        $this->Transporter = $transporter;
        $this->Parser = $parser;
    }
    /**
     * @param  string  $url
     * @return Movie
     */
    public function getMovie(string $url): Movie
    {
        echo $url;
        $getHtml = $this->Transporter->getContent($url);
        $data = $this->Parser->parseContent($getHtml);
        //echo $data['title'];
        $movie = new Movie($data);
        // $movie->setTitle('HI');
        // $movie->setPoster('poster');
        // $movie->setDescription('description');
        
        return $movie;
    }
}
