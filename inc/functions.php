<?php
declare(strict_types=1);

function getConnection(): PDO
{
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
  $sql =
    'SELECT articles.*, AVG(comments.rate) avg_rate, COUNT(comments.id) comments_count 
    FROM articles LEFT JOIN comments ON articles.id = comments.article_id
    GROUP BY articles.id';
  $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getArticle(int $articleId): ?array
{
  $pdo = getConnection();
  $sql =
    'SELECT articles.*, AVG(comments.rate) avg_rate 
    FROM articles LEFT JOIN comments ON articles.id = comments.article_id
    WHERE articles.id=:id
    GROUP BY articles.id';
  $statment = $pdo->prepare($sql);
  $statment->execute(['id' => $articleId]);
  $article = $statment->fetch(PDO::FETCH_ASSOC);
  return $article ? $article : null;
}

function getComments(int $articleId): array
{
  $pdo = getConnection();
  $sql = 'SELECT * FROM comments WHERE article_id=:id';
  $statement = $pdo->prepare($sql);
  $statement->execute(['id' => $articleId]);
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}