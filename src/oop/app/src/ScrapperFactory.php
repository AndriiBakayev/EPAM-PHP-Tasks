<?php

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\KinoukrDomCrawlerParserAdapter;
use src\oop\app\src\Parsers\FilmixParserStrategy;
use src\oop\app\src\Transporters\CurlStrategy;
use src\oop\app\src\Transporters\GuzzleAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

/** Class which decides which transporter and which parser use for site
 * ScrapperFactory
 */
class ScrapperFactory
{
    private Movie $movie;

    public function __construct(Movie $movieLeft, Movie $movieRight)
    {
        $this->movieLeft = $movieLeft;
        $this->movieRight = $movieRight;
    }


    /**Makes object of transporter and parser according domain
     * @param string $domain
     * @return Scrapper sers tha scrapper object to get and parce content
     * @throws Exception Throws an exception when no predefined movie domain set
     */
    public function create(string $domain): Scrapper
    {
        switch ($domain) {
            case 'filmix':
                return new Scrapper(
                    new CurlStrategy(),
                    new FilmixParserStrategy($this->movieLeft),
                    $this->movieLeft
                );
            case 'kinoukr':
                return new Scrapper(
                    new GuzzleAdapter(new \GuzzleHttp\Client()),
                    new KinoukrDomCrawlerParserAdapter($this->movieRight, new Crawler()),
                    $this->movieRight
                );
            default:
                throw new Exception('Resource not found!');
        }
    }
}
