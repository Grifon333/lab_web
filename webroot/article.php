<?php
$currentPage = "Article";
require_once("../inc/functions.php");
$articleId = $_GET["id"] ?? null;
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
?>

<!DOCTYPE html>
<html lang="en">

<?php require("../inc/head.php"); ?>

<body>
    <?php require("../inc/header.php"); ?>

    <main>
        <?php require("../inc/article.php"); ?>
    </main>

    <?php require("../inc/footer.php"); ?>
</body>

</html>