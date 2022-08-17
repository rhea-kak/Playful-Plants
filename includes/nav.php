<header>


  <nav>
    <div class="signout">
      <?php if (is_user_logged_in()) { ?>
        <li id="consumer"><a href="/">Consumer</a></li>
        <li id="admin"><a href="/admin">Admin</a></li>
        <li id="logout"><a href="<?php echo logout_url(); ?>">Sign Out</a></li>
    </div>
  <?php } else { ?>
    <div class="signin">
      <li id="login"><a href='/login'>Sign In</a></li>
    </div>
  <?php } ?>
  </nav>
</header>
