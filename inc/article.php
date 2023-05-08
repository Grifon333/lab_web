<?php
$tag = 'Home' === $currentPage ? 'h2' : 'h1';
$url = 'article.php?id=' . $article['id'];
$rate = round(($article['avg_rate'] ?? 0) * 10) / 10;
$rate_by_star = str_repeat('&#9733', (int) ($rate)) . str_repeat('&#9734', 5 - (int) ($rate));
?>

<article class='blog-article'>
  <header>
    <a href=<?= $url ?>>
      <<?= $tag ?> class="title-article"><?= $article['title']; ?></<?= $tag ?>>
    </a>
  </header>
  <div class='posted'>
    Posted on <span class='posted__date'>
      <?= $date = DateTime::createFromFormat('Y-m-d', $article['date'])->format('F j, Y') ?>
    </span>
  </div>
  <div class='rate'>
    Rate
    <?= $rate ?>
    <?= $rate_by_star ?>
  </div>
  <img src='../assets/<?= $article['img'] ?>' alt=<?= $article['img'] ?>>
  <div class='info'>
    <?= $article['info']; ?>
  </div>
  <div class='description'>
    <?= $article['description']; ?>
  </div>
  <footer>
    Posted by <span class='author'>
      <?= $article['author'] ?>
    </span>
  </footer>
</article>

<?php if ($currentPage === 'Article') {
  require '../inc/comments.php';
} ?>