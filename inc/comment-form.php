<form id="comment" action="article.php?id=<?= $articleId ?>" method="post">
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