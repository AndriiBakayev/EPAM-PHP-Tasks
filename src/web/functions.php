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

/**
 * SetURL Parses _GET array and sets new URL sretting setParam->setValue
 *
 * @param string setParam
 * @param string setValue
 * @param bool setToStart
 *
 * @return string
 */
function setURL(string $setParam, string $setValue, bool $setToStart): string
{
     $GET = $_GET; //Work with a local copy
     $GET[$setParam] = $setValue;
     if ($setToStart)
        $GET['page'] = 1;

    $newURL = './?' . http_build_query($GET, '&');
    //  $newURL = array_reduce(
    //     array_keys($GET),
    //     function ($carry, $key) use ($GET) {
    //         $carry .= $key.'=' . $GET[$key];
    //     },
    //     './?'
    // );

    return $newURL;
}

/**
 * getNavigationPages generates list of navigation pages with omissions
 * sorted array of Pages includes:
 *  - first and last page
 *  - active page and a $pageNavigatorWindow around it
 *  - every $pageNavigatorWindow's page for two-click navigaton
 *  - omissions (each omissions with '...' text) links to midlle page of ommitted block
 *
 * @param int listSize Total size of list
 * @param int $itemsPerPage How many items to place on a page
 * @param int activePage Active page by defailt
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
    for ($i = $pageNavigatorWindow; $i < $numberOfPages; $i += $pageNavigatorWindow)
        $navigationPages[$i] = $i;
    //Window nearby the activepage:
    $navigatorPagesBegin = max(1, min($activePage - $pageNavigatorWindow / 2, $numberOfPages - $pageNavigatorWindow));
    $navigatorPagesEnd = min($numberOfPages, max($activePage + $pageNavigatorWindow / 2, $pageNavigatorWindow));
    for ($i = $navigatorPagesBegin; $i <= $navigatorPagesEnd; $i++)
        $navigationPages[$i] = $i;
    //Omissions:
    for ($i = 2; $i < $numberOfPages; $i++) {
        if (isset($navigationPages[$i])) continue; //navigate to next ommited page
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
