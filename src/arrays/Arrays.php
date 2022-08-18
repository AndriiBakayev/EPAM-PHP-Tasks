<?php

/**
 * Arrays Class implements the ArraysInterface and following methods:
 * repeatArrayValues(), getUniqueValue(), groupByTag()
 * See details below.
 *
 * Php version 8.1.9
 * 
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */

namespace arrays;

/**
 * Arrays Class implements the ArraysInterface and following methods:
 * repeatArrayValues(), getUniqueValue(), groupByTag()
 *  
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class Arrays implements ArraysInterface
{
    /**
     * The $input variable contains an array of digits
     * Returns an array which will contain the same digits 
     * but repetitive by its value
     * without changing the order.
     * Example: [1,3,2] => [1,3,3,3,2,2]
     *
     * @param array $input array of ints
     * 
     * @return array $output array where each value repeated by value times
     */
    public function repeatArrayValues(array $input): array
    {
        $output=[];
        // Newer version - have no mension how to supply link to $output array 
        // via pointer into function:
        // array_walk($input,function(&$output,$value, $key, ){
        //      $output = array_merge($output, array_fill(0, $val, $val));
        // }, &$output);
        foreach ($input as $key => $val) {
            $output = array_merge($output, array_fill(0, $val, $val));
        }
        // Old  version:
        // foreach ($input as $key => $val) {
        // for ($i = 0; $i < $val; $i++) {
        //     $output[] = $val;
        // }
        return $output;
    }

    /**
     * The $input variable contains an array of digits
     * Return the lowest unique value or 0 if there is 
     * no unique values or array is empty.
     * Example: [1, 2, 3, 2, 1, 5, 6] => 3
     *
     * @param array $input - input array of ints
     * 
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
     * Each sub array has keys: name (contains strings),
     *  tags (contains array of strings)
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
     *
     * @param array $input is non-associative array like: 
     *                     ['name'=>'nameB', 'tags'=>['tagA,tagB']],
     *                     where 'tagA' and 'nameA' etc. are arbitrary strings
     * 
     * @return array outputs associative array 
     * of sorted array like: tagN => [nameA, nameB]
     */
    public function groupByTag(array $input): array
    {
        //array_walk_recursive? 
        $tagsNames = [];
        foreach ($input as $val) {
            foreach ($val['tags'] as $tag) {
                $tagsNames[$tag][] = $val['name']; 
                //Make Tag => Name(s) associative array
            }
        }
        foreach ($tagsNames as $key => $val) {
             sort($tagsNames[$key]);
        } //Internal sort of each element
        return $tagsNames;
    }
}
