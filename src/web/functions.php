<?php

/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    // put your logic here
    $uniqueFitsNameLetters = array_keys(
        array_filter(
            array_count_values(
                array_map(
                    function ($val) {
                            return isset($val['name'][0]) ? mb_strtoupper($val['name'][0]) : 'N/A';
                    },
                    $airports
                )
            ),
            function ($key) {
                return $key !== 'N/A';
            },
            ARRAY_FILTER_USE_KEY
        )
    );
    sort($uniqueFitsNameLetters);

    return $uniqueFitsNameLetters;
    //return ['A', 'B', 'C'];
}
