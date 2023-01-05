<?php
    declare(strict_types=1);
    
    namespace App\Form;
    
    use Laminas\Form\Element;
    use Laminas\Form\Form;

    class CommentForm extends Form
    {
        public function init(){
        
            parent::init();
            $this->setName('new_comment');
            $this->setAttributes([
                "method" => "post",
                "enctype" => "multipart/form-data"

            ]);
            
            #pseudo - username field
            $this->add([
               
                'type' => Element\Text::class,
                'name' => 'pseudo',
                'options' => [
                    
                    'label' => 'Pseudo'
                ],
                'attributes' => [
                    
                    'required' => true ,
                    'maxlength' => 25,
                    'pattern' => '^[a-zA-Z0-9]+$',
                    'placeholder' => 'Saisir votre Pseudo',
                    'title' => 'Le pseudo ne doit contenir que des caracteres alphanumériques.',
                    'class' => 'form-control'
                ]
                
            ]);
    
            #email - email field
            $this->add([
        
                'type' => Element\Email::class,
                'name' => 'email',
                'options' => [
            
                    'label' => 'adresse email'
                ],
                'attributes' => [
            
                    'required' => true ,
                    'maxlength' => 128,
                    'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                    'placeholder' => 'Saisir votre adresse email',
                    'title' => 'Saisir un email valide et fonctionnel.',
                    'class' => 'form-control'
                ]
    
            ]);
    
            $this->add([
        
                'type' => Element\Range::class,
                'name' => 'note',
                'options' => [
            
                    'label' => 'Note'
                ],
                'attributes' => [
            
                    'required' => true ,
                    'max' => 5,
                    'min' => 1,
                    'placeholder' => 'Saisir votre note',
                    'title' => 'Saisir une note entre 1 et 5.',
                    'class' => 'form-control'
                ]
    
            ]);
    
            $this->add([
        
                'type' => Element\Textarea::class,
                'name' => 'comment',
                'options' => [
            
                    'label' => 'Commentaire'
                ],
                'attributes' => [
    
                    'id'=>"x" ,
                    'value'=>"Saisir votre commentaire",
                    'required' => true ,
                    'placeholder' => 'Saisir votre commentaire',
                    'title' => 'Saisir votre commentaire.',
                    'class' => 'form-control'
                ]
    
            ]);

            $this->add([
        
                'type' => Element\File::class,
                'name' => 'photo',
                'options' => [
            
                    'label' => 'Photo'
                ],
                'attributes' => [
    
                    "id" => "photo",
                    'required' => false ,
                    'multiple' => false ,
                    'placeholder' => 'Selectionner une image',
                    'title' => 'Selectionner une image.',
                    'class' => 'form-control'
                ]
    
            ]);

            
            #csrf
            $this->add([
        
                'type' => Element\Hidden::class,
                'name' => 'comment_csrf',
                /*'options' => [
            
                    'csrf_optons' => [
                    
                        'timeout' => 1400
                    
                    ]
                ],*/
            ]);
            
            #submit
            $this->add([
        
                'type' => Element\Submit::class,
                'name' => 'comment_create',
                'attributes' => [
                    
                    'value' => 'Enregistrer',
                    'title' => 'Saisir un email valide et fonctionnel.',
                    'class' => 'btn btn-primary btn-lg btn-block'
                ]
            ]);
    
        }
    }