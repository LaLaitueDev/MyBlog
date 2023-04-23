<?php
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$currentUser = $authDB->isLoggedin();

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if (!$id) {
    header('location: /');
} else {

    $article = $articleDB->fetchOne($id);
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes\head.php'; ?>
    <link rel="stylesheet" href="/public/css/show-article.css">

    <title>Article</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes\header.php'; ?>
        <div class="content">
            <div class="article-container">
                <a href="/" class="article-back">Retour</a>
                <div class="article-cover-img" style="background-image: url(<?= $article['image'] ?>);"></div>
                <h1 class="article-title"><?= $article['title'] ?></h1>
                <div class="separator"></div>
                <p class="article-content"><?= $article['content'] ?></p>
                <p class="article-author"><?= $article['firstname'] . ' ' . $article['lastname'] ?></p>
                <?php if ($currentUser && $currentUser['id'] === $article['author']) : ?>
                    <div class="action">
                        <a href="/remove-article.php?id=<?= $article['id'] ?>" class="btn btn-danger " type="button">Supprimer</a>
                        <a class="btn btn-primary" href="/form-article.php?id=<?= $article['id'] ?>" type="button">Modifier</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php require_once 'includes\footer.php'; ?>
    </div>
</body>

</html>