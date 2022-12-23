<?php

namespace Library\FormBuilders;

use Library\Abstracts\FormBuilder;
use Library\Fields\StringField;
use Library\Fields\SubmitField;
use Library\Fields\TextField;
use Library\Validators\MaxLengthValidator;
use Library\Validators\NotNullValidator;

class CommentFormBuilder extends FormBuilder
{

    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Auteur',
            'name' => 'auteur',
            'maxLength' => 50,
            'validators' => [
                new MaxLengthValidator('L\'auteur spécifié est
trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier
l\'auteur du commentaire')
            ]
        ]))
            ->add(new TextField([
                'label' => 'Contenu',
                'name' => 'contenu',
                'rows' => 7,
                'cols' => 50,
                'validators' => [
                    new NotNullValidator('Merci de spécifier votre
commentaire'),
                ],
            ]));
    }
}