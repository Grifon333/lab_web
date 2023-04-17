<?php
function getArticles(): array
{
  return [
    [
      "id" => 1,
      "date" => "2023-04-05",
      "title" => "Learn Any Programming Language with This Learning Plan",
      "img" => "Work.png",
      "info" => "How to Create the Right Learning Plan",
      "description" => "My mini-guide on creating the perfect learning plan is divided into four simple steps. I have tried my best to create some wiggle room to make the plan as customizable as possible. This is not a cookie-cutter solution for those who do not wish to put in the hard work required to learn how to code. I have gleaned knowledge acquired over my years as both a programmer and a programming coach. I have handled different sorts of learners with varying learning aptitudes and concluded that having a good learning plan is important for any programming student.",
      "author" => "John",
    ],
    [
      "id" => 2,
      "date" => "2023-05-06",
      "title" => "5 Ways to Make Sure You Achieve Your Goals This Year",
      "img" => "House.webp",
      "info" => "What separates people who achieve their goals from those who don\'t?",
      "description" => "Connect every goal to a “why”.\nStart small and start now.\nBreak your goals down.\nRemove obstacles before you begin.\nCelebrate your wins.",
      "author" => "Allison",
    ],
  ];
}

function getArticle(int $articleId): ?array
{
  $articles = getArticles();
  foreach ($articles as $article) {
    if ($article["id"] === $articleId)
      return $article;
  }
  return null;
}
?>