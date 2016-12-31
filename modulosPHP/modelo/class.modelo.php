<?php

  class Modelo {
    public $mAcaoResultado;
    public $sAcaoMsg;
    public $sAcaoMsgErro;
    public $sAcaoLink = '#';
    
    public function __set ($name,$value){
      $this->$name = $value;
    }

    public function __get ($name){
      return $this->$name;
    }
  }
