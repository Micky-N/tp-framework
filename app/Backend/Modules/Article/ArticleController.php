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
}