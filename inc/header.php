<?php
$tag = $currentPage === "Home" ? "h1" : "div";
?>

<header class="blog-header">
  <div class="title">
    <<?=$tag?> class="name">
      Blog
    </<?=$tag?>>
    <div class="subtitle">
      Previewing Another WordPress Blog
    </div>
  </div>
  <nav>
      <ul>
        <li><a href="index.php" <?php if ($currentPage === 'Home') echo 'class="current"' ?>>Home</a></li>
        <li><a href="about.php" <?php if ($currentPage === 'About') echo 'class="current"' ?>>About</a></li>
        <li><a href="contacts.php" <?php if ($currentPage === 'Contacts') echo 'class="current"' ?>>Contacts</a></li>
      </ul>
    </nav>
  </header>