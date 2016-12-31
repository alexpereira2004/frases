<?php

class Controller {
  private $sPgAtual;
  private $oHtmlGeral;
  private $oUtil;

  public function __construct($oView) {
    
    $this->oUtil = new wTools();
    $this->sPgAtual = $this->oUtil->buscarNomePaginaAtual();

    if (empty($this->sPgAtual)) {
      $this->sPgAtual = 'index';
    }
    
    
    switch ($this->sPgAtual) {
      case 'modelo':
        
        $oTags = $oModel->buscarTags();
        
        
              foreach ($oTags as $o) {
                echo $o->id. ' '. $o->nm_tag.'<br />';
              }
        
        $oView->tela();
        break;
    }
    
    
    
    
    
    
    
    
  }
  
  /* controller::instanciarObjeto
   *
   * Define qual objeto view ser� usado para cada p�gina.
   * A referencia para instanciar um novo objeto � a url atual da p�gina
   * @date 27/04/2015
   * @return object
   */
  public function instanciarView($oModel) {
    
    $sNomeObjeto = 'view_'.$this->sPgAtual;
    
    // Caso a view n�o exista, chama o index
    if (!class_exists($sNomeObjeto)) {
      $sNomeObjeto = 'view_index'; 
    }

    return new $sNomeObjeto($oModel);
  }

  public function instanciarModel() {
    $aParametros = array();
    
    $sNomeObjeto = 'model_'.$this->sPgAtual;
    
    // Caso a classe n�o exista, chama o index
    if (!class_exists($sNomeObjeto)) {
      $sNomeObjeto = 'model_index'; 
    }

    return new $sNomeObjeto($aParametros);    
  }
   
  
}
