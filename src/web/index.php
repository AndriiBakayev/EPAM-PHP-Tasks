<?php
require_once './functions.php';

$airports = require './airports.php';



//         if (is_array($_POST['filter']))
// {
// foreach ($_POST['filter'] as $key=>$val)
// {
// if ($val['field'] == 'error')
// {
// if ($val['data']['value'] == 4)
// $only_err = 1;
// /*elseif ($val['data']['value'] == 9)
// $only_err = 2;*/
// unset($_POST['filter'][$key]);
// }

// if ($val['field'] == 'fav')
// {
// $fav = 1;
// unset($_POST['filter'][$key]);
// }

// if ($val['field'] == 'pereprovodka')
// {
// $pereprovodka = $val['data']['value'];
// unset($_POST['filter'][$key]);
// }

// if ($val['field'] == 'p_amount')
// {
// $_POST['filter'][$key]['field'] = 'p_money';
// }


// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */
if (isset($_GET['Stfilter'])) {
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
if (isset($_GET['Sort'])) {
    $airportsFilteredSorted = array_sort(
        $airportsFiltered,
        function ($val) {
            return $val['state'] === $_GET['Stfilter'];
        }
    );
} else {
    $airportsFiltered = $airports;
}
$airportsFilteredSorted = $airportsFiltered;

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */
$activePage = 1;

$itemsPerPage = 10; //How many items to place on a page
$pageNavigatorWindow = 16; //How many pages availiable in navigator string
$listSize = count($airportsFilteredSorted);
$numberOfPages = ceil($listSize / $itemsPerPage);
if (isset($_GET['page']) /*&& is_int($_GET['page'])*/) $activePage = (int)$_GET['page'];
$navigatorPagesBegin = max(1, $activePage - $pageNavigatorWindow / 2);
$navigatorPagesEnd = min($numberOfPages, $activePage + $pageNavigatorWindow / 2);


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
    <!-- <?php var_dump('Hi') ?> -->
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
            <?php for ($pageNom = $navigatorPagesBegin; $pageNom <= $navigatorPagesEnd; $pageNom++) : ?> 
                <li class="page-item<?= $pageNom === $activePage ? ' active' : ''?>">
                    <?= $pageNom == $activePage ? '<p' : '<a'?> 
                    class="page-link" 
                    href="?page=<?=$pageNom;isset($_GET['Stfilter']) ? 'Stfilter=' . $_GET['Stfilter'] : ''?>">
                        <?= $pageNom?>
                    <?= $pageNom == $activePage ? '</p>' : '</a>'?>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</main>
</html>
