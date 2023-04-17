<?php
$tag = "Home" === $currentPage ? "h2" : "h1";
$url = "article.php?id=" . $article["id"];
?>

<section>
  <header>
    <a href=<?= $url ?>>
      <<?= $tag ?> class="title_article"><?= $article["title"]; ?></<?= $tag ?>>
    </a>
  </header>
  <div class="posted">
    Posted on <span class="posted__date">
      <?= $date = DateTime::createFromFormat("Y-m-d", $article["date"])->format("F j, Y") ?>
    </span>
  </div>
  <img src="assets/<?= $article["img"] ?>" alt="Boat">
  <div class="info">
    <?= $article["info"]; ?>
  </div>
  <div class="description">
    <?= $article["description"]; ?>
  </div>
  <footer>
    Posted by <span class="author">
      <?= $article["author"] ?>
    </span>
  </footer>
</section>
<hr>