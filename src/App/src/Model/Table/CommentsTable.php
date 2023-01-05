<?php
    declare(strict_types=1);

    namespace App\Model\Table;
    
    use App\Model\Entity\CommentEntity;
    use Laminas\Db\Adapter\Adapter;
    use Laminas\Db\ResultSet\HydratingResultSet;
    use Laminas\Db\TableGateway\AbstractTableGateway;
    use Laminas\Filter\StringTrim;
    use Laminas\Filter\StripTags;
    use Laminas\Hydrator\ClassMethodsHydrator;
    use Laminas\I18n\Filter\Alnum as F_Alnum;
    use Laminas\InputFilter\Factory;
    use Laminas\InputFilter\InputFilter;
    use Laminas\Validator\EmailAddress;
    use Laminas\Validator\File\IsImage;
    use Laminas\Validator\File\MimeType;
    use Laminas\Validator\File\Size;
    use Laminas\Validator\NotEmpty;
    use Laminas\Validator\StringLength;
    use Laminas\I18n\Validator\Alnum as V_Alnum;
    use Laminas\Filter\File\RenameUpload;

    class CommentsTable extends AbstractTableGateway
    {
        protected $table = "avis";
    
        public function __construct(Adapter $adapter)
        {
            $this->adapter = $adapter;
            $this->initialize();
        }
    
        /**
         * check, filter and validate the CommentForm data
         * @return \Laminas\InputFilter\InputFilter
         */
        public function getComentFormFilter()
        {
            $inputFilter = new InputFilter();
            $factory = new Factory();
    
            # pseudo
            $inputFilter->add($factory->createInput([
                
                'name' => 'pseudo',
                'required' => true,
                'filters' => [
    
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => F_Alnum::class],
                ],
                'validators' => [
        
                    ['name' => NotEmpty::class],
                    [
                        'name' => V_Alnum::class,
                        'options' => [
                            V_Alnum::NOT_ALNUM => 'le pseudo ne doit contenir que des caracteres alphanumérique'
                        ]
                    ],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 25,
                            'messages' => [
                                StringLength::TOO_SHORT => 'le pseudo doit contenir au moins 3 caracteres.',
                                StringLength::TOO_LONG => 'le pseudo doit contenir moins de 25 caracteres.'
                            ]
                        ]
                    ],
                ],
            ]));
    
            # email
            $inputFilter->add($factory->createInput([
        
                'name' => 'email',
                'required' => true,
                'filters' => [
            
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
            
                    ['name' => NotEmpty::class],
                    ['name' => EmailAddress::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => "l'email doit contenir au moins 6 caracteres.",
                                StringLength::TOO_LONG => "l'email doit contenir moins de 128 caracteres."
                            ]
                        ]
                    ],
                ],
            ]));
    
            # filter and validate photo input field
            $inputFilter->add($factory->createInput([
            
                    "name" => "photo",
                    "required" => false,
                    "validator" => [
                        ["name" => NotEmpty::class ],
                        ["name" => IsImage::class ],
                        [
                            "name" => MimeType::class,
                            "options" => [
                                "mimeType" => "image/png, image/jpeg, image/jpg, image/gif"
                            ]
                        ],
                        [
                            "name" => Size::class,
                            "options" => [
                                "min" => "3kB",
                                "max" => "15MB"
                            ]
                        ],
                    ],
                    "filters" => [
                        ["name" => StripTags::class ],
                        ["name" => StringTrim::class ],
                        [
                            "name" => RenameUpload::class,
                            "options" => [
                                "target" => 'public/images/temporary',
                                "use_upload_name" => false,
                                "use_upload_extension" => true,
                                "overwrite" => false,
                                "randomize" => true,
                            ],
                        ],
                    ],
                ]));
            
            return $inputFilter ;
        }
    
        public function insertAvis(array $data)
        {
            $values = [
                
                'email'=> strtolower($data['email']),
                'pseudo' => ucfirst(strtolower($data['pseudo'])),
                'note' => intval($data['note']),
                'comment' => $data['comment'],
                'photo'=> stripslashes($data['photo']),
                'date_create' => date("Y-m-d H:i:s")
            ];
            
            $sqlQuery = $this->sql->insert()->values($values);
            $sqlStat = $this->sql->prepareStatementForSqlObject($sqlQuery);
            
            return $sqlStat->execute();
        }
    
        public function fetchAll()
        {
            $sqlQuery = $this->getSql()->select();
        
            $sqlStmt = $this->getSql()->prepareStatementForSqlObject($sqlQuery);
        
            $handler = $sqlStmt->execute();
        
            $classMethod = new ClassMethodsHydrator();
            $entity = new  CommentEntity();
        
            $resultSet = new HydratingResultSet($classMethod,$entity);
            $resultSet->initialize($handler);
        
            return $resultSet;
        }
    }