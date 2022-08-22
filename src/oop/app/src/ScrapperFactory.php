<?php

namespace src\oop\app\src;

use src\oop\app\src\Parsers\KinoukrDomCrawlerParserAdapter;
use src\oop\app\src\Parsers\FilmixParserStrategy;
use src\oop\app\src\Transporters\CurlStrategy;
use src\oop\app\src\Transporters\GuzzleAdapter;
use Exception;

/** Class which decides which transporter and which parser use for site
 * ScrapperFactory
 */
class ScrapperFactory
{
    /**Makes object of transporter and parser according domain
     * @param string $domain
     * @return Scrapper sers tha scrapper object to get and parce content
     * @throws Exception Throws an exception when no predefined movie domain set
     */
    public function create(string $domain): Scrapper
    {
        switch ($domain) {
            case 'filmix':
                return new Scrapper(new CurlStrategy(), new FilmixParserStrategy());
            case 'kinoukr':
                return new Scrapper(new GuzzleAdapter(), new KinoukrDomCrawlerParserAdapter());
            default:
                throw new Exception('Resource not found!');
        }
    }
}
