<?php require_once _TEMPLATEPATH_ . '/header.php';
/** @var \App\Entity\Article $article */

?>

<h1><?= $article->getTitle() ?></h1>
<div class="card">
    <div class="card-body">
        <p class="card-title
        ">
            <?= $article->getDescription() ?>
        </p>
        <a href="articles?controller=articles&action=list" class="btn btn-primary">Retour</a>
    </div>
</div>

<?php require_once _TEMPLATEPATH_ . '/footer.php'; ?>