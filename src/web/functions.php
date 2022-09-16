<?php

/**getUniqueFirstLetters returns the unique first letter of each airport name
 * in alphabetical order. Function omits airports where tag 'name' not found or not set
 *
 * @param  array $airports - Associative array with values "'name' => 'Value'" to find
 *                unique uppercased first letters.
 *                Contains array of arrays of airports (see airports.php)
 * @return array Array of distinct uppercased name's first letters sorted alphabetically
 */
function getUniqueFirstLetters(array $airports): array
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
}

/**
 * SetURL Parses _GET array and sets new URL updating it's setParam->setValue
 * Returns new self URI
 *
 * @param string setParam New or updating Get Param
 * @param string setValue New value _GET param, null for unset
 * @param bool setToStart True if it needed to start from page 1
 *
 * @return string String of new self URI
 */
function setURL(string $setParam, string $setValue, bool $setToStart): string
{
    $GET = $_GET; //It is not a good prctice to modify _GET array, so let's work with a local copy
    $GET[$setParam] = $setValue; //Add the new value to array
    if ($setValue === '') {
        unset($GET[$setParam]);
    }
    $GET['page'] = isset($GET['page']) ? $GET['page'] : null;
    $GET['page'] = $setToStart ? null : $GET['page'] ;

    return './?' . http_build_query($GET, '&');
}

/**
 * getNavigationPages generates list of navigation pages with omissions
 * returns sorted array of Pages links ($key=page no, $val=text of link) which includes:
 *  - first and last page
 *  - active page and a $pageNavigatorWindow around it
 *  - every $pageNavigatorWindow's page for two-click far navigaton
 *  - omissions (each omissions with '...' text) links to midlle page of ommitted block
 *  Stricts $activePage to [1..$numberOfPages]
 *
 * @param int listSize Total size of list
 * @param int $itemsPerPage How many items to place on a page
 * @param int activePage Active page
 *
 * @return array keys are page numbers and values are texts
 */
function getNavigationPages(int $listSize = 1, int $itemsPerPage = 5, int &$activePage = 1): array
{
    $pageNavigatorWindow = 10; //How many pages to show around $activePage
    $listSize = max($listSize, 1);
    $activePage = max($activePage, 1);
    $numberOfPages = ceil($listSize / $itemsPerPage);
    $activePage = min($activePage, $numberOfPages);

    //First and last:
    $navigationPages = array(1 => 1 , $numberOfPages => $numberOfPages);
    //Every Window's step:
    for ($i = $pageNavigatorWindow; $i < $numberOfPages; $i += $pageNavigatorWindow) {
        $navigationPages[$i] = $i;
    }
    //Window nearby the activepage:
    $navigatorPagesBegin = max(1, min($activePage - $pageNavigatorWindow / 2, $numberOfPages - $pageNavigatorWindow));
    $navigatorPagesEnd = min($numberOfPages, max($activePage + $pageNavigatorWindow / 2, $pageNavigatorWindow));
    for ($i = $navigatorPagesBegin; $i <= $navigatorPagesEnd; $i++) {
        $navigationPages[$i] = $i;
    }
    //Omissions:
    for ($i = 2; $i < $numberOfPages; $i++) {
        if (isset($navigationPages[$i])) { //navigate to next ommited page
            continue;
        }
        $j = $i;
        do {
            $j++;
        } while (!isset($navigationPages[$j])); //navigate to next unommitted page
        $navigationPages[floor(($i - 1 + $j) / 2)] = '...'; //set the page in the middle of omission
        $i = $j;
    }
    ksort($navigationPages);

    return $navigationPages;
}
