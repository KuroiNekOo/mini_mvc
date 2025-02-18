<?php

namespace App\Controller;

use App\Repository\ArticleRepositorye;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticleController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'list':
                        $this->list();
                        break;
                    case 'show':
                        $this->show();
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
  
    protected function list()
    {
        try {
            $errors = [];
            $articleRepository = new ArticleRepository();

            $this->render('article/list', [
                'articles' => $articleRepository->findAll(),
                'pageTitle' => 'Articles',
                'errors' => ''
            ]);

        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        } 

    }

    protected function show()
    {
        try {
            $errors = [];
            $articleRepository = new ArticleRepository();
            $article = $articleRepository->findOneById($_GET['id']);

            $this->render('article/show', [
                'article' => $article,
                'pageTitle' => 'Article',
                'errors' => ''
            ]);

        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        } 

    }

}
