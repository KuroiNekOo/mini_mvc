<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;

class CommentController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'create':
                        $this->create();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                        break;
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function create() {

        try {
            $errors = [];
            $comment = new Comment();
            $commentRepository = new CommentRepository();

            if (isset($_POST['comment'])) {
                $comment->setComment($_POST['comment']);
            } else {
                $errors[] = "Le commentaire est obligatoire";
            }

            if (isset($_POST['article_id'])) {
                $comment->setArticleId($_POST['article_id']);
            } else {
                $errors[] = "L'article est obligatoire";
            }

            if (isset($_POST['user_id'])) {
                $comment->setUserId($_POST['user_id']);
            } else {
                $errors[] = "L'utilisateur est obligatoire";
            }

            if (empty($errors)) {
                $commentRepository->persist($comment);
                header('Location: articles?controller=articles&action=show&id=' . $_POST['article_id']);
            } else {
                $this->render('errors/default', [
                    'error' => $errors
                ]);
            }

        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }

    }


}
