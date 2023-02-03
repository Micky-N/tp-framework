<?php

namespace App\Backend\Modules\Article;

use Library\Abstracts\Controller;
use Library\Entities\Comment;
use Library\Entities\News;
use Library\FormBuilders\CommentFormBuilder;
use Library\FormBuilders\NewsFormBuilder;
use Library\FormHandler;
use Library\HTTPRequest;

class ArticleController extends Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des news');
        $manager = $this->managers->getManagerOf('Article');
        $this->page->addVar('listNews', $manager->getList());
        $this->page->addVar('numberNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        $this->processForm($request);
        $this->page->addVar('title', 'Ajout d\'une news');
    }

    public function executeUpdate(HTTPRequest $request)
    {
        $this->processForm($request);
        $this->page->addVar('title', 'Modifier la news '.$request->getData('id'));
    }

    public function processForm(HTTPRequest $request)
    {
        if ($request->method() == 'POST') {
            $news = new News([
                'author' => $request->postData('author'),
                'title' => $request->postData('title'),
                'content' => $request->postData('content')
            ]);
            if ($request->getExists('id')) {
                $news->setId($request->getData('id'));
            }
        } else {
            // L'identifiant de la news est transmis si on veut la modifier .
            if ($request->getExists('id')) {
                $news = $this->managers->getManagerOf('Article')->getUnique($request->getData('id'));
            } else {
                $news = new News;
            }
        }
        $formBuilder = new NewsFormBuilder($news);
        $formBuilder->build();
        $form = $formBuilder->form();
        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Article'), $request);
        if ($formHandler->process()) {
            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
            $this->app->httpResponse()->redirect('/admin');
        }
        $this->page->addVar('form', $form->createView());
    }

    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Modification d\'un commentaire');
        if ($request->method() == 'POST') {
            $comment = new Comment([
                'id' => $request->getData('id'),
                'author' => $request->postData('author'),
                'content' => $request->postData('content')
            ]);
        } else {
            $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
        }
        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();
        $form = $formBuilder->form();
        // On récupère le gestionnaire de formulaire (le paramètre de getManagerOf() est bien entendu à remplacer).
        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
        if ($formHandler->process()) {
            $this->app->user()->setFlash('Le commentaire a bien été modifié');
            $this->app->httpResponse()->redirect('/admin');
        }
        $this->page->addVar('form', $form->createView());
    }

    public function executeDelete(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Article')->delete($request->getData('id'));

        $this->app->user()->setFlash('La news a bien été supprimée');
        $this->app->httpResponse()->redirect('/admin');
    }

    public function executeDeleteComment(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Comments')->delete($request->getData('id'));

        $this->app->user()->setFlash('Le commentaire a bien été supprimé');
        $this->app->httpResponse()->redirect('/admin');
    }
}