<?php
$title = "Not Found";
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



  <div class="not-found">
    <p>Sorry, the page you were looking for, <em>&quot;<?php echo htmlspecialchars($request_uri); ?>&quot;</em>, does not exist.</p>
  </div>

  <div class="return">
    <p> Return to the <a href="/">Playful Plants Catalog</a> </p>
  </div>



</body>

</html>
