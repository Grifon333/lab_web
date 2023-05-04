<?php
require_once('../inc/functions.php');
$pdo = getConnection();

$tableExists = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='articles'")->fetchColumn();

$query =
  'CREATE TABLE IF NOT EXISTS articles (
      id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
      date TEXT NOT NULL,
      title TEXT NOT NULL,
      img TEXT NOT NULL,
      info TEXT NOT NULL,
      description TEXT NOT NULL,
      author TEXT NOT NULL
    );
    CREATE TABLE IF NOT EXISTS comments (
      id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
      article_id INTEGER NOT NULL REFERENCES articles(id),
      author TEXT NOT NULL,
      rate TEXT NOT NULL,
      content TEXT NOT NULL,
      created TEXT NOT NULL
    )
    ';
$pdo->exec($query);

if (!$tableExists) {
  $articles = [
    [
      'date' => '2023-04-05',
      'title' => 'Learn Any Programming Language with This Learning Plan',
      'img' => 'Work.png',
      'info' => 'How to Create the Right Learning Plan',
      'description' => 'My mini-guide on creating the perfect learning plan is divided into four simple steps. I have tried my best to create some wiggle room to make the plan as customizable as possible. This is not a cookie-cutter solution for those who do not wish to put in the hard work required to learn how to code. I have gleaned knowledge acquired over my years as both a programmer and a programming coach. I have handled different sorts of learners with varying learning aptitudes and concluded that having a good learning plan is important for any programming student.',
      'author' => 'John',
    ],
    [
      'date' => '2023-05-06',
      'title' => '5 Ways to Make Sure You Achieve Your Goals This Year',
      'img' => 'House.webp',
      'info' => 'What separates people who achieve their goals from those who don\'t?',
      'description' => 'Connect every goal to a “why”. Start small and start now. Break your goals down. Remove obstacles before you begin.Celebrate your wins.',
      'author' => 'Allison',
    ],
  ];

  $statement = $pdo->prepare('INSERT INTO articles (date, title, img, info, description, author) 
  VALUES (:date, :title, :img, :info, :description, :author)');
  foreach ($articles as $article) {
    $statement->execute($article);
  }
}