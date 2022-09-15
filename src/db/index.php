<?php

require_once './../web/functions.php';
/**
 * Connect to DB
 */

//require_once './pdo_ini.php';
$config = require_once './config.php';
try {
    if (!in_array("mysql", PDO::getAvailableDrivers(), true)) {
        die("Cannot work without a proper database setting up");
    }
} catch (PDOException $e) {
    die("Database Error .. Details :<br /> {$e->getMessage()}");
}
try {
    $pdo = new \PDO(
        sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
        $config['user'],
        $config['pass'],
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
    );
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */

$stFilter = (isset($_GET['stFilter'])) ? " and states.name = " . $pdo->quote($_GET['stFilter']) : "";
$currentstFilter = isset($_GET['stFilter']) ? $_GET['stFilter'] : '' ;
$flFilter = (isset($_GET['flFilter'])) ? " where airports.name like " . $pdo->quote($_GET['flFilter'] . '%') : "";
$currentflFilter = isset($_GET['flFilter']) ? $_GET['flFilter'] : '' ;

/**
 * SELECT the list of unique first letters using
 * https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
$sth = $pdo->query("SELECT DISTINCT UPPER(LEFT(airports.name,1)) FROM airports 
    JOIN states on airports.state_Id=states.Id $stFilter ORDER BY 1");
$uniqueFirstLetters = $sth->fetchAll(PDO::FETCH_COLUMN, 0);

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */
if (isset($_GET['SortBy'])) {
    switch ($_GET['SortBy']) {
        case 'name':
        case 'code':
            $order = "ORDER BY " . ($_GET['SortBy']);
            break;
        case 'name_desc':
            $order = "ORDER BY name DESC";
            break;
        case 'code_desc':
            $order = "ORDER BY code DESC";
            break;
        case 'state':
        case 'city':
            $order = "ORDER BY " . ($_GET['SortBy'] . "_name");
            break;
        case 'state_desc':
            $order = "ORDER BY state_name  DESC";
            break;
        case 'city_desc':
            $order = "ORDER BY city_name  DESC";
            break;
        default:
            unset($_GET['SortBy']);
            $order = "";
    }
} else {
    $order = "";
}
$currentOrder = isset($_GET['SortBy']) ? $_GET['SortBy'] : '' ;

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */

$itemsPerPage = 5; //How many items to place on a page
$activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$countOverall = $pdo->query("SELECT count(*)
    FROM airports 
     JOIN states ON airports.state_id = states.id $stFilter
     JOIN cities ON airports.city_id = cities.id 
     $flFilter
 ")->fetch()[0];

$airportOverallCount = $sth->fetch(PDO::FETCH_NUM);
$navigationPages = getNavigationPages($countOverall, $itemsPerPage, $activePage);
$offset = ($activePage - 1) * $itemsPerPage;

/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$airports = [];
$sth = $pdo->query("SELECT 
        airports.name,
        code,
        cities.name as city_name,
        states.name as state_name,
        REGEXP_REPLACE(address, '([A-Z]{2})[ ]([0-9]{5})', '$1&nbsp$2') as address, /*Avoid line wraps in postcodes:*/
        timezone 
    FROM airports 
    JOIN states ON airports.state_id = states.id $stFilter
    JOIN cities ON airports.city_id = cities.id 
    $flFilter
    $order
    limit $itemsPerPage offset $offset");
$sth->execute();
$airports = $sth->fetchAll()
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
        Switches filtering by state to off by secondary click on state value
    -->
    <div class="alert alert-dark">
        Filter by first letter:
        <?php foreach ($uniqueFirstLetters as $letter) : ?>
            <a <?= $currentflFilter === $letter ? ' style="background-color: #fff"' : ''?> 
                href="<?= setURL('flFilter', $currentflFilter === $letter ? '' : $letter, true) ?>"
            ><?= $letter ?></a>
        <?php endforeach; ?>
        <a href="./" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
        switches sorting to "desc" then to "none" clicking on sorted column header
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= setURL(
                'SortBy',
                $currentOrder === 'name' ? 'name_desc' : ($currentOrder === 'name_desc' ? '' : 'name'),
                false
            ) ?>">Name</a></th>
            <th scope="col"><a href="<?= setURL(
                'SortBy',
                $currentOrder === 'code' ? 'code_desc' : ($currentOrder === 'code_desc' ? '' : 'code'),
                false
            ) ?>">Code</a></th>
            <th scope="col"><a href="<?= setURL(
                'SortBy',
                $currentOrder === 'state' ? 'state_desc' : ($currentOrder === 'state_desc' ? '' : 'state'),
                false
            ) ?>">State</a></th>
            <th scope="col"><a href="<?= setURL(
                'SortBy',
                $currentOrder === 'city' ? 'city_desc' : ($currentOrder === 'city_desc' ? '' : 'city'),
                false
            ) ?>">City</a></th>
            <th scope="col">Address</th >
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
            switches filterning by first letter off on secondary clicking on letter
        -->
        <?php foreach ($airports as $airport) : ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td <?= $currentstFilter === $airport['state_name'] ? ' style="background-color: #d6d8d9"' : ''?>>
            <a href="<?=
                setURL("stFilter", $currentstFilter === $airport['state_name'] ? '' : $airport['state_name'], true)
            ?>"><?= $airport['state_name'] ?></a></td>
            <td><?= $airport['city_name'] ?></td>
            <td><?= $airport['address'] /*Avoiding line wraps in postcodes moved to mysql query regex*/ ?></td>
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
