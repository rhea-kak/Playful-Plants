<?php



$title = "Playful Plants";

$plant = $_GET['plant'] ?? NULL; // untrusted

if ($plant) { // GET request

  $records = exec_sql_query(
    $db,
    "SELECT plants.id AS 'id', plants.plant_name AS 'plant_name' , plants.genus AS 'genus' , plants.file_ext AS 'file_ext', tags.tag_name AS 'tag_name' , cares.care_name AS 'care_name' FROM plants INNER JOIN plant_tags ON (plants.id = plant_tags.plant_id) INNER JOIN tags ON (tags.id = plant_tags.tag_id)
  INNER JOIN plant_cares ON (plants.id = plant_cares.plant_id) INNER JOIN cares ON (plant_cares.care_id = cares.id)
  WHERE (plants.id = :plantid);",
    array(
      ':plantid' => $plant,
    )
  )->fetchAll();


  if (count($records) > 0) {

    $record = $records[0];
  }
}



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

  <?php if ($record == NULL) { ?>

    <p>Sorry, this plant does not exist, &quot;<?php echo htmlspecialchars($plant); ?>&quot;.</p>

    <p>Please contact the site adminstrator for assistance.</p>
    <p><a href="/">Return to catalog; view all entries.</a></p>

  <?php } else { ?>

    <div class="details">
      <div class="infodetails">
        <h2> Details </h2>



        <h3><strong>Name: </strong><?php echo htmlspecialchars($record["plant_name"]); ?></h3>
        <h3> <strong>Genus/Species: </strong><?php echo htmlspecialchars($record["genus"]); ?></h3>
        <h3> <strong>Classification: </strong><?php echo htmlspecialchars($record["tag_name"]); ?></h3>
        <h3> <strong>Growing Needs and Characteristics: </strong></h3>
        <?php
        foreach ($records as $record) { ?>
          <p><?php echo htmlspecialchars($record["care_name"]); ?>
          <p>
          <?php echo "\n";
        }
          ?>
      </div>

      <?php
      $src = "public/uploads/plants/" . htmlspecialchars($record['id']) . '.' . htmlspecialchars($record["file_ext"]);
      if (!file_exists($src)) { ?>
        <!-- Source: https://www.pikpng.com/pngvi/TbwwRo_png-file-svg-growing-plant-black-and-white-clipart/ -->
        <div class="detailsimgone">
          <img src="/public/uploads/plants/0.png" alt="plant image" />
          <figcaption>
            Source: <cite><a href="https://www.pikpng.com/pngvi/TbwwRo_png-file-svg-growing-plant-black-and-white-clipart/">PikPng</a></cite>
        </div>
        </figcaption>

      <?php } else { ?>
        <div class="detailsimg">
          <img src=<?php echo "/public/uploads/plants/" . htmlspecialchars($record['id']) . '.' . htmlspecialchars($record["file_ext"]) ?> alt="plant image" />
        </div>
      <?php } ?>


    <?php } ?>

    </div>

</body>

</html>
