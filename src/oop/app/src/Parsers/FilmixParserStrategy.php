<?php

/**
 * Php version 8.1.9
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 *
 * Implements the ParserInterface and  method:
 * parseContent() - should return Movie object with following properties:
 * $title, $poster, $description.
 *
 * For Class FilmixParserStrategy use simple PHP methods without any
 * library for parsing page content.
 * Note: Use next namespace for FilmixParserStrategy Class
 * "namespace src\oop\app\src\Parsers;" (Like in this Interface)
 * Note: For this Parser (for example) you can user regular expression.
 * Attention: Think about why this Parser might have a Strategy word in name!!!
 */

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;

/**
 * FilmixParserStrategy Class that parses site contents using regular
 * expressions
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class FilmixParserStrategy implements ParserInterface
{
    /**
     * Function parseContent Parse site contents using regular expressions
     * parseContent() - should return Movie object with following properties:
     * $title, $poster, $description only regexps using the predefined page class
     * detects needed content and sets StdObj bact to csrapper
     *
     * @param string $siteContent content of site
     *
     * @return mixed object with following properties: $title, $poster, $description.
     */

    private Movie $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function parseContent(string $siteContent): object
    {
        $titleRe = '/<h1([^>]*)>([^<]*)<\/h1>/m';
        preg_match_all($titleRe, $siteContent, $title, PREG_SET_ORDER, 0);
        $posterRe = '/<a class="fancybox"([^>]*)>\s*<img src="([^>]*)" class="poster/m';
        preg_match_all($posterRe, $siteContent, $poster, PREG_SET_ORDER, 0);
        $descriptionRe = '/<div[^<>]*class="full-story"[^<>]*>(?<content>.*?)<\/div>/m';
        preg_match_all($descriptionRe, $siteContent, $description, PREG_SET_ORDER, 0);
        if (isset($title[0][2]) && isset($poster[0][2]) && isset($description[0][1])) {
            $this->movie->setTitle($title[0][2]);
            $this->movie->setPoster($poster[0][2]);
            $this->movie->setDescription($description[0][1]);
        }

        return $this->movie;
    }
}
