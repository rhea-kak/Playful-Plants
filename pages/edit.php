<?php

$title = "Playful Plants";


//check if unique
$colloq_check = True;
$genus_check = True;
$id_check = True;
$hard_check = False;
$per_check = False;
$ann_check = False;
$sun_check = False;
$partial_check = False;
$shade_check = False;
$updated = False;


//feedback
$colloq_feedback_class = 'hidden';
$genus_feedback_class = 'hidden';
$id_feedback_class = 'hidden';
//$file_feedback_class = 'hidden';
$hard_feedback_class = 'hidden';
$class_feedback_class = 'hidden';
$image_feedback_class = 'hidden';

//values to insert
$colloq = NULL;
$genus = NULL;
$plantid = NULL;
//$file_ext = NULL;
$constructive = NULL;
$sensory = NULL;
$physical = NULL;
$imaginative = NULL;
$restorative = NULL;
$expressive = NULL;
$rules = NULL;
$bio = NULL;
$perennial = NULL;
$annual = NULL;
$full_sun = NULL;
$partial_shade = NULL;
$full_shade = NULL;
$hard = NULL;
$tag = NULL;
$upload_file_ext = NULL;
$upload_name = NULL;


//sticky form vals
$sticky_colloq = '';
$sticky_genus = '';
$sticky_plantid = '';
$sticky_fileext = '';
$sticky_constructive = '';
$sticky_sensory = '';
$sticky_physical = '';
$sticky_imaginative = '';
$sticky_restorative = '';
$sticky_expressive = '';
$sticky_rules = '';
$sticky_bio = '';
$sticky_perennial = '';
$sticky_annual = '';
$sticky_full_sun = '';
$sticky_partial_shade = '';
$sticky_full_shade = '';
$sticky_hard = '';
$sticky_shrub = '';
$sticky_grass = '';
$sticky_vine = '';
$sticky_tree = '';
$sticky_flower = '';
$sticky_groundcovers = '';

define("MAX_FILE_SIZE", 1000000);



$edit_id = $_POST['edit'] ?? NULL; // untrusted

$plant_id = $_GET['plant'] ?? NULL; // untrusted


if ($edit_id) { // POST request

  $records = exec_sql_query(
    $db,
    "SELECT plants.id AS 'id', plants.plant_name AS 'name', plants.genus AS 'genus', plants.plantid AS 'plantid', plants.file_ext AS 'fileext', play_types.supports_exploratory_constructive_play AS 'cons', play_types.supports_exploratory_sensory_play AS 'sens', play_types.supports_physical_play AS 'phys', play_types.supports_imaginative_play AS 'imag', play_types.supports_restorative_play AS 'rest', play_types.supports_expressive_play AS 'exp', play_types.supports_play_with_rules AS 'rules', play_types.supports_bio_play AS 'bio', plant_cares.care_id AS 'careid', plant_tags.tag_id AS 'tagid', tags.tag_name as 'tagname' FROM plants INNER JOIN play_types ON (plants.id = play_types.plant_id) INNER JOIN plant_cares ON (plants.id = plant_cares.plant_id) INNER JOIN plant_tags ON (plants.id = plant_tags.plant_id) INNER JOIN tags ON (tags.id = plant_tags.tag_id) WHERE (plants.id = :id);",
    array(
      ':id' => $edit_id
    )
  )->fetchAll();


  if (count($records) > 0) {
    $record = $records[0];
  }
} else if ($plant_id) { // GET request

  $plant_id = strtolower(trim($plant_id)); // tainted


  $records = exec_sql_query(
    $db,
    "SELECT plants.id AS 'id', plants.plant_name AS 'name', plants.genus AS 'genus', plants.plantid AS 'plantid', plants.file_ext AS 'fileext', play_types.supports_exploratory_constructive_play AS 'cons', play_types.supports_exploratory_sensory_play AS 'sens', play_types.supports_physical_play AS 'phys', play_types.supports_imaginative_play AS 'imag', play_types.supports_restorative_play AS 'rest', play_types.supports_expressive_play AS 'exp', play_types.supports_play_with_rules AS 'rules', play_types.supports_bio_play AS 'bio', plant_cares.care_id AS 'careid', plant_tags.tag_id AS 'tagid', tags.tag_name as 'tagname' FROM plants INNER JOIN play_types ON (plants.id = play_types.plant_id) INNER JOIN plant_cares ON (plants.id = plant_cares.plant_id) INNER JOIN plant_tags ON (plants.id = plant_tags.plant_id) INNER JOIN tags ON (tags.id = plant_tags.tag_id) WHERE (plants.id = :id);",
    array(
      ':id' => $plant_id
    )
  )->fetchAll();

  if (count($records) > 0) {

    $record = $records[0];
  }
}

