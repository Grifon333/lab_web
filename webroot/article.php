<?php
$currentPage = "Article";
require_once("../inc/functions.php");
$articleId = $_GET['id'] ?? null;
if ($articleId === null) {
    http_response_code(404);
    exit();
}
$articleId = (int) $articleId;
$article = getArticle($articleId);
if ($articleId === null) {
    http_response_code(404);
    exit();
}
$pageTitle = $article["title"];
$response = $_POST;

$errors = [];
$action = $response['action'] ?? null;
if ($action === 'new-comment') {
    $author = trim((string) ($response['author'] ?? null));
    if ($author === '') {
        $errors['author'] = 'This field is can not be empty';
    } elseif (mb_strlen($author) > 50) {
        $errors['author'] = 'Length can not be more than 50 characters';
    }
    $rate = (int) ($response['rate'] ?? null);
    if ($rate < 1 || $rate > 5) {
        $errors['rate'] = 'Invalid rate';
    }
    $content = trim((string) ($response['content'] ?? null));
    if ($content === '') {
        $errors['content'] = 'This field is can not be empty';
    } elseif (mb_strlen($content) > 200) {
        $errors['content'] = 'Length can not be more than 200 characters';
    }

    if (count($errors) === 0) {
        $pdo = getConnection();
        $query =
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
        header("Location: article.php?id={$articleId}");
        exit();
    }
}
$comments = getComments($articleId);
?>

<!DOCTYPE html>
<html lang="en">

<?php require("../inc/head.php"); ?>

<body>
    <?php require("../inc/header.php"); ?>

    <main>
        <?php require '../inc/article.php'; ?>
        <?php require '../inc/comments.php'; ?>
    </main>

    <?php require("../inc/footer.php"); ?>
</body>

</html>