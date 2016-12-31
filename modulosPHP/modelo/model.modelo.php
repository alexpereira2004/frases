<?php

include 'class.model.php';
include_once 'modulosPHP/dao/dao.autores.php';
include_once 'modulosPHP/dao/dao.mensagem.php';
include_once 'modulosPHP/dao/dao.tags.php';

class Model_modelo extends Model{
  public function __construct() {
    $this->oUtil = new wTools();
    $this->oTag = new tags(); 
  }
  
  public function buscarTags() {
    $this->oTags = $this->oTag->listar();
    return $this->oTags;
  }
}
