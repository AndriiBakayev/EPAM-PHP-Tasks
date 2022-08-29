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
                    new FilmixParserStrategy(new Movie()),
                    new Movie()
                );
            case 'kinoukr':
                return new Scrapper(
                    new GuzzleAdapter(new \GuzzleHttp\Client()),
                    new KinoukrDomCrawlerParserAdapter(new Movie(), new Crawler()),
                    new Movie()
                );
            default:
                throw new Exception('Resource not found!');
        }
    }
}
