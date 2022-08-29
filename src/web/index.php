<?php
require_once './functions.php';
$airports = require_once './airports.php';

// Filtering
/**
 * checks $_GET request if it has any filtering 'flFilter' and 'stFilter'
 * and applies filtering by First Airport Name Letter and/or Airport State
 */
if (isset($_GET['stFilter'])) {
    $airportsFilteredSt = array_filter(
        $airports,
        function ($val) {
            return $val['state'] === $_GET['stFilter'];
        }
    );
} else {
    $airportsFilteredSt = $airports;
}
//$airportsFilteredSt will be used below in getUniqueLetters before applied flFilter
if (isset($_GET['flFilter'])) {
    $airportsFiltered = array_filter(
        $airportsFilteredSt,
        function ($val) {
            return mb_strtoupper($val['name'][0]) === $_GET['flFilter'];
        }
    );
} else {
    $airportsFiltered = $airportsFilteredSt;
}

// Sorting
/**
 * checks $_GET request if it has sorting 'SortBy' key for particular values
 * and applies sorting
 */
$airportsFilteredSorted = $airportsFiltered;
if (isset($_GET['SortBy'])) {
    switch ($_GET['SortBy']) {
        case 'name':
        case 'code':
        case 'state':
        case 'city':
            uasort(
                $airportsFilteredSorted,
                function ($x, $y) {
                    return strcasecmp($x[$_GET['SortBy']], $y[$_GET['SortBy']]);
                }
            );
            break;
        default:
            unset($_GET['SortBy']);
    }
}

// Pagination
/**
 * checks $_GET request if it has pagination key
 * and applys pagination logic
 */
$itemsPerPage = 5; //How many items to place on a page
$activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$navigationPages = getNavigationPages(count($airportsFilteredSorted), $itemsPerPage, $activePage);
$airportsFilteredSortedPaged = array_slice($airportsFilteredSorted, ($activePage - 1) * $itemsPerPage, $itemsPerPage);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link 
        rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
        crossorigin="anonymous"
    >
</head>
<body>
<main role="main" class="container"> 
    <h1 class="mt-5">US Airports</h1>

    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters($airportsFilteredSt) as $letter) : ?>
            <a href="<?= setURL('flFilter', $letter, true)?>"><?= $letter ?></a>
        <?php endforeach; ?>
        
        <a href="./" class="float-right">Reset all filters</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= setURL('SortBy', 'name', false) ?>">Name</a></th>
            <th scope="col"><a href="<?= setURL('SortBy', 'code', false) ?>">Code</a></th>
            <th scope="col"><a href="<?= setURL('SortBy', 'state', false) ?>">State</a></th>
            <th scope="col"><a href="<?= setURL('SortBy', 'city', false) ?>">City</a></th>
            <th scope="col">Address</th >
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>

        <?php
        foreach ($airportsFilteredSortedPaged as $airport) : ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href=<?= setURL("stFilter", $airport['state'], true) ?>><?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?=/*Avoid line wraps in postcodes:*/
                    preg_replace('/([\s][A-Z]{2})[ ](\d{5})/ui', '${1}&nbsp${2}', $airport['address'])
            ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center ">
            <?php foreach ($navigationPages as $linkTo => $linkText) : ?> 
                <li class="page-item<?= $linkTo === $activePage ? ' active' : '' ?>">
                    <?= $linkTo === $activePage ? '<p' : '<a'?>
                        class="page-link" 
                        <?= $linkText === '...' ? ' style="padding:0.5rem 0.25rem"' : ''?>
                        href="<?=setURL('page', $linkTo, false);?>
                    ">
                        <?= $linkText?>
                    <?= $linkTo === $activePage ? '</p>' : '</a>'?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

</main>
</html>
