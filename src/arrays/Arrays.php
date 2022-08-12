<?php

/**
 * Arrays Class and implement the ArraysInterface and following methods:
 * repeatArrayValues(), getUniqueValue(), groupByTag()
 * See details below.
 *
 * Note: Use next namespace for Arrays Class - "namespace arrays;" (Like in this Interface)
 * About composer autoloading and namespaces you can read here -
 * https://www.phptutorial.net/php-oop/php-composer-autoload/
 */

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * The $input variable contains an array of digits
     * Returns an array which will contain the same digits but repetitive by its value
     * without changing the order.
     * Example: [1,3,2] => [1,3,3,3,2,2]
     *
     *
     * @param array $input array of ints
     * @return array $output array where each value repeated by value times
     */
    public function repeatArrayValues(array $input): array
    {
        $output = [];
        foreach ($input as $key => $val) {
            for ($i = 0; $i < $val; $i++) {
                $output[] = $val;
            }
        }
        return $output;
    }

    /**
     * The $input variable contains an array of digits
     * Return the lowest unique value or 0 if there is no unique values or array is empty.
     * Example: [1, 2, 3, 2, 1, 5, 6] => 3
     *
     *
     * @param array $input - input array of ints
     * @return int output the least uniqie value or 0 if it not found
     */
    public function getUniqueValue(array $input): int
    {

        $ret = 0;
        foreach (array_count_values($input) as $key => $val) {
            if ($val == 1 && ($key < $ret || $ret == 0)) {
                $ret = $key;
            }
        }
        return $ret;
    }

    /**
     * The $input variable contains an array of arrays
     * Each sub array has keys: name (contains strings), tags (contains array of strings)
     * Return the list of names grouped by tags
     * !!! The 'names' in returned array must be sorted ascending.
     *
     * Example:
     * [
     *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
     *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
     *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
     * ]
     *
     * Should be transformed into:
     * [
     *  'fruit' => ['apple', 'orange'],
     *  'green' => ['apple'],
     *  'vegetable' => ['potato'],
     *  'yellow' => ['orange', 'potato'],
     * ]
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param array $input is non-associative array like: ['name'=>'nameB', 'tags'=>['tagA,tagB']],
     * where 'tagA' and 'nameA' etc. are arbitrary strings
     * @return array outputs associative array of sorted array like: tagN => [nameA, nameB]
     */
    public function groupByTag(array $input): array
    {

        $tagsNames = [];
        foreach ($input as $val) {
            foreach ($val['tags'] as $tag) {
                $tagsNames[$tag][] = $val['name']; //Making Tag => Name(s) associative array
            }
        }
        foreach ($tagsNames as $key => $val) {
             sort($tagsNames[$key]);
        } //Internal sort of each element
        return $tagsNames;
    }
}
