<?php require_once _TEMPLATEPATH_ . '/header.php';
/** @var \App\Entity\Article $article */

?>

<h1>Articles</h1>
<?php foreach ($articles as $article) : ?>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title
            ">
                <?= $article->getTitle() ?>
            </h3>
            <a href="articles?controller=page&action=articles&subaction=show&id=<?= $article->getId() ?>" class="btn btn-primary">Lire plus</a>
        </div>
    </div>
<?php endforeach; ?>

<?php require_once _TEMPLATEPATH_ . '/footer.php'; ?>