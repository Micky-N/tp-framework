<?php

namespace App\Frontend\Modules\Article;

use Library\Abstracts\Controller;
use Library\Application;
use Library\Entities\Comment;
use Library\FormBuilders\CommentFormBuilder;
use Library\FormHandler;
use Library\HTTPRequest;
use Library\Models\ArticleManagerPDO;

class ArticleController extends Controller
{
    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app, $module, $action);
        if($this->app->user()->isAuthenticated()){
            $auth = $this->app->user()->getAuthenticate();
            $this->page->addVar('auth', $this->managers->getManagerOf($auth['type'])->getUnique($auth['auth']));
        }
        $this->can([
            'show' => $this->app->user()->isAuthenticated()
        ]);
    }

    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Liste des articles');
        /** @var ArticleManagerPDO $manager */
        $manager = $this->managers->getManagerOf('Article');
        $listArticle = $manager->getList();
        $this->page->addVar('listArticle', $listArticle);
    }

    public function executeShow(HTTPRequest $request)
    {
        $news = $this->managers->getManagerOf('Article')->getUnique($request->getData('id'));
        if (empty($news)) {
            $this->app->httpResponse()->redirect404();
        }
        $this->page->addVar('title', $news->titre());
        $this->page->addVar('news', $news);
        $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
    }

    public function executeInsertComment(HTTPRequest $request)
    {
        // Si le formulaire a été envoyé.
        if ($request->method() == 'POST') {
            $comment = new Comment([
                'news_id' => $request->getData('news_id'),
                'author' => $request->postData('author'),
                'content' => $request->postData('content')
            ]);
        } else {
            $comment = new Comment;
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();
        $form = $formBuilder->form();
        // On récupère le gestionnaire de formulaire (le paramètre de getManagerOf() est bien entendu à remplacer).
        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
        if ($formHandler->process()) {
            $this->app->user()->setFlash('error', 'Le commentaire a bien été ajouté, merci !');
            $this->app->httpResponse()->redirect('news-' . $request->getData('news') . '.html');
        }
        $this->page->addVar('comment', $comment);
        $this->page->addVar('form', $form->createView());
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }
}