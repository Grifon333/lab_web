<?php
$pageTitle = "Home";
$currentPage = "Home";
require_once "../inc/functions.php";
$articles = getArticles();
?>

<!DOCTYPE html>
<html lang="en">

<?php require("../inc/head.php"); ?>

<body>
    <?php require("../inc/header.php") ?>
    <main>
        <?php foreach ($articles as $article) {
            require("../inc/article.php");
        } ?>
    </main>
    <?php require('../inc/footer.php'); ?>
</body>

</html>