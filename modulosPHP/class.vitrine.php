<?php

include_once 'dao.ctd_vitrine.php';

class vitrine extends ctd_vitrine{
  
  public function __construct() {
    parent::__construct();
  }

  public function buscar() {
    $sQuery = "   SELECT vitrine.id,
                        vitrine.cd_status, 
                        vitrine.de_titulo, 
                        vitrine.cd_vinculo,
                        vitrine.id_vinculo, 
                        vitrine.nu_ordem,
			html.tp_secao as secao_html,
			html.tx_link as link_html,
			noticia.tx_link as link_noticia,
			imagem.nm_imagem,
                        imagem.cd_extensao

                   FROM ctd_vitrine vitrine
	      LEFT JOIN ctd_htmlgeral html ON (     html.id = vitrine.id_vinculo 
						AND vitrine.cd_vinculo = 'HT' )
	      LEFT JOIN ctd_noticias noticia ON (    noticia.id = vitrine.id_vinculo 
						 AND vitrine.cd_vinculo = 'NT' )
	      LEFT JOIN ctd_imagens imagem ON (     imagem.cd_tipo = 'V'
						AND imagem.id_vinculo = vitrine.id)

                  WHERE vitrine.cd_status = 'AT'
	       ORDER BY vitrine.nu_ordem ";

//    $mResultado = $this->oBd->query($sQuery);
    $mResultado = $this->query($sQuery);

    if (!is_array($mResultado)) {
      $this->aMsg = $this->getMsg();
      return false;
    }
    $this->iLinhas = $this->getNumeroLinhas();

    for ($i= 0; $i < $this->iLinhas; $i++) { 
      $this->ID[]          = $mResultado[$i]['id'];
      $this->CD_STATUS[]   = $mResultado[$i]['cd_status'];
      $this->DE_TITULO[]   = $mResultado[$i]['de_titulo'];
      $this->CD_VINCULO[]  = $mResultado[$i]['cd_vinculo'];
      $this->NM_IMAGEM[]   = $mResultado[$i]['nm_imagem'];
      $this->ID_VINCULO[]  = $mResultado[$i]['id_vinculo'];
      $this->NU_ORDEM[]    = $mResultado[$i]['nu_ordem'];
      $this->CD_EXTENSAO[] = $mResultado[$i]['cd_extensao'];
      $this->TX_LINK[]     = ($mResultado[$i]['cd_vinculo'] == 'NT') ? 'noticias.php?n='.$mResultado[$i]['link_noticia'] : $mResultado[$i]['link_html'];
    }
    return true;
  }
  
  public function montar() {
    ?>
 
        <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
        <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 700px;height: 300px; margin-left: 5px ">

          <!-- Slides Container -->
          <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 700px; height: 300px; overflow: hidden;">
            <?php
              for ($i = 0; $i < $this->iLinhas; $i++) {?>
                <div>
                  <a href="<?php echo $this->TX_LINK[$i]; ?>">
                    <img u="image" src="comum/imagens/vitrine/<?php echo $this->NM_IMAGEM[$i].'.'.$this->CD_EXTENSAO[$i]; ?>" />
                  </a>
                </div>
            <?php
            } ?>          
          </div>
          <?php // Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html ?>
          <style>
              .jssora03l, .jssora03r {
                  display: block;
                  position: absolute;
                  /* size of arrow element */
                  width: 45px;
                  height: 45px;
                  cursor: pointer;
                  background: url(modulosJS/slider/img/a10.png) no-repeat;
                  overflow: hidden;
              }
              .jssora03l { background-position: -3px -33px; }
              .jssora03r { background-position: -63px -33px; }
              .jssora03l:hover { background-position: -123px -33px; }
              .jssora03r:hover { background-position: -183px -33px; }
              .jssora03l.jssora03ldn { background-position: -243px -33px; }
              .jssora03r.jssora03rdn { background-position: -303px -33px; }
          </style>

          <span u="arrowleft" class="jssora03l" style="top: 123px; left: 8px;"></span>

          <span u="arrowright" class="jssora03r" style="top: 123px; right: 8px;"></span>

          <script>
            jssor_slider1_starter('slider1_container');
          </script>
        </div><?php
  
  }
}
