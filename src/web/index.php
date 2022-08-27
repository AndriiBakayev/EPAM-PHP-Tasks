<?php
require_once './functions.php';

$airports = require './airports.php';


// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */
if (isset($_GET['Stfilter']) && in_array($_GET['Stfilter'], $airports, true)) {
    $airportsFiltered = array_filter(
        $airports,
        function ($val) {
            return $val['state'] === $_GET['Stfilter'];
        }
    );
} else {
    $airportsFiltered = $airports;
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 */
if (isset($_GET['SortBy'])) {
    switch ($_GET['SortBy']) {
        case 'Name':
        case 'Code':            
        case 'State':
        case 'City':
        // case 'Address': //unallowed
        // case 'Timezone'://unallowed
            $airportsFilteredSorted = uasort(
                $airportsFiltered,
                function ($x, $y) {
                    return strcasecmp($x[$_GET['SortBy']], $y[$_GET['SortBy']]);
                }
            );
            break;
        default:
            unset($_GET['SortBy']);
    }
} else {
    $airportsFilteredSorted = $airportsFiltered;
}


// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */
$itemsPerPage = 5; //How many items to place on a page
$activePage = 1;
if (isset($_GET['page']) /*&& is_int($_GET['page'])*/) $activePage = (int)$_GET['page'];
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
    <!-- TODO REMIND ME TO COMENT MARGIN -->
<main role="main" class="container" style="margin:0"> 

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(require './airports.php') as $letter) : ?>
            <a href="#"><?= $letter ?></a>
        <?php endforeach; ?>
        
        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!-- <?php var_dump($navigationPages) ?> -->
    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="#">Name</a></th>
            <th scope="col"><a href="#">Code</a></th>
            <th scope="col"><a href="#">State</a></th>
            <th scope="col"><a href="#">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->



        <?php
        foreach ($airportsFilteredSortedPaged as $airport) : ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href=<?="?Stfilter=" . urlencode($airport['state'])?>><?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center ">
            <?php foreach ($navigationPages as $linkTo => $linkText) : ?> 
                <li class="page-item<?= $linkTo === $activePage ? ' active' : '' ?>">
                    <?= $linkTo == $activePage ? '<p' : '<a'?>
                    class="page-link" 
                    <?= $linkText === '...' ? ' style="padding:0.5rem 0.25rem"' : ''?>
                    href="<?=setURL('page', $linkTo, false);?>">
                        <?= $linkText?>
                    <?= $linkTo == $activePage ? '</p>' : '</a>'?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

</main>
</html>
