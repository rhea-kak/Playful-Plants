<?php

$title = "Playful Plants";

//check if unique
$colloq_check = True;
$genus_check = True;
$id_check = True;
$hard_check = False;
$inserted = False;
$deleted_plant = False;

//file
define("MAX_FILE_SIZE", 1000000);


//feedback
$colloq_feedback_class = 'hidden';
$genus_feedback_class = 'hidden';
$id_feedback_class = 'hidden';
$hard_feedback_class = 'hidden';
$class_feedback_class = 'hidden';
$image_feedback_class = 'hidden';


//values to insert
$colloq = NULL;
$genus = NULL;
$plantid = NULL;
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




//form submit
if (isset($_POST['submit_plant'])) {
  $colloq = trim($_POST['cname']); // untrusted
  $genus = trim($_POST['gname']); // untrusted
  $plantid = trim($_POST['id']); // untrusted
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

  //check uploads
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
      "SELECT * FROM plants WHERE (plant_name = :plant_name);",
      array(
        ':plant_name' => $colloq
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
      "SELECT * FROM plants WHERE (genus = :genus);",
      array(
        ':genus' => $genus
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
      "SELECT * FROM plants WHERE (plantid = :plantid);",
      array(
        ':plantid' => $plantid
      )
    )->fetchAll();
    if (count($all_matching_records) > 0) {
      $form_valid = False;
      $id_check = False;
    }
  }


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

    $insert = exec_sql_query(
      $db,
      "INSERT INTO plants (plant_name, genus, plantid, file_ext) VALUES (:name, :genus, :id, :ext);",
      array(
        ':name' => $colloq, // tainted
        ':genus' => $genus, // tainted
        ':id' => $plantid, // tainted
        ':ext' => $upload_file_ext //tainted
      )
    );

    $last_inserted_plant =  $db->lastInsertId('id');

    if ($insert && $upload_file_ext) {
      $image_path = 'public/uploads/plants/' . $last_inserted_plant . '.' . $upload_file_ext;
      move_uploaded_file($upload["tmp_name"], $image_path);
    }


    $insert2 = exec_sql_query(
      $db,
      "INSERT INTO play_types (plant_id, supports_exploratory_constructive_play, supports_exploratory_sensory_play, supports_physical_play,supports_imaginative_play, supports_restorative_play, supports_expressive_play, supports_play_with_rules, supports_bio_play) VALUES (:id, :constructive, :sensory, :physical, :imaginative, :restorative, :expressive, :rules, :bio);",
      array(
        ':id' => $last_inserted_plant,
        ':constructive' => $constructive,
        ':sensory' => $sensory, // tainted
        ':physical' => $physical, // tainted
        ':imaginative' => $imaginative, // tainted
        ':restorative' => $restorative,
        ':expressive' => $expressive, // tainted
        ':rules' => $rules, // tainted
        ':bio' => $bio, // tainted
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

    if ($perennial) {
      $insert4 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 1);",
        array(
          ":id" => $last_inserted_plant
        )
      );
    }

    if ($annual) {
      $insert4 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 2);",
        array(
          ":id" => $last_inserted_plant
        )
      );
    }

    if ($full_sun) {
      $insert4 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 3);",
        array(
          ":id" => $last_inserted_plant
        )
      );
    }

    if ($partial_shade) {
      $insert4 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 4);",
        array(
          ":id" => $last_inserted_plant
        )
      );
    }

    if ($full_shade) {
      $insert4 = exec_sql_query(
        $db,
        "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, 5);",
        array(
          ":id" => $last_inserted_plant
        )
      );
    }



    $insert4 = exec_sql_query(
      $db,
      "INSERT INTO plant_cares(plant_id, care_id) VALUES (:id, (
          SELECT id FROM cares WHERE (care_name = :name)));",
      array(
        ':name' => $hard,
        ":id" => $last_inserted_plant

      )
    );

    $insert5 = exec_sql_query(
      $db,
      "INSERT INTO plant_tags(plant_id, tag_id) VALUES (:id, (
        SELECT id FROM tags WHERE (tag_name = :name)));",
      array(
        ':name' => $tag,
        ':id' => $last_inserted_plant
      )
    );




    if ($insert && $insert2) {
      $inserted = True;
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

$delete_id = $_POST['delete-plant'] ?? NULL; // untrusted
$delete_name = $_POST['plant-name'] ?? NULL; // untrusted
$delete_plant_id = $_POST['plant-id'] ?? NULL; // untrusted
$delete_plant_ext = $_POST['delete-ext'] ?? NULL; // untrusted
$src = "public/uploads/plants/" . $delete_id . '.' . $delete_plant_ext;
if (file_exists($src)) {
  unlink($src);
}

if ($delete_id) {
  $deleted = exec_sql_query(
    $db,
    "DELETE FROM plants WHERE (id = :id)",
    array(
      ':id' => $delete_id
    )
  );
  $deleted1 = exec_sql_query(
    $db,
    "DELETE FROM play_types WHERE (plant_id = :id)",
    array(
      ':id' => $delete_id
    )
  );
  $deleted2 = exec_sql_query(
    $db,
    "DELETE FROM plant_tags WHERE (plant_id = :id)",
    array(
      ':id' => $delete_id
    )
  );

  $deleted3 = exec_sql_query(
    $db,
    "DELETE FROM plant_cares WHERE (plant_id = :id)",
    array(
      ':id' => $delete_id
    )
  );


  if ($deleted && $deleted1 && $deleted2 && $deleted3) {
    $deleted_plant = True;
  }
}

//parts of filter
$select_part = "SELECT plants.id AS 'id', plants.plant_name AS 'name', plants.genus AS 'genus', plants.plantid AS 'plantid', play_types.supports_exploratory_constructive_play AS 'cons', play_types.supports_exploratory_sensory_play AS 'sens', play_types.supports_physical_play AS 'phys', play_types.supports_imaginative_play AS 'imag', play_types.supports_restorative_play AS 'rest', play_types.supports_expressive_play AS 'exp', play_types.supports_play_with_rules AS 'rules', play_types.supports_bio_play AS 'bio' FROM plants INNER JOIN play_types ON (plants.id = play_types.plant_id)";
$where_part = '';
$order_part = '';
$filter_expressions = array();

//get values
$filter_constructive = (bool)($_GET['constructive'] ?? NULL); // untrusted
$filter_sensory = (bool)($_GET['sensory'] ?? NULL); // untrusted
$filter_physical = (bool)($_GET['physical'] ?? NULL); // untrusted
$filter_imaginative = (bool)($_GET['imaginative'] ?? NULL); // untrusted
$filter_restorative = (bool)($_GET['restorative'] ?? NULL); // untrusted
$filter_expressive = (bool)($_GET['expressive'] ?? NULL); // untrusted
$filter_rules = (bool)($_GET['rules'] ?? NULL); // untrusted
$filter_bio = (bool)($_GET['bio'] ?? NULL); // untrusted

//sticky filter
$sticky_filter_constructive = ($filter_constructive ? 'checked' : '');
$sticky_filter_sensory = ($filter_sensory ? 'checked' : '');
$sticky_filter_physical = ($filter_physical ? 'checked' : '');
$sticky_filter_imaginative = ($filter_imaginative ? 'checked' : '');
$sticky_filter_restorative = ($filter_restorative ? 'checked' : '');
$sticky_filter_expressive = ($filter_expressive ? 'checked' : '');
$sticky_filter_rules = ($filter_rules ? 'checked' : '');
$sticky_filter_bio = ($filter_bio ? 'checked' : '');


//filtering

if ($filter_constructive) {
  array_push($filter_expressions, "(supports_exploratory_constructive_play = 1)");
}

if ($filter_sensory) {
  array_push($filter_expressions, "(supports_exploratory_sensory_play = 1)");
}

if ($filter_physical) {
  array_push($filter_expressions, "(supports_physical_play = 1)");
}

if ($filter_imaginative) {
  array_push($filter_expressions, "(supports_imaginative_play = 1)");
}

if ($filter_restorative) {
  array_push($filter_expressions, "(supports_restorative_play = 1)");
}

if ($filter_expressive) {
  array_push($filter_expressions, "(supports_expressive_play = 1)");
}

if ($filter_rules) {
  array_push($filter_expressions, "(supports_play_with_rules = 1)");
}

if ($filter_bio) {
  array_push($filter_expressions, "(supports_bio_play = 1)");
}

if (count($filter_expressions) > 0) {
  $where_part = ' WHERE ' . implode(' AND ', $filter_expressions);
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

  <main class="playful_plants">

    <div class="plantstitle">

      <h1><a href='/'> Playful Plants</a></h1>
    </div>
    <?php include('includes/nav.php'); ?>
    <?php
    if (is_user_logged_in()) { ?>


      <div class="success">

        <?php if ($inserted) { ?>
          <p>Plant with Colloquial Name: <?php echo htmlspecialchars($colloq); ?> and ID: <?php echo htmlspecialchars($plantid); ?>, has been successfully added to the table!</p>
        <?php } ?>
        <?php if ($deleted_plant) { ?>
          <p>Plant with Colloquial Name: <?php echo htmlspecialchars($delete_name); ?> and ID: <?php echo htmlspecialchars($delete_plant_id); ?>, has been successfully deleted from the table!</p>
        <?php } ?>

      </div>
      <?php
      if (count($all_matching_records) == 0) { ?>
        <p>No records found.</p>
      <?php } ?>

      <div class=filtertable>
        <div class=filterform>
          <section>
            <form class="filter" action="/admin" method="get" novalidate>
              <h2> Customize Your Search! </h2>
              <h3> Filter by: </h3>

              <label>
                <input type="checkbox" name="constructive" value="1" <?php echo $sticky_filter_constructive; ?> />
                Constructive Play
              </label>

              <label>
                <input type="checkbox" name="sensory" value="1" <?php echo $sticky_filter_sensory; ?> />
                Sensory Play
              </label>

              <label>
                <input type="checkbox" name="physical" value="1" <?php echo $sticky_filter_physical; ?> />
                Physical Play
              </label>

              <label>
                <input type="checkbox" name="imaginative" value="1" <?php echo $sticky_filter_imaginative; ?> />
                Imaginative Play
              </label>

              <label>
                <input type="checkbox" name="restorative" value="1" <?php echo $sticky_filter_restorative; ?> />
                Restorative Play
              </label>

              <label>
                <input type="checkbox" name="expressive" value="1" <?php echo $sticky_filter_expressive; ?> />
                Expressive Play
              </label>

              <label>
                <input type="checkbox" name="rules" value="1" <?php echo $sticky_filter_rules; ?> />
                Play With Rules
              </label>

              <label>
                <input type="checkbox" name="bio" value="1" <?php echo $sticky_filter_bio; ?> />
                Bio Play
              </label>



              <div class="filterbutton">
                <button type="submit">Apply</button>
              </div>
            </form>
          </section>
        </div>

        <div class="tableclass">
          <table>
            <tr>
              <th class="col_plant_name_colloq">ID</th>
              <th class="col_plant_name_colloq">Plant Name (Colloquial)</th>
              <th class="col_plant_name_genus">Plant Name (Genus, Species)</th>
              <th class="col_plant_id">Plant ID</th>
              <th class="col_supports_exploratory_constructive_play">Supports Exploratory Constructive Play</th>
              <th class="col_supports_exploratory_sensory_play">Supports Exploratory Sensory Play</th>
              <th class="col_supports_physical_play">Supports Physical Play</th>
              <th class="col_supports_imaginative_play">Supports Imaginative Play</th>
              <th class="col_supports_restorative_play">Supports Restorative Play</th>
              <th class="col_supports_expressive_play">Supports Expressive Play </th>
              <th class="col_supports_play_with_rules">Supports Play with Rules</th>
              <th class="col_supports_bio_play">Supports Bio Play</th>
              <th class="col_edit">Edit</th>
              <th class="col_delete">Delete</th>



            </tr>

            <?php
            foreach ($all_matching_records as $record) { ?>
              <tr>
                <td><?php echo htmlspecialchars($record["id"]); ?></td>
                <td><?php echo htmlspecialchars($record["name"]); ?></td>
                <td><?php echo htmlspecialchars($record["genus"]); ?></td>
                <td><?php echo htmlspecialchars($record["plantid"]); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["cons"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["sens"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["phys"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["imag"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["rest"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["exp"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["rules"]) ? 'Yes' : 'No'); ?></td>
                <td><?php echo htmlspecialchars((bool)($record["bio"]) ? 'Yes' : 'No'); ?></td>
                <td>
                  <form class="edit" method="get" action="/edit">

                    <input type="hidden" name="plant" value="<?php echo htmlspecialchars($record["id"]); ?>" />

                    <button type="submit" aria-label="Edit <?php echo htmlspecialchars($record["name"]); ?>&apos;s information" title="Edit <?php echo htmlspecialchars($record["name"]); ?>&apos;s information">
                      <div class="icons">
                        <img src="/public/images/pencil.svg" alt="edit" />
                        <!-- <Source: https://www.svgrepo.com/svg/146083/pencil-edit-button -->
                      </div>

                    </button>
                    <figcaption>
                      <div class="citeicon">
                        Source: <cite><a href="https://www.svgrepo.com/svg/146083/pencil-edit-button">SVGREPO</a></cite>
                      </div>
                    </figcaption>
                  </form>
                </td>
                <td>
                  <form class="delete" method="post" action="/admin">

                    <input type="hidden" name="delete-plant" value="<?php echo htmlspecialchars($record["id"]); ?>" />
                    <input type="hidden" name="plant-name" value="<?php echo htmlspecialchars($record["name"]); ?>" />
                    <input type="hidden" name="plant-id" value="<?php echo htmlspecialchars($record["plantid"]); ?>" />
                    <input type="hidden" name="delete-exst" value="<?php echo htmlspecialchars($record["file_ext"]); ?>" />


                    <button type="submit">
                      <div class="icons">
                        <img src="/public/images/delete.svg" alt="delete" />
                        <!-- <Source: https://www.svgrepo.com/svg/94821/delete -->
                      </div>
                    </button>
                    <figcaption>
                      <div class="citeicon">
                        Source: <cite><a href="https://www.svgrepo.com/svg/94821/delete">SVGREPO</a></cite>
                      </div>
                    </figcaption>

                  </form>
                </td>


              </tr>
            <?php } ?>
          </table>
        </div>
      </div>

      <div class="addform">

        <section>
          <h2>Add a new plant!</h2>

          <form action="/admin" method="post" enctype="multipart/form-data" novalidate>


            <p id="colloq_feedback" class="feedback <?php echo $colloq_feedback_class; ?>">Please provide the plant's colloquial name.</p>
            <?php if (!$colloq_check) { ?>
              <p class="feedback">The Plant Name (Colloquial) &quot;<?php echo htmlspecialchars($colloq); ?>&quot; already exists in the table. Please specify a different Plant Name (Colloquial).</p>
            <?php } ?>
            <div class="label-input-admin">
              <label for="colloq_field">Plant Name (Colloquial):</label>
              <input type="text" name="cname" id="colloq_field" value="<?php echo htmlspecialchars($sticky_colloq); ?>" />
            </div>

            <p id="genus_feedback" class="feedback <?php echo $genus_feedback_class; ?>">Please provide the plant's genus name.</p>
            <?php if (!$genus_check) { ?>
              <p class="feedback">The Plant Name (Genus, Species) &quot;<?php echo htmlspecialchars($genus); ?>&quot; already exists in the table. Please specify a different Plant Name (Genus, Species).</p>
            <?php } ?>
            <div class="label-input-admin">
              <label for="genus_field">Plant Name (Genus, Species):</label>
              <input type="text" name="gname" id="genus_field" value="<?php echo htmlspecialchars($sticky_genus); ?>" />
            </div>

            <p id="id_feedback" class="feedback <?php echo $id_feedback_class; ?>">Please provide the plant's ID.</p>
            <?php if (!$id_check) { ?>
              <p class="feedback">The Plant ID &quot;<?php echo htmlspecialchars($plantid); ?>&quot; already exists in the table. Please specify a different Plant ID.</p>
            <?php } ?>
            <div class="label-input-admin">
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
              <div class="label-input-admin">
                <label for="hard_field">Hardiness Zone Range (example format: 'Hardiness Zone: 4-9'):</label>
                <input type="text" name="hard" id="hard_field" value="<?php echo htmlspecialchars($sticky_hard); ?>" />
              </div>

              <h4> Classification </h4>

              <p id="class_feedback" class="feedback <?php echo $class_feedback_class; ?>">Please select a classification.</p>
              <div class="form-group label-input-admin" role="group">

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

              </div>

              <h4> Upload a Plant Image </h4>

              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

              <p class="image_feedback <?php echo $image_feedback_class; ?>">Please select a file with one of the following formats: .jpg/.png/.gif</p>
              <div class="label-input-admin">
                <label for="upload-image">Plant Image: (.jpg/.png/.gif)</label>
                <input id="upload-image" type="file" name="plantimage" accept=".jpg, .png, .gif" />
              </div>





              <div class="align-right">
                <button type="submit" name="submit_plant">Submit</button>
              </div>
          </form>
        </section>
      </div>

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
