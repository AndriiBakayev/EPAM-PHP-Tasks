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
 * @link     https://learn.epam.com/myLearning/program
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
 * @link     https://learn.epam.com/myLearning/program
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

        array_walk(
            $input,
            function (&$val) {
                $val = array_fill(0, $val, $val);
            }
        );
        // Version via array_merge and array_fill:
        //     $output = [];     
        //     foreach ($input as $key => $val) {
        //         $output = array_merge($output, array_fill(0, $val, $val));
        //     }
        // Old  version:
        //     $output = [];
        //     foreach ($input as $key => $val) {
        //     for ($i = 0; $i < $val; $i++) {
        //         $output[] = $val;
        //     }

        return array_merge(...$input);
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
        // //old, more simple version:
        // $ret=0;
        // foreach (array_count_values($input) as $key => $val) {
        //     if ($val == 1 && ($key < $ret || $ret == 0)) {
        //         $ret = $key;
        //     }
        // }
        // return $ret;
        //Maximum usage of array functions without foreach:
        //First get the unique_values_array
        $unique_values_array = array_keys(
            array_filter(
                array_count_values($input), //Array of statistic 
                function ($val) {
                    //return of noname function, not a general function return:
                    return $val === 1;
                }
            )
        );

        return $unique_values_array === [] ? 0 : min($unique_values_array);
    }

    /**
     * The $input variable contains an array of arrays
     * Each sub array has keys: name (contains strings),
     * tags (contains array of strings)
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
     * It transformsng into:
     * [
     *  'fruit' => ['apple', 'orange'],
     *  'green' => ['apple'],
     *  'vegetable' => ['potato'],
     *  'yellow' => ['orange', 'potato'],
     * ]
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
        $tagsNames = [];
        foreach ($input as $nameTags) {
            foreach ($nameTags['tags'] as $tag) {
                //Make Tag => Name(s) associative array:
                $tagsNames[$tag][] = $nameTags['name'];
                array_multisort($tagsNames[$tag]);
            }
        }

        return $tagsNames;
    }
}
