<?php
    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 04/01/2023
     * Time: 15:24
     */
    
    namespace App\Model\Entity;
    
    
    class CommentEntity
    {
        protected $id;
        protected $email;
        protected $pseudo;
        protected $note;
        protected $comment;
        protected $photo;
        protected $date_create;
    
        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }
    
        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }
    
        /**
         * @return mixed
         */
        public function getPseudo()
        {
            return $this->pseudo;
        }
    
        /**
         * @param mixed $pseudo
         */
        public function setPseudo($pseudo)
        {
            $this->pseudo = $pseudo;
        }
    
        /**
         * @return mixed
         */
        public function getNote()
        {
            return $this->note;
        }
    
        /**
         * @param mixed $note
         */
        public function setNote($note)
        {
            $this->note = $note;
        }
    
        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->comment;
        }
    
        /**
         * @param mixed $commentaire
         */
        public function setComment($commentaire)
        {
            $this->comment = $commentaire;
        }
    
        /**
         * @return mixed
         */
        public function getPhoto()
        {
            return $this->photo;
        }
    
        /**
         * @param mixed $photo
         */
        public function setPhoto($photo)
        {
            $this->photo = $photo;
        }
    
        /**
         * @return mixed
         */
        public function getDateCreate()
        {
            return $this->date_create;
        }
    
        /**
         * @param mixed $date_create
         */
        public function setDateCreate($date_create)
        {
            $this->date_create = $date_create;
        }
    
        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }
    }