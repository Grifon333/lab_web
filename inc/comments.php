<div class="comments-form">
  <form method="post">
    Comments<br>
    <input type="hidden" name="action" value="new-comment">
    <div class="input">
      <label for="author">Author</label><br>
      <input type="text" name="" id="author" placeholder="Name"
        value="<?= htmlspecialchars($_POST['author'] ?? ''); ?>">
    </div>
    <div class="input">
      <label for="rate">Rate</label><br>
      <select name="rate" id="article-rating">
        <option value="0">--no select--</option>
        <?php for($i = 1; $i <= 5; $i++) { ?>
          <option value="<?= $i ?>">Rate <?= $i ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="input">
      <label for="content">Comment</label><br>
      <textarea name="comment-body" id="content" cols="30" rows="10" placeholder="Body"
        value="<?= htmlspecialchars($_POST['content'] ?? ''); ?>"></textarea>
    </div>
    <input type="submit" value="Add comment">
  </form>
</div>