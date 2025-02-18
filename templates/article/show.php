<?php require_once _TEMPLATEPATH_ . '/header.php';
/** @var \App\Entity\Article $article */
/** @var \App\Entity\Comment $comment */

use App\Entity\User;

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

<h2>Commentaires</h2>
<?php foreach ($comments as $comment) : ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title
            ">
                <?= $comment->getComment() ?>
            </h5>
        </div>
    </div>
<?php endforeach; ?>

<?php if (User::isLogged()) { ?>
  <form action="comments?controller=comments&action=create" method="post">
    <div class="form-group">
        <label for="comment">Commentaire</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
    </div>
    <input type="hidden" name="article_id" value="<?= $article->getId() ?>">
    <input type="hidden" name="user_id" value="<?= User::getCurrentUserId() ?>">
    <button type="submit" class="btn btn-primary">Envoyer</button>
  </form>
<?php } ?>

<?php require_once _TEMPLATEPATH_ . '/footer.php'; ?>