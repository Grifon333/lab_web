<?php
declare(strict_types=1);

function getConnection(): PDO{
  try {
      return new PDO('sqlite:../blog.sqlite');
  } catch (PDOException $e) {
      http_response_code(500);
      exit();
  }
}

function getArticles(): array
{
  $pdo = getConnection();
  $result = $pdo->query('SELECT * FROM articles')->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getArticle(int $articleId): ?array {
  $pdo = getConnection();
  $sql = 'SELECT * FROM articles WHERE id=:id';
  $statment = $pdo->prepare($sql);
  $statment->execute(['id' => $articleId]);
  $article = $statment->fetch(PDO::FETCH_ASSOC);
  return $article ? $article : null;
}
