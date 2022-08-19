<?php
/**
 * Php version 8.1.9
 * 
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 * Create two Classes - KinoukrDomCrawlerParserAdapter and FilmixParserStrategy.
 * Implement the ParserInterface and following methods:
 * parseContent() - should return Movie object with following properties:
 * $title, $poster, $description.
 *
 * For Class KinoukrDomCrawlerParserAdapter use Symfony DomCrawler Component for parsing page content.
 * Note: Use next namespace for KinoukrDomCrawlerParserAdapter Class - "namespace src\oop\app\src\Parsers;" (Like in this Interface)
 * Note: About Symfony DomCrawler Component you can read here:
 * https://symfony.com/doc/current/components/dom_crawler.html
 * Attention: Think about why this Parser might have a Adapter word in name!!!
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
     * Function parseContent Parses site contents using DOM CRAWLER from symphony
     * 
     * @param string $html content of site
     * 
     * @return mixed object with following properties: $title, $poster, $description.
     */
    public function parseContent(string $html)
    {
        $crawler = new Crawler($html);
        $movieData['title'] = $crawler->filter('h1')->text();
        $movieData['poster'] = $crawler->filter('.fposter a')->link()->getUri();
        $movieData['description'] = $crawler->filter('.fdesc')->text();
        
        return $movieData;
    }
}