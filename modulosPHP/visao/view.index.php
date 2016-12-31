<?php
include_once 'view.geral.php';


class view_index extends view_geral{
  protected $oModel;

  public function __construct($oModel) {
    parent::__construct();
    $this->oModel = $oModel;
  }
  
  public function montarCorpoConteudo() {

    ?>
      <h2>Objetivo</h2>
      <p>Este site tem o propósito de ...</p>
      <?php
//       $this->formularioPrincipal();
  }
  

  
  

  
}
