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
        $crawler = new Crawler($html);
        if (
            (null !== $crawler->filter('h1')->text())
            && (null !== $crawler->filter('.fposter a')->link()->getUri())
            && (null !== $crawler->filter('.fdesc')->text())
        ) {
            return (object)[
                'title' => $crawler->filter('h1')->text(),
                'poster' => $crawler->filter('.fposter a')->link()->getUri(),
                'description' => $crawler->filter('.fdesc')->text(),
            ];
        } else {
            return (object)[
                'title' => '',
                'poster' => '',
                'description' => '',
            ];
        }
    }
}
