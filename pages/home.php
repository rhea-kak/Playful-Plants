<?php

$title = "Playful Plants";

//parts of filter
$select_part = "SELECT plants.plant_name AS 'plant_name', plant_tags.tag_id AS 'tag_id', plants.id AS 'id', plants.file_ext AS 'file_ext' FROM plants INNER JOIN plant_tags ON (plants.id = plant_tags.plant_id) ";
$where_part = '';
$order_part = '';
$filter_expressions = array();

//get values
$filter_shrub = (bool)($_GET['Shrub'] ?? NULL); // untrusted
$filter_grass = (bool)($_GET['Grass'] ?? NULL); // untrusted
$filter_vine = (bool)($_GET['Vine'] ?? NULL); // untrusted
$filter_tree = (bool)($_GET['Tree'] ?? NULL); // untrusted
$filter_flower = (bool)($_GET['Flower'] ?? NULL); // untrusted
$filter_groundcovers = (bool)($_GET['Groundcovers'] ?? NULL); // untrusted




//sticky filter
$sticky_filter_shrub = ($filter_shrub ? 'checked' : '');
$sticky_filter_grass = ($filter_grass ? 'checked' : '');
$sticky_filter_vine = ($filter_vine ? 'checked' : '');
$sticky_filter_tree = ($filter_tree ? 'checked' : '');
$sticky_filter_flower = ($filter_flower ? 'checked' : '');
$sticky_filter_groundcovers = ($filter_groundcovers ? 'checked' : '');


//filtering

if ($filter_shrub) {
  array_push($filter_expressions, "(tag_id = 1)");
}

if ($filter_grass) {
  array_push($filter_expressions, "(tag_id = 2)");
}

if ($filter_vine) {
  array_push($filter_expressions, "(tag_id = 3)");
}

if ($filter_tree) {
  array_push($filter_expressions, "(tag_id = 4)");
}

if ($filter_flower) {
  array_push($filter_expressions, "(tag_id = 5)");
}

if ($filter_groundcovers) {
  array_push($filter_expressions, "(tag_id = 6)");
}


if (count($filter_expressions) > 0) {
  $where_part = ' WHERE ' . implode(' OR ', $filter_expressions);
}

//get sort value
$sort = ($_GET['sort'] ?? NULL); // untrusted

//sticky sort
$sticky_sort_colloqasc = ($sort == 'colloqasc' ? 'checked' : '');
$sticky_sort_colloqdesc = ($sort == 'colloqdesc' ? 'checked' : '');


//sort

if ($sort == 'colloqasc') {
  $order_part = ' ORDER BY plant_name ASC;';
}
if ($sort == 'colloqdesc') {
  $order_part = ' ORDER BY plant_name DESC;';
}


//query parts
$query = $select_part . $where_part . $order_part;

// final query
$all_matching_records = exec_sql_query($db, $query)->fetchAll();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />
</head>

<body>


  <div class="plantstitle">

    <h1><a href='/'> Playful Plants</a></h1>
  </div>
  <?php include('includes/nav.php'); ?>

  <div class=filtertablehome>
    <div class=filterformhome>
      <section>
        <form class="filter" action="/" method="get" novalidate>
          <h2> Customize Your Search! </h2>
          <h3> Filter by: </h3>

          <h4> Classification </h4>

          <label>
            <input type="checkbox" name="Shrub" value="1" <?php echo $sticky_filter_shrub; ?> />
            Shrub
          </label>

          <label>
            <input type="checkbox" name="Grass" value="1" <?php echo $sticky_filter_grass; ?> />
            Grass
          </label>

          <label>
            <input type="checkbox" name="Vine" value="1" <?php echo $sticky_filter_vine; ?> />
            Vine
          </label>

          <label>
            <input type="checkbox" name="Tree" value="1" <?php echo $sticky_filter_tree; ?> />
            Tree
          </label>

          <label>
            <input type="checkbox" name="Flower" value="1" <?php echo $sticky_filter_flower; ?> />
            Flower
          </label>

          <label>
            <input type="checkbox" name="Groundcovers" value="1" <?php echo $sticky_filter_groundcovers; ?> />
            Groundcovers
          </label>


          <h3> Sort By: </h3>

          <input type="radio" id="colloqasc_input" name="sort" value="colloqasc" <?php echo $sticky_sort_colloqasc; ?> />
          <label for="colloqasc_input">Plant Name (Colloquial) A-Z</label>

          <input type="radio" id="colloqdesc_input" name="sort" value="colloqdesc" <?php echo $sticky_sort_colloqdesc; ?> />
          <label for="colloqdesc_input">Plant Name (Colloquial) Z-A</label>


          <div class="filterbutton">
            <button type="submit">Apply</button>
          </div>
        </form>
      </section>
    </div>

    <div class="tableclasshome">


      <table>
        <tr>
          <th class="col_plant_name_colloq">Plant Name (Colloquial)</th>
          <th class="col_img">Plant Image</th>
        </tr>

        <?php
        foreach ($all_matching_records as $record) { ?>
          <tr>

            <td>
              <div class="plant-title">
                <a href="/details?<?php echo http_build_query(array('plant' => $record['id'])); ?>"><?php echo htmlspecialchars($record["plant_name"]); ?></a>
              </div>
            </td>

            <td>

              <?php
              $src = "public/uploads/plants/" . htmlspecialchars($record['id']) . '.' . htmlspecialchars($record["file_ext"]);
              if (!file_exists($src)) { ?>
                <!-- Source: https://www.pikpng.com/pngvi/TbwwRo_png-file-svg-growing-plant-black-and-white-clipart/ -->
                <div class="consumerimg">
                  <a href="/details?<?php echo http_build_query(array('plant' => $record['id'])); ?>">
                    <img src="/public/uploads/plants/0.png" alt="plant image" />
                  </a>

                </div>
                <figcaption>
                  Source: <cite><a href="https://www.pikpng.com/pngvi/TbwwRo_png-file-svg-growing-plant-black-and-white-clipart/">PikPng</a></cite>
                </figcaption>

              <?php } else { ?>
                <div class="consumerimg one">
                  <a href="/details?<?php echo http_build_query(array('plant' => $record['id'])); ?>">
                    <img src=<?php echo "/public/uploads/plants/" . htmlspecialchars($record['id']) . '.' . htmlspecialchars($record["file_ext"]) ?> alt="plant image" />
                  </a>
                </div>
              <?php } ?>

            </td>


          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
