<?php
include_once 'view.geral.php';


class view_sortear_mensagens extends view_geral{
  protected $oModel;
  
  
  public function __construct($oModel) {
    parent::__construct();
    $this->oModel = $oModel;
    
  }
  
  public function montarCorpoConteudo() {
    parent::montarCorpoConteudo();?>
      <h2>Sortear os dias que as mensagens aparecerão aos usuários</h2>
      <p></p>
      <?php
      $this->formularioPrincipal();
  }
  
  private function formularioPrincipal() { ?>

      
     
      <form method="post" id="FRM_sortear_frase" action="<?php echo $this->sPgAtual; ?>">
        <input type="hidden" name="sAcao" value="gerar" />
        <div class="form-group">

          <label for="CMPdataInicio">Data Início</label>
          <div class="input-group date form_date " data-date="" data-date-format="dd MM yyyy" data-link-field="CMPdataInicio" data-link-format="yyyy-mm-dd">
            <input class="form-control" name="CMPdataInicioPorExtenso" size="16" type="text" value="<?php echo $this->oModel->sDataInicioPorExtenso; ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          </div>
          <input type="hidden" name="CMPdataInicio" id="CMPdataInicio" value="<?php echo $this->oModel->sDataInicio; ?>" />

          <label for="CMPdataFinal">Data Final</label>
          <div class="input-group date form_date " data-date="" data-date-format="dd MM yyyy" data-link-field="CMPdataFinal" data-link-format="yyyy-mm-dd">
            <input class="form-control" name="CMPdataFinalPorExtenso" size="16" type="text" value="<?php echo $this->oModel->sDataFinalPorExtenso; ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          </div>
          <input type="hidden" name="CMPdataFinal" id="CMPdataFinal" value="<?php echo $this->oModel->sDataFinal; ?>" />

        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">Enviar</button>
        </div>
      </form>
      <?php
  }

}
