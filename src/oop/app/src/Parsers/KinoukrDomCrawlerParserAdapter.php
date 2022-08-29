<?php

/**
 * Php version 8.1.9
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 * Class - KinoukrDomCrawlerParserAdapter .
 * Implement the ParserInterface and following methods:
 * parseContent() - returns Movie object with following properties:
 * $title, $poster, $description.
 *
 * For Class KinoukrDomCrawlerParserAdapter use Symfony DomCrawler Component for parsing page content.
 * Class - "namespace src\oop\app\src\Parsers;"
 * Note: About Symfony DomCrawler Component you can read here:
 * https://symfony.com/doc/current/components/dom_crawler.html
 */

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Crap4j;
use Symfony\Component\DomCrawler\Crawler;

/**
 * FilmixParserStrategy Class that parses site contents using DOM crawler
 * of symphony project
 * parseContent() - should return Movie object with following properties:
 * $title, $poster, $description.
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    private Crawler $crawler;
    private Movie $movie;

    public function __construct(Movie $movie, Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->movie = $movie;
    }

    /**
     * Function parseContent Parses site contents using DOM CRAWLER from
     * symphony package
     * Function parseContent Parses site contents using sing domcrawlerthe
     * parseContent() - returns std object with following properties:
     * $title, $poster, $description  u predefined page
     * class  detects needed content and sets StdObj back to csrapper
     *
     * @param string $html content of site
     *
     * @return mixed object with following properties: $title, $poster, $description.
     */
    public function parseContent(string $html): object
    {
        $this->crawler->addContent($html);
        if (
            (null !== $this->crawler->filter('h1')->text())
            && (null !== $this->crawler->filter('.fposter a')->link()->getUri())
            && (null !== $this->crawler->filter('.fdesc')->text())
        ) {
            $this->movie->setTitle($this->crawler->filter('h1')->text());
            $this->movie->setPoster($this->crawler->filter('.fposter a')->link()->getUri());
            $this->movie->setDescription($this->crawler->filter('.fdesc')->text());
        }

        return $this->movie;
    }
}