if ($record) {
  $id = $record['id'];
  $colloq = $record['name'];
  $genus = $record['genus'];
  $plantid = $record['plantid'];
  //$file_ext = $record['fileext'];
  $constructive = $record['cons'];
  $sensory = $record['sens'];
  $physical = $record['phys'];
  $imaginative = $record['imag'];
  $restorative = $record['rest'];
  $expressive = $record['exp'];
  $rules = $record['rules'];
  $bio = $record['bio'];
  $perennial = ($record['careid'] == 1 ? 1 : 0);
  $annual = ($record['careid'] == 2 ? 1 : 0);
  $full_sun = ($record['careid'] == 3 ? 1 : 0);
  $partial_shade = ($record['careid'] == 4 ? 1 : 0);
  $full_shade = ($record['careid'] == 5 ? 1 : 0);
  $get_hard = exec_sql_query(
    $db,
    "SELECT care_name AS 'care_name' FROM cares INNER JOIN plant_cares ON (plant_cares.care_id = cares.id) INNER JOIN plants ON (plant_cares.plant_id = plants.id) WHERE (plants.id = :id) AND (plant_cares.care_id > 5);",
    array(
      ':id' => $record['id']
    )
  )->fetchAll();
  $hard_record = $get_hard[0];
  $hard = $hard_record['care_name'];
  $tag = $record['tagname'];

  $sticky_colloq = $colloq; // tainted
  $sticky_genus = $genus; // tainted
  $sticky_plantid = $plantid; // tainted
  //$sticky_fileext = $file_ext; //tainted
  $sticky_constructive = ($constructive ? 'checked' : ''); // tainted
  $sticky_sensory = ($sensory ? 'checked' : ''); // tainted
  $sticky_physical = ($physical ? 'checked' : ''); // tainted
  $sticky_imaginative = ($imaginative ? 'checked' : ''); // tainted
  $sticky_restorative = ($restorative ? 'checked' : ''); // tainted
  $sticky_expressive = ($expressive ? 'checked' : ''); // tainted
  $sticky_rules = ($rules ? 'checked' : ''); // tainted
  $sticky_bio = ($bio ? 'checked' : ''); // tainted
  $sticky_perennial = ($perennial ? 'checked' : ''); // tainted
  $sticky_annual = ($annual ? 'checked' : ''); // tainted
  $sticky_full_sun = ($full_sun ? 'checked' : ''); // tainted
  $sticky_partial_shade = ($partial_shade ? 'checked' : ''); // tainted
  $sticky_full_shade = ($full_shade ? 'checked' : ''); // tainted
  $sticky_hard = $hard; //tainted
  $sticky_shrub = ($tag == 'Shrub' ? 'checked' : '');
  $sticky_grass = ($tag == 'Grass' ? 'checked' : '');
  $sticky_vine = ($tag == 'Vine' ? 'checked' : '');
  $sticky_tree = ($tag == 'Tree' ? 'checked' : '');
  $sticky_flower = ($tag == 'Flower' ? 'checked' : '');
  $sticky_groundcovers = ($tag == 'Groundcovers' ? 'checked' : '');




  if ($edit_id) {
    $colloq = trim($_POST['cname']); // untrusted
    $genus = trim($_POST['gname']); // untrusted
    $plantid = trim($_POST['id']); // untrusted
    //$file_ext = trim($_POST['ext']); // untrusted
    $constructive = ((bool)($_POST['supports-exploratory-constructive-play']) ? 1 : 0); // untrusted
    $sensory = ((bool)($_POST['supports-exploratory-sensory-play']) ? 1 : 0); // untrusted
    $physical = ((bool)($_POST['supports-physical-play']) ? 1 : 0); // untrusted
    $imaginative = ((bool)($_POST['supports-imaginative-play']) ? 1 : 0); // untrusted
    $restorative = ((bool)($_POST['supports-restorative-play']) ? 1 : 0); // untrusted
    $expressive = ((bool)($_POST['supports-expressive-play']) ? 1 : 0); // untrusted
    $rules = ((bool)($_POST['supports-rules-play']) ? 1 : 0); // untrusted
    $bio = ((bool)($_POST['supports-bio-play']) ? 1 : 0); // untrusted
    $perennial = ((bool)($_POST['perennial']) ? 1 : 0); // untrusted
    $annual = ((bool)($_POST['annual']) ? 1 : 0); // untrusted
    $full_sun = ((bool)($_POST['full_sun']) ? 1 : 0); // untrusted
    $partial_shade = ((bool)($_POST['partial_shade']) ? 1 : 0); // untrusted
    $full_shade = ((bool)($_POST['full_shade']) ? 1 : 0); // untrusted
    $hard = trim($_POST['hard']); // untrusted
    $tag = $_POST['tag']; // untrusted

    $upload = $_FILES['plantimage'];


    $form_valid = True;
    //image feedback
    if ($upload['error'] == UPLOAD_ERR_OK) {
      $upload_name = basename($upload['name']);
      $upload_file_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION));

      if (!in_array($upload_file_ext, array('jpg', 'png', 'gif'))) {
        $form_valid = False;
      }
    }


    //colloq feedback
    if (empty($colloq)) {
      $form_valid = False;
      $colloq_feedback_class = '';
    } else {
      $colloq = ucwords($colloq); // tainted

      $all_matching_records = exec_sql_query(
        $db,
        "SELECT * FROM plants WHERE (plant_name = :plant_name) AND (id <> :id);",
        array(
          ':plant_name' => $colloq,
          ':id' => $id
        )
      )->fetchAll();
      if (count($all_matching_records) > 0) {
        $form_valid = False;
        $colloq_check = False;
      }
    }



    //genus feedback
    if (empty($genus)) {
      $form_valid = False;
      $genus_feedback_class = '';
    } else {
      $genus = ucfirst($genus); // tainted

      $all_matching_records = exec_sql_query(
        $db,
        "SELECT * FROM plants WHERE (genus = :genus) AND (id <> :id);",
        array(
          ':genus' => $genus,
          ':id' => $id
        )
      )->fetchAll();
      if (count($all_matching_records) > 0) {
        $form_valid = False;
        $genus_check = False;
      }
    }

    //id feedback
    if (empty($plantid)) {
      $form_valid = False;
      $id_feedback_class = '';
    } else {
      $plantid = strtoupper($plantid); // tainted

      $all_matching_records = exec_sql_query(
        $db,
        "SELECT * FROM plants WHERE (plantid = :plantid) AND (id <> :id);",
        array(
          ':plantid' => $plantid,
          ':id' => $id
        )
      )->fetchAll();
      if (count($all_matching_records) > 0) {
        $form_valid = False;
        $id_check = False;
      }
    }

    // //file feedback
    // if (empty($file_ext)) {
    //   $form_valid = False;
    //   $file_feedback_class = '';
    // } else {
    //   $file_ext = strtolower($file_ext); // tainted
    // }

    //hard feedback
    if (empty($hard)) {
      $form_valid = False;
      $hard_feedback_class = '';
    } else {
      $hard = ucwords($hard); // tainted
    }

    //tag
    if ($tag == NULL) {
      $form_valid = False;
      $class_feedback_class = '';
    }
    if ($form_valid) {
      $curr_image = exec_sql_query(
        $db,
        "SELECT file_ext from plants WHERE (id = :id);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      $current_image = $curr_image[0];

      // update new record into database
      $result = exec_sql_query(
        $db,
        "UPDATE plants SET
            plant_name = :name,
            genus = :genus,
            plantid = :plantid
          WHERE (id = :id);",
        array(
          ':name' => $colloq, // tainted
          ':genus' => $genus, // tainted
          ':plantid' => $plantid, // tainted
          ':id' => $id // tainted
        )
      );

      if ($upload_file_ext) {
        $result_image = exec_sql_query(
          $db,
          "UPDATE plants SET
       file_ext = :ext
      WHERE (id = :id);",
          array(
            ':ext' => $upload_file_ext, // tainted
            ':id' => $id // tainted
          )
        );
      }


      if ($result_image) {
        if ($current_image['file_ext']) {
          $src = "public/uploads/plants/" . $id . '.' . $current_image['file_ext'];
          if (file_exists($src)) {
            unlink($src);
          }
        }
        $image_path = 'public/uploads/plants/' . $id . '.' . $upload_file_ext;
        move_uploaded_file($upload["tmp_name"], $image_path);
      }

      $result1 = exec_sql_query(
        $db,
        "UPDATE play_types SET
            supports_exploratory_constructive_play = :constructive,
            supports_exploratory_sensory_play = :sensory,
            supports_physical_play = :physical,
            supports_imaginative_play = :imaginative,
            supports_restorative_play = :restorative,
            supports_expressive_play = :expressive,
            supports_play_with_rules = :rules,
            supports_bio_play = :bio
          WHERE (plant_id = :id);",
        array(
          ':constructive' => $constructive,
          ':sensory' => $sensory, // tainted
          ':physical' => $physical, // tainted
          ':imaginative' => $imaginative, // tainted
          ':restorative' => $restorative,
          ':expressive' => $expressive, // tainted
          ':rules' => $rules, // tainted
          ':bio' => $bio, // tainted
          ':id' => $id // tainted
        )
      );


      $curr_hard = exec_sql_query(
        $db,
        "SELECT * FROM cares WHERE (care_name =:name);",
        array(
          ':name' => $hard
        )
      )->fetchAll();
      if (count($curr_hard) > 0) {
        $hard_check = True;
      }

      if (!$hard_check) {

        $insert3 = exec_sql_query(
          $db,
          "INSERT INTO cares (care_name) VALUES (:name);",
          array(
            ':name' => $hard //tainted
          )
        );
      }

      $curr_per = exec_sql_query(
        $db,
        "SELECT * FROM plant_cares WHERE (plant_id = :id) AND (care_id = 1);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      if (count($curr_per) > 0) {
        $per_check = True;
      }

      if ($perennial && !$per_check) {
        $result4 = exec_sql_query(
          $db,
          "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 1);",
          array(
            ':id' => $id
          )
        );
      } else if (!$perennial && $per_check) {
        $result4 = exec_sql_query(
          $db,
          "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id = 1)",
          array(
            ':id' => $id //tainted
          )

        );
      }

      $curr_ann = exec_sql_query(
        $db,
        "SELECT * FROM plant_cares WHERE (plant_id = :id) AND (care_id = 2);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      if (count($curr_ann) > 0) {
        $ann_check = True;
      }

      if ($annual && !$ann_check) {
        $result4 = exec_sql_query(
          $db,
          "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 2);",
          array(
            ':id' => $id
          )
        );
      } else if (!$annual && $ann_check) {
        $result4 = exec_sql_query(
          $db,
          "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id = 2)",
          array(
            ':id' => $id //tainted
          )

        );
      }

      $sun_ann = exec_sql_query(
        $db,
        "SELECT * FROM plant_cares WHERE (plant_id = :id) AND (care_id = 3);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      if (count($sun_ann) > 0) {
        $sun_check = True;
      }

      if ($full_sun && !$sun_check) {
        $result4 = exec_sql_query(
          $db,
          "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 3);",
          array(
            ':id' => $id
          )
        );
      } else if (!$full_sun && $sun_check) {
        $result4 = exec_sql_query(
          $db,
          "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id = 3)",
          array(
            ':id' => $id //tainted
          )

        );
      }

      $partial_ann = exec_sql_query(
        $db,
        "SELECT * FROM plant_cares WHERE (plant_id = :id) AND (care_id = 4);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      if (count($partial_ann) > 0) {
        $partial_check = True;
      }

      if ($partial_shade && !$partial_check) {
        $result4 = exec_sql_query(
          $db,
          "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 4);",
          array(
            ':id' => $id
          )
        );
      } else if (!$partial_shade && $partial_check) {
        $result4 = exec_sql_query(
          $db,
          "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id = 4)",
          array(
            ':id' => $id //tainted
          )

        );
      }

      $shade_ann = exec_sql_query(
        $db,
        "SELECT * FROM plant_cares WHERE (plant_id = :id) AND (care_id = 5);",
        array(
          ':id' => $id
        )
      )->fetchAll();
      if (count($shade_ann) > 0) {
        $shade_check = True;
      }

      if ($full_shade && !$shade_check) {
        $result4 = exec_sql_query(
          $db,
          "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 5);",
          array(
            ':id' => $id
          )
        );
      } else if (!$full_shade && $shade_check) {
        $result4 = exec_sql_query(
          $db,
          "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id = 5)",
          array(
            ':id' => $id //tainted
          )

        );
      }

      $result5 = exec_sql_query(
        $db,
        "DELETE FROM plant_cares WHERE (plant_id = :id) AND (care_id > 5)",
        array(
          ':id' => $id //tainted
        )

      );

      $result6 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, (SELECT id FROM cares WHERE (care_name = :name)));",
        array(
          ':id' => $id,
          ':name' => $hard
        )
      );


      $result7 = exec_sql_query(
        $db,
        "UPDATE plant_tags SET
            tag_id = (SELECT id FROM tags WHERE (tag_name = :tag))
            WHERE (plant_id = :id);",
        array(
          ':tag' => $tag, //tainted
          ':id' => $id // tainted
        )
      );




      if ($result && $result1 && $result5 && $result6 && $result7) {
        $updated = True;
      }
    } else {
      $sticky_colloq = $colloq; // tainted
      $sticky_genus = $genus; // tainted
      $sticky_plantid = $plantid; // tainted
      $sticky_constructive = ($constructive ? 'checked' : ''); // tainted
      $sticky_sensory = ($sensory ? 'checked' : ''); // tainted
      $sticky_physical = ($physical ? 'checked' : ''); // tainted
      $sticky_imaginative = ($imaginative ? 'checked' : ''); // tainted
      $sticky_restorative = ($restorative ? 'checked' : ''); // tainted
      $sticky_expressive = ($expressive ? 'checked' : ''); // tainted
      $sticky_rules = ($rules ? 'checked' : ''); // tainted
      $sticky_bio = ($bio ? 'checked' : ''); // tainted
      $sticky_perennial = ($perennial ? 'checked' : ''); // tainted
      $sticky_annual = ($annual ? 'checked' : ''); // tainted
      $sticky_full_sun = ($full_sun ? 'checked' : ''); // tainted
      $sticky_partial_shade = ($partial_shade ? 'checked' : ''); // tainted
      $sticky_full_shade = ($full_shade ? 'checked' : ''); // tainted
      $sticky_hard = $hard; //tainted
      $sticky_shrub = ($tag == 'Shrub' ? 'checked' : '');
      $sticky_grass = ($tag == 'Grass' ? 'checked' : '');
      $sticky_vine = ($tag == 'Vine' ? 'checked' : '');
      $sticky_tree = ($tag == 'Tree' ? 'checked' : '');
      $sticky_flower = ($tag == 'Flower' ? 'checked' : '');
      $sticky_groundcovers = ($tag == 'Groundcovers' ? 'checked' : '');
      $image_feedback_class = '';
    }
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

  <main class="plants">
    <div class="plantstitle">

      <h1><a href='/'> Playful Plants</a></h1>
    </div>
    <?php include('includes/nav.php'); ?>


    <?php
    if (is_user_logged_in()) { ?>


      <?php if ($record == NULL) { ?>

        <p>Sorry, this plant does not exist, &quot;<?php echo htmlspecialchars($plant_id); ?>&quot;.</p>

        <p>Please contact the site adminstrator for assistance.</p>
        <p><a href="/admin">Return to catalog; view all entries.</a></p>

      <?php } else if ($updated) { ?>

        <p>Plant, <?php echo htmlspecialchars($colloq); ?>, was successfully updated in the catalog.</p>

        <p><a href="/admin">Return to catalog; view all entries.</a></p>

      <?php } else { ?>

        <form class="edit" action="/edit?<?php echo http_build_query(array('plant' => $id)); ?>" method="post" enctype="multipart/form-data" novalidate>

          <p id="colloq_feedback" class="feedback <?php echo $colloq_feedback_class; ?>">Please provide the plant's colloquial name.</p>
          <?php if (!$colloq_check) { ?>
            <p class="feedback">The Plant Name (Colloquial) &quot;<?php echo htmlspecialchars($colloq); ?>&quot; already exists in the table. Please specify a different Plant Name (Colloquial).</p>
          <?php } ?>
          <div class="label-input-edit">
            <label for="colloq_field">Plant Name (Colloquial):</label>
            <input type="text" name="cname" id="colloq_field" value="<?php echo htmlspecialchars($sticky_colloq); ?>" />
          </div>

          <p id="genus_feedback" class="feedback <?php echo $genus_feedback_class; ?>">Please provide the plant's genus name.</p>
          <?php if (!$genus_check) { ?>
            <p class="feedback">The Plant Name (Genus, Species) &quot;<?php echo htmlspecialchars($genus); ?>&quot; already exists in the table. Please specify a different Plant Name (Genus, Species).</p>
          <?php } ?>
          <div class="label-input-edit">
            <label for="genus_field">Plant Name (Genus, Species):</label>
            <input type="text" name="gname" id="genus_field" value="<?php echo htmlspecialchars($sticky_genus); ?>" />
          </div>

          <p id="id_feedback" class="feedback <?php echo $id_feedback_class; ?>">Please provide the plant's ID.</p>
          <?php if (!$id_check) { ?>
            <p class="feedback">The Plant ID &quot;<?php echo htmlspecialchars($plantid); ?>&quot; already exists in the table. Please specify a different Plant ID.</p>
          <?php } ?>
          <div class="label-input-edit">
            <label for="id_field">Plant ID:</label>
            <input type="text" name="id" id="id_field" value="<?php echo htmlspecialchars($sticky_plantid); ?>" />
          </div>


          <div class="select_choices">
            <p> Select all that apply:</p>

            <h4> Play Types </h4>

            <label>
              <input type="checkbox" name="supports-exploratory-constructive-play" value=1 <?php echo $sticky_constructive; ?> /> Supports Exploratory Constructive Play
            </label>

            <label>
              <input type="checkbox" name="supports-exploratory-sensory-play" value=1 <?php echo $sticky_sensory; ?> /> Supports Exploratory Sensory Play
            </label>

            <label>
              <input type="checkbox" name="supports-physical-play" value=1 <?php echo $sticky_physical; ?> /> Supports Physical Play
            </label>

            <label>
              <input type="checkbox" name="supports-imaginative-play" value=1 <?php echo $sticky_imaginative; ?> /> Supports Imaginative Play
            </label>

            <label>
              <input type="checkbox" name="supports-restorative-play" value=1 <?php echo $sticky_restorative; ?> /> Supports Restorative Play
            </label>

            <label>
              <input type="checkbox" name="supports-expressive-play" value=1 <?php echo $sticky_expressive; ?> /> Supports Expressive Play
            </label>

            <label>
              <input type="checkbox" name="supports-rules-play" value=1 <?php echo $sticky_rules; ?> /> Supports Play with Rules
            </label>

            <label>
              <input type="checkbox" name="supports-bio-play" value=1 <?php echo $sticky_bio; ?> /> Supports Bio Play
            </label>

            <h4> Care Information </h4>

            <label>
              <input type="checkbox" name="annual" value=1 <?php echo $sticky_annual; ?> /> Annual
            </label>

            <label>
              <input type="checkbox" name="perennial" value=1 <?php echo $sticky_perennial; ?> /> Perennial
            </label>

            <label>
              <input type="checkbox" name="full_sun" value=1 <?php echo $sticky_full_sun; ?> /> Full Sun
            </label>

            <label>
              <input type="checkbox" name="partial_shade" value=1 <?php echo $sticky_partial_shade; ?> /> Partial Shade
            </label>

            <label>
              <input type="checkbox" name="full_shade" value=1 <?php echo $sticky_full_shade; ?> /> Full Shade
            </label>

            <p id="hard_feedback" class="feedback <?php echo $hard_feedback_class; ?>">Please provide the plant's hardiness zone range.</p>
            <div class="label-input-edit">
              <label for="hard_field">Hardiness Zone Range (example format: 'Hardiness Zone: 4-9'):</label>
              <input type="text" name="hard" id="hard_field" value="<?php echo htmlspecialchars($sticky_hard); ?>" />
            </div>

            <h4> Classification </h4>

            <p id="class_feedback" class="feedback <?php echo $class_feedback_class; ?>">Please select a classification.</p>
            <div class="form-group label-input-edit" role="group" aria-labelledby="tag">

              <label>
                <input type="radio" id="shrub_input" name="tag" value="Shrub" <?php echo $sticky_shrub; ?> /> Shrub
              </label>

              <label>
                <input type="radio" id="grass_input" name="tag" value="Grass" <?php echo $sticky_grass; ?> /> Grass
              </label>

              <label>
                <input type="radio" id="vine_input" name="tag" value="Vine" <?php echo $sticky_vine; ?> /> Vine
              </label>

              <label>
                <input type="radio" id="tree_input" name="tag" value="Tree" <?php echo $sticky_tree; ?> /> Tree
              </label>

              <label>
                <input type="radio" id="flower_input" name="tag" value="Flower" <?php echo $sticky_flower; ?> /> Flower
              </label>

              <label>
                <input type="radio" id="groundcovers_input" name="tag" value="Groundcovers" <?php echo $sticky_groundcovers; ?> /> Groundcovers
              </label>

              <h4> Upload a Plant Image </h4>

              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

              <p class="image_feedback <?php echo $image_feedback_class; ?>">Please select a file with one of the following formats: .jpg/.png/.gif</p>
              <div class="label-input-edit">
                <label for="upload-image">Plant Image: (.jpg/.png/.gif)</label>
                <input id="upload-image" type="file" name="plantimage" accept=".jpg, .png, .gif" />
              </div>



            </div>

            <input type="hidden" name="edit" value="<?php echo htmlspecialchars($id); ?>" />

            <div class="align-right">
              <button type="submit" name="submit_plant">Submit</button>
            </div>
        </form>
      <?php } ?>

    <?php
    } else {
    ?>

      <p>Please login to access this page.</p>

      <?php
      echo_login_form('/admin', $session_messages);
      ?>

    <?php
    }
    ?>

  </main>

</body>

</html>
