<?php
/**
 * @var int $articleId
 */

$tag = 'Home' === $currentPage ? 'h2' : 'h1';
$url = 'article.php?id=' . $article['id'];
$avg_rate = round(($article['avg_rate'] ?? 0) * 10) / 10;
$rate_by_star = str_repeat('&#9733', (int) ($avg_rate)) . str_repeat('&#9734', 5 - (int) ($avg_rate));
$isAjax = 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');

if ($currentPage === 'Article') {
  $comments = getComments($articleId);
  $errors = [];
  $action = $_POST['action'] ?? null;
  if ($action === 'new-comment') {
    $author = trim((string) ($_POST['author'] ?? null));
    if ($author === '') {
      $errors['author'] = 'This field is can not be empty';
    } elseif (mb_strlen($author) > 50) {
      $errors['author'] = 'Length can not be more than 50 characters';
    }
    $rate = (int) ($_POST['rate'] ?? null);
    if ($rate < 1 || $rate > 5) {
      $errors['rate'] = 'Invalid rate';
    }
    $content = trim((string) ($_POST['content'] ?? null));
    if ($content === '') {
      $errors['content'] = 'This field is can not be empty';
    } elseif (mb_strlen($content) > 200) {
      $errors['content'] = 'Length can not be more than 200 characters';
    }

    if (count($errors) === 0) {
      $pdo = getConnection();
      $sql =
        'INSERT INTO comments (article_id, rate, content, author, created)
      VALUES (:articleId, :rate, :content, :author, :created)';
      $statement = $pdo->prepare($sql);
      $data = ['articleId' => $articleId, 'rate' => $rate, 'content' => $content, 'author' => $author];
      $data['created'] = date('Y-m-d H:i:s');
      $result = $statement->execute($data);
      if (false === $result) {
        http_response_code(500);
        exit();
      }

      $redirect_url = "article.php?id={$articleId}";
      if(!$isAjax) {
        header("Location: {$redirect_url}");
      } else {
        echo $redirect_url;
      }
      
      exit();
    }
    if($isAjax) {
      require '../inc/coment-form.php';
      exit();
    }
  }
}
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
    <?= $avg_rate ?>
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

<?php if ($currentPage === 'Article') { ?>
  <div class="comments-form">
    <?php require '../inc/comment-form.php' ?>
  </div>

  <?php if (count($comments) != 0) { ?>
    <div class='count-comments'>This article have
      <?= count($comments) ?> comments
    </div>
    <div class="comments-list">Comments</div>
    <?php foreach ($comments as $comment) { ?>
      <div class="comment">
        <div class='author'>
          <?= htmlspecialchars($comment['author']) ?>
        </div>
        <div class='rate'>
          <?= str_repeat('&#9733', htmlspecialchars($comment['rate']))
            . str_repeat('&#9734', 5 - htmlspecialchars($comment['rate'])) ?>
        </div>
        <div class='content'>
          <?= nl2br(htmlspecialchars($comment['content'])) ?>
        </div>
        <div class='created'>
          <?= htmlspecialchars($comment['created']) ?>
        </div>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="empty-comments-list">
      No comments
    </div>
  <?php } ?>
<?php } ?>

<script>
  var $form = jQuery('#comment-form');
  $form.on('submit', function (event) {
    event.preventDefault();
    jQuery.post($form.attr('action'), $form.serialize(), function (response) {
      if (response.startsWith('<form')) {
        $form.empty().append(jQuery(response).children());
      } else {
        window.location = response;
      }
    });
  });
</script>