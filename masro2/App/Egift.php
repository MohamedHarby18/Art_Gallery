<?php

    namespace APP;
    class Egift extends Product
    {
        private $code;
        private $value;
        private $RecipientEmail;

        public function __construct($code,$value,$Title,$Description,$RecipientEmail,$price){
                parent::__construct($Title,$Description,$price);
                $this->value = $value;
                $this->code = $code;  //copon code 
                $this->RecipientEmail=$RecipientEmail;              
        }

    }