<?php



class view_carregar_frases extends view_geral implements InterfaceVisao {
  protected $oModel;
  
  
  public function __construct($oModel) {
    parent::__construct();
    $this->oModel = $oModel;
  }
  public function montarCorpoConteudo () { ?>
      <form method="post" action="<?php echo $this->sPgAtual; ?>">
        <input type="hidden" name="sAcao" value="salvar" />
        <div class="form-group">

          <label for="CMPurls">Urls</label>
          <textarea id="CMPurls" name="CMPurls" class="form-control" rows="3" placeholder="Colar as urls separadas por quebra de linha"><?php echo $this->oModel->__get('sUrls'); ?></textarea>

          <label for="CMPpadrao">Tag(Padrão para busca)</label>
          <input type="text" class="form-control" id="CMPpadrao" name="CMPpadrao" placeholder="Padrão" value="<?php echo $this->oModel->__get('sPadrao'); ?>"/>
          
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-default">Enviar</button>
        </div>

    </form>
  <?php
  
 
    if(!empty($this->oModel->__get('aConteudoExtraido'))) { ?>
      <div class="container"><?php
  
        foreach ($this->oModel->__get('aConteudoExtraido') as $aDadosNovaFrase) {
          $sFrase = str_replace('<p class="frase">', '', $aDadosNovaFrase['frase']);
          $sFrase = str_replace('</p>','',$sFrase);
          echo "INSERT INTO mensagem (tx_mensagem, cd_tipo, dt_inc, id_autor, status) VALUES ('".$sFrase."','FR',curdate(),null,null);"."<br />";
        } ?>
      </div><?php
    } else {
      for ($i = 1; $i <= 50; $i++) {
        echo 'http://www.frasesdobem.com.br/page/'.$i.";";
      }
    }
    
  }

//  public function metaTags () {}
//  public function incluirCss () {}
//  public function incluirJs () {}
//  public function cabecalho () {}
//  public function rodape () {}
//  public function analytics () {}
//  public function montarMensagemUsuario () {}
}