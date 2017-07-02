<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of business
 *
 * @author Alex
 */
class business_carregar_frases {
  public function __construct() {

  }
  
  public function salvar() {
    
  }
  
  public function extrairFrasesDePaginasHtml44(model_carregar_frases $oModelo) {
    $DOM = new DOMDocument;
    $DOM->loadHTMLFile('http://www.frasesdobem.com.br/page/4');    
    /* Debug Alex */
    $frase = $DOM->getElementsByTagName('frase');
    print_r('<pre>');
    print_r($frase);
    print_r('</pre>');
  }
  public function extrairFrasesDePaginasHtml(model_carregar_frases $oModelo) {
//    $sRetorno = $oModelo->__get('sUrls');
    
    
    
    $aUrls = explode(';', $oModelo->__get('sUrls'));
    $this->aUrl = $aUrls;

    foreach ($aUrls as $sUrl) {
      $html = file_get_contents(trim($sUrl));
      
      

      preg_match_all('/<p class="frase">(.|\n)*?<\/p>/',
                     $html,
                     $matches
      );

      foreach ($matches[0] as $i => $frase) {
        $aTodasAsFrases[] = array( 'frase' => trim(utf8_decode($frase)));
      }

    }
    return $aTodasAsFrases;

  }
}
