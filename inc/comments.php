<?php
/**
 * @var int $articleId
 */

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
    header("Location: ../webroot/article.php?id={$articleId}");
    exit();
  }
}
?>

<div class="comments-form">
  <form method="post">
    Comments<br>
    <input type="hidden" name="action" value="new-comment">
    <div class="input">
      <label for="author">Author</label><br>
      <input type="text" name="author" id="author" placeholder="Name"
        value="<?= htmlspecialchars($_POST['author'] ?? ''); ?>">
      <?php if (array_key_exists('author', $errors)) { ?>
        <div class='error'>
          <?= $errors['author']; ?>
        </div>
      <?php } ?>
    </div>
    <div class="input">
      <label for="rate">Rate</label><br>
      <select name="rate" id="rate">
        <option value="0">--no select--</option>
        <?php for ($i = 1; $i <= 5; $i++) { ?>
          <option value="<?= $i ?>">
            <?= str_repeat('&#9733', $i) . str_repeat('&#9734', 5 - $i); ?>
          </option>
        <?php } ?>
      </select>
      <?php if (array_key_exists('rate', $errors)) { ?>
        <div class='error'>
          <?= $errors['rate']; ?>
        </div>
      <?php } ?>
    </div>
    <div class="input">
      <label for="content">Comment</label><br>
      <textarea name="content" id="content" cols="30" rows="10" placeholder="Comment"
        value="<?= htmlspecialchars($_POST['content'] ?? ''); ?>"></textarea>
      <?php if (array_key_exists('content', $errors)) { ?>
        <div class='error'>
          <?= $errors['content']; ?>
        </div>
      <?php } ?>
    </div>
    <input type="submit" value="Add comment">
  </form>
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