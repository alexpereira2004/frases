<?php

interface InterfaceVisao {
  public function metaTags ();
  public function incluirCss ();
  public function incluirJs ();
  public function cabecalho ();
  public function montarMenu ();
  public function montarCorpoConteudo ();
  public function rodape ();
  public function analytics ();
  public function montarMensagemUsuario ();
  
}
