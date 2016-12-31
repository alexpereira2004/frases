<?php

include_once 'dao.seg_parametros.php';

class parametros extends seg_parametros{

  public $ID = array();
  public $NM_PARAMETRO = array();
  public $TX_EXPLICATIVO = array();
  public $CD_TIPO_USO = array();
  public $CD_TIPO = array();
  public $NU_LIMITE_CADASTRO = array();
  public $CD_ATIVO = array();
  public $TX_VALOR = array();
  public $ID_VALOR = array();
  public $NU_USADOS = array();

  public function __construct() {
    parent::__construct();
  }
  
  public function buscar() {
//    $sQuery = "  SELECT valores.id_parametro,
//                        param.nu_limite_cadastro AS limite,
//                        count(param.cd_parametro) AS ja_usado,
//                        param.nu_limite_cadastro - count(param.id) AS disponiveis
//                   FROM seg_parametros param
//              LEFT JOIN seg_parametros_valores valores on valores.id_parametro = param.id
//		  WHERE valores.id_parametro IS NOT NULL 
//               GROUP BY valores.id_parametro,
//                        param.nu_limite_cadastro";
//    
//    
//    
//    $mResLimites = $this->oBd->query($sQuery);
//
//    if (!is_array($mResLimites)) {
//      $this->aMsg = $this->oBd->getMsg();
//      return false;
//    }
    
    $sQuery = "   SELECT param.id,
                         param.nm_parametro,
                         param.tx_explicativo,
                         param.cd_tipo_uso,
                         param.cd_tipo,
                         param.nu_limite_cadastro,
                         param.nu_limite_cadastro - (select count(1) from seg_parametros_valores where id_parametro = param.id) as nu_disponivel,
                         (select count(1) from seg_parametros_valores where id_parametro = param.id) as nu_usados,
                         param.cd_ativo,
                         tx_valor,
                         valores.id AS id_valor
                    FROM seg_parametros param
               LEFT JOIN seg_parametros_valores valores on valores.id_parametro = param.id
	        ORDER BY param.nu_ordem, param.nu_importancia, param.id, valores.id ";

//    $mResultado = $this->oBd->query($sQuery);
    $mResultado = $this->oBd->query($sQuery);

    if (!is_array($mResultado)) {
      $this->aMsg = $this->oBd->getMsg();
      return false;
    }
    $this->iLinhas = $this->oBd->getNumeroLinhas();
    
    for ($i= 0; $i < $this->iLinhas; $i++) { 
      $this->ID[]                 = $mResultado[$i]['id'];
      $this->NM_PARAMETRO[]       = $mResultado[$i]['nm_parametro'];
      $this->TX_EXPLICATIVO[]     = $mResultado[$i]['tx_explicativo'];
      $this->CD_TIPO_USO[]        = $mResultado[$i]['cd_tipo_uso'];
      $this->CD_TIPO[]            = $mResultado[$i]['cd_tipo'];
      $this->NU_LIMITE_CADASTRO[] = $mResultado[$i]['nu_limite_cadastro'];
      $this->NU_DISPONIVEL[]      = $mResultado[$i]['nu_disponivel'];
      $this->NU_USADOS[]          = $mResultado[$i]['nu_usados'];
      $this->CD_ATIVO[]           = $mResultado[$i]['cd_ativo'];
      $this->TX_VALOR[]           = $mResultado[$i]['tx_valor'];
      $this->ID_VALOR[]           = $mResultado[$i]['id_valor'];

      if (!isset($this->NU_CADASTRO[$mResultado[$i]['id']])) {
        $this->NU_CADASTRO[$mResultado[$i]['id']] = $mResultado[$i]['nu_limite_cadastro'];
      }
      
      $this->NU_CADASTRO[$mResultado[$i]['id']] -= 1;// $mResultado[$i]['nu_limite_cadastro'];
    }
    return true; 
  }
  
}