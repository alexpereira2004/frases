<?php


class model_sortear_mensagens extends Modelo{
  public $id;
  public $tx_descricao;
  public $sDataInicio;
  public $sDataInicioPorExtenso;
  public $sDataFinal;
  public $sDataFinalPorExtenso;
  
  public function carregarDadosAposPost($aDados) {   
    $this->sDataInicio           = (isset($aDados['CMPdataInicio'])) ? $aDados['CMPdataInicio'] : '';
    $this->sDataInicioPorExtenso = (isset($aDados['CMPdataInicioPorExtenso'])) ? $aDados['CMPdataInicioPorExtenso'] : '';
    $this->sDataFinal            = (isset($aDados['CMPdataFinal'])) ? $aDados['CMPdataFinal'] : '';
    $this->sDataFinalPorExtenso  = (isset($aDados['CMPdataFinalPorExtenso'])) ? $aDados['CMPdataFinalPorExtenso'] : '';
  }
}