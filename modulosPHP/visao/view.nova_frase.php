<?php
include_once 'view.geral.php';


class view_nova_frase extends view_geral{
  protected $oModel;
  
  
  public function __construct($oModel) {
    parent::__construct();
    $this->oModel = $oModel;
  }

  public function montarCorpoConteudo() {

    ?>
      <h2>Adicionar novas frases à base de dados</h2>
      <p>Ao inserir uma nova frase você esta contribuindo para este projeto.<br />
      As frases adicionadas aqui são sorteadas para serem apresentadas durante o ano.</p>
      <?php
       $this->formularioPrincipal();
  }
  
  private function formularioPrincipal() { ?>
      <form method="post" action="<?php echo $this->sPgAtual; ?>">
        <input type="hidden" name="sAcao" value="salvar" />
        <div class="form-group">
          <label for="CMPautor">Autor</label>
          <input type="text" class="form-control" id="CMPautor" name="CMPautor" placeholder="Autor" value="<?php echo $this->oModel->sAutor; ?>"/>

          <label for="CMPfrase">Frase</label>
          <textarea id="CMPfrase" name="CMPfrase" class="form-control" rows="3" placeholder="Frase"><?php echo $this->oModel->sFrase; ?></textarea>

          <label for="CMPtag">Associar tags</label>
          <select id="CMPtag" name="CMPtag[]" data-placeholder="Tag ou assunto relacionado" class="chosen-select" multiple >
            <option value=""></option>
            <?php
              foreach ($this->oModel->aModeloTags as $o) { 
                  $sSelecionado =  in_array($o->id, $this->oModel->aCodigoTagsSelecionados ) ? "selected" : '';
                ?>
                <option value="<?php echo $o->id; ?>" <?php echo $sSelecionado; ?>><?php echo $o->nm_tag; ?></option>
                <?php
              }
            ?>
          </select>        
        

        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">Enviar</button>
        </div>
      </form>

      <?php
    
  }
}
