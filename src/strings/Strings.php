<?php

/**
 * Create the Strings Class and implement the StringsInterface and following methods:
 * snakeCaseToCamelCase(), mirrorMultibyteString(), getBrandName()
 * See details below.
 *
 * Note: Use next namespace for Strings Class - "namespace strings;" (Like in this Interface)
 * About composer autoloading and namespaces you can read here -
 * https://www.phptutorial.net/php-oop/php-composer-autoload/
 */

namespace strings;

class Strings implements StringsInterface
{
    /**
     * The $input variable contains text in snake case (i.e. hello_world or this_is_home_task)
     * Transform it into camel cased string and return (i.e. helloWorld or thisIsHomeTask)
     *
     * @see http://xahlee.info/comp/camelCase_vs_snake_case.html
     *
     * @param  string $input string in "snake-case"
     * @return string $output string in "camelCase"
     */
    public function snakeCaseToCamelCase(string $input): string
    {
        $str = str_replace('_', '', ucwords($input, '_'));
        $str = lcfirst($str);
        return $str;
    }

    /**
     * The $input variable contains multibyte text like 'ФЫВА олдж'
     * Mirror each word individually and return transformed text (i.e. 'АВЫФ ждло')
     * !!! do not change words order
     *
     * @param  string $input text of words with " " delimiter
     * @return string output string with mirrored words
     */
    public function mirrorMultibyteString(string $input): string
    {
        $output = '';
        foreach (explode(' ', $input) as $word) {
            $chars = mb_str_split($word, 1);
            $output = $output . ' ' . implode('', array_reverse($chars));
        }
        return(ltrim($output));
    }

    /**
     * My friend wants a new band name for her band.
     * She likes bands that use the formula: 'The' + a noun with first letter capitalized.
     * However, when a noun STARTS and ENDS with the same letter,
     * she likes to repeat the noun twice and connect them together with the first and last letter,
     * combined into one word like so (WITHOUT a 'The' in front):
     * dolphin -> The Dolphin
     * alaska -> Alaskalaska
     * europe -> Europeurope
     * Implement this logic.
     *
     * @param  string $noun of brand
     * @return string output string with repeated noun if anagrama and "The" prefix if it noncapitalized
     */
    public function getBrandName(string $noun): string
    {
        if (mb_substr(lcfirst($noun), 0, 1) == mb_substr($noun, -1, 1)) {
            return (ucfirst($noun) . mb_substr($noun, 1, null));
        } elseif (lcfirst($noun) == $noun) {
            return "The " . ucfirst($noun);
        } else {
            return ucfirst($noun);
        }
    }
}
