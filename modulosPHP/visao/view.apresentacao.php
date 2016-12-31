<?php
/**
 * @author Alex
 * @date 24/12/2016
 */

include_once 'view.geral.php';
class view_apresentacao extends view_geral{
  protected $oModel;
  
  public function __construct(model_Mensagem_Agenda $oModel) {
    parent::__construct();
    $this->oModel = $oModel;
  }
  
  public function montarCorpoConteudo() {?>
      
      <div class='vertical-center'>
  
        <div class="frase">
          <?php 
            echo $this->oModel->tx_mensagem;
          ?>
        </div>
        <?php 
        if (trim($this->oModel->nm_autor) != '') { ?>
          <div class="autor"><?php
            echo $this->oModel->nm_autor;?>
          </div>
        <?php
        }

        if (is_array($this->oModel->aNomesTagsRelacionadas)) { ?>
          <div> <?php 
            foreach ($this->oModel->aNomesTagsRelacionadas as $sTag) { ?>
              <button type="button" class="btn" aria-label="Left Align">
                <span><?php echo $sTag; ?></span>
              </button> <?php
            }?>
          </div><?php
        }?>
      </div><?php
      
  }

}
