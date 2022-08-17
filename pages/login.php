<?php

$title = "Playful Plants";
?>

<!DOCTYPE html>
<html lang="en">
<title><?php echo $title; ?></title>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <div class="plantstitle">

    <h1><a href='/'> Playful Plants</a></h1>
  </div>
  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all" />

  <header>

  </header>

  <div class="login">


    <?php if (!is_user_logged_in()) { ?>
      <h2>Sign In</h2>

      <?php
      echo_login_form('/admin', $session_messages);
      ?>
  </div>

<?php } ?>
</head>

</html>
