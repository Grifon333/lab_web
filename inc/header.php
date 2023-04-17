<?php
$tag = $currentPage === "Home" ? "h1" : "div";
?>

<header>
  <div class="title">
    <<?=$tag?> class="name">
      Blog
    </<?=$tag?>>
    <div class="subtitle">
      Previewing Another WordPress Blog
    </div>
  </div>
  <nav>
      <a href="index.php" <?php if ($currentPage === 'Home') echo 'class="current"' ?>>Home</a>
      <a href="about.php" <?php if ($currentPage === 'About') echo 'class="current"' ?>>About</a>
      <a href="contacts.php" <?php if ($currentPage === 'Contacts') echo 'class="current"' ?>>Contacts</a>
    </nav>
  </header>