<?php

  include_once 'dao.seg_loggeral.php';
  include_once 'dao.seg_usuarios.php';
  include_once 'class.wTools.php';

  class sessaoUsuario extends seg_usuarios{
    public $sOrigem;
    public $aSessao = array();
    public $oUtil;
    private $sCdEmpresa;
    public static $SCAPE = 'DEPBRAVO_2015';
    public static $CD_EMPRESA;

    public function  __construct() {
      parent::__construct();
      $this->oLog  = new seg_loggeral();
      $this->oUtil = new wTools();

//      $this->oUtil->buscarParametro('NOME_EMPRESA');
      $this->sCdEmpresa = 'a'; //$this->oUtil->aParametros['NOME_EMPRESA'][0];
    }
    
   /* usuarios::getEmpresa
   *
   * Parâmetro cadastrado utilizado em sessões, permitindo um login para cada
   * projeto/empresa cadastrada
   * 
   * @date 28/12/2012
   * @param
   * @return
   */
    public static function getEmpresa() {
//      self::$oUtil       = new wTools();
//      self::$oUtil->buscarParametro('NOME_EMPRESA');
//      self::$CD_EMPRESA = self::$oUtil->aParametros['NOME_EMPRESA'][0];
//      return self::$CD_EMPRESA;
    }

    /*
     * Checa se usuário tem permissão de acesso para as páginas
     */
    public function validar() {

      try {

        if (!isset ($_SESSION[$this->sCdEmpresa]['tmp_atv'])) {
          $sTxLog = 'Tentativa de acesso ao sistema sem sessão';
          throw new Exception;
        }

        if ($_SESSION[$this->sCdEmpresa]['cd_nivel'] < 5) {
          $sTxLog = 'Nível do usuário não permite acesso a este módulo';
          throw new Exception;
        }

        // Teste de inatividade de usuário
        $this->oUtil->buscarParametro('EXPIRAR_SESSAO');

        $iParamExpira = $this->oUtil->aParametros['EXPIRAR_SESSAO'][0] * 60;
        $iDifTime = time() - $_SESSION[$this->sCdEmpresa]['tmp_atv'];
        if ($iDifTime > $iParamExpira) {
          $sTxLog = 'Tempo da sessão do usuário expirou';
          throw new Exception;
        }
        //Teste do token
        $sSQL = " SELECT tx_token "
                . " FROM seg_usuarios "
                . "WHERE cd_status = 'AT' "
                . "  AND id = ".$_SESSION[$this->sCdEmpresa]['id_usu'];
        $aRet = $this->oUtil->buscarInfoDB($sSQL);

        if ($aRet['tx_token'] != $_SESSION[$this->sCdEmpresa]['token']) {
          $sTxLog = 'Token não foi atualizado';
          throw new Exception;
        }

        // Atualiza o tempo para que a sessao possa continuar ativa
        $_SESSION[$this->sCdEmpresa]['tmp_atv'] = time();

        
        //$_SESSION[$this->sCdEmpresa]['permissoes']  = $this->buscarPermissoesEspeciais($_SESSION[$this->sCdEmpresa]['id_usu']);

        return true;


      } catch (Exception $exc) {

        // Caso haja falha ao fazer login, registra na tabela de log
        $this->oLog->NM_LOG[0]   = 'Falha na validação do usuário';
        $this->oLog->TX_LOG[0]   = $sTxLog;
        $this->oLog->CD_LOG[0]   = 'ACESSO_INVALIDO';
        $this->oLog->CD_ACAO[0]  = 'I';
        $this->oLog->TX_IP[0]    = $_SERVER['REMOTE_ADDR'];
        $this->oLog->TX_TRACE[0] = $_SERVER['REQUEST_URI'];
        $this->oLog->ID_USU[0]   = 0;
        $this->oLog->inserir();

        
        //$sMsg = ($sLocais != '') ? 'Para acessar esta página seu usuário deve possuir permissão à: '.$sLocais : 'O acesso para esta página é restrito.';
        $sUrl    = 'login.php';
        $aCampos = array('mResultado' => 2,
                         'sMsg' => $sTxLog,
                         'sMsgErro' => '',
                         'CMPmsgRetorno' => 'ret');

        $this->oUtil->redirFRM($sUrl, $aCampos);
        header("Location: login.php");
        exit;
      }

      return true;
    }

    public function dadosSessaoUsuario($iIdUsu) {
      
      $_SESSION[$this->sCdEmpresa]['tmp_atv']     = time();
      $_SESSION[$this->sCdEmpresa]['token']       = base64_encode('usuario-'.$this->NM_USUARIO[0].'-login-em-'.time());
      $_SESSION[$this->sCdEmpresa]['id_usu']      = $iIdUsu;
      $_SESSION[$this->sCdEmpresa]['nm_usu']      = $this->NM_USUARIO[0];
      $_SESSION[$this->sCdEmpresa]['cd_nivel']    = $this->CD_NIVEL[0];
    }
    
  /* usuarios::atualizarToken
   *
   * Atualiza o campo tx_token na tabela de usuários
   * @date 03/06/2012
   * @param
   * @return
   */
    private function atualizarToken() {

      $sQuery = "UPDATE seg_usuarios
                    SET tx_token = '".$_SESSION[$this->sCdEmpresa]['token']."'
                  WHERE id = ".$this->ID[0];
      $sResultado = $this->oBd->execute($sQuery);
      return true;
    }

    public function registrarLogin() {
      $this->oLog->NM_LOG[0]   = 'Login Admin - '.$this->NM_USUARIO[0];
      $this->oLog->TX_LOG[0]   = '';
      $this->oLog->CD_LOG[0]   = 'REG_LOG_SYS';
      $this->oLog->CD_ACAO[0]  = 'I';
      $this->oLog->TX_IP[0]    = $_SERVER['REMOTE_ADDR'];
      $this->oLog->TX_TRACE[0] = $this->sOrigem;
      $this->oLog->ID_USU[0]   = $this->ID[0];
      $this->oLog->inserir();
      return true;
    }

    public function registrarTentativaDeLogin($sEmail, $sSenha) {
      $aDados = array('Tx_Login' => $sEmail,
                      'Tx_Senha' => md5(self::SCAPE.$sSenha) );
      $sTxLog = $this->oUtil->montarStringDados($aDados);

      $this->oLog->NM_LOG[0]   = 'Tentativa de Login no Painel de Administração';
      $this->oLog->TX_LOG[0]   = $sTxLog;
      $this->oLog->CD_LOG[0]   = 'REG_ERROR_LOG_SYS';
      $this->oLog->CD_ACAO[0]  = 'A';
      $this->oLog->TX_IP[0]    = $_SERVER['REMOTE_ADDR'];
      $this->oLog->TX_TRACE[0] = $this->sOrigem;
      $this->oLog->ID_USU[0]   = 0;

      $this->oLog->inserir();
      return true;
    }

    /*
     * Processo de Login
     * este metodo retorna os dados do usuario
     */
    public function validarLogin($sUsuario, $sSenha, $bCrip = true) {
      $sUsuario = $this->oUtil->anti_sql_injection($sUsuario);
      $sSenha   = $this->oUtil->anti_sql_injection($sSenha);

      if($bCrip) {
        $sFiltro = "WHERE (   tx_email = '".$sUsuario."' "
                . "        OR tx_login = '".$sUsuario."' )"
                . "   AND  tx_senha = MD5('".self::$SCAPE.$sSenha."')";
      } else {
        $sFiltro = "WHERE (   tx_email = '".$sUsuario."' "
                . "        OR tx_login = '".$sUsuario."' )"
                . "   AND  tx_senha = ('".$sSenha."')";
      }
      $sFiltro .= " AND cd_status = 'AT'";

      $this->listar($sFiltro);
      
      if (!$this->iLinhas) {
        $this->sMsg  = 'Seu email ou senha está incorreto!';
        $this->sErro = mysql_error();
        $this->sResultado = 'erro';
        return false;
      }
      
      $this->sMsg  = 'Bem vindo '.$this->NM_USUARIO[0];

      $this->registrarLogin();
      $this->dadosSessaoUsuario($this->ID[0]);
      $this->atualizarToken();
      

      return true;
    }

    public function deslogar() {
      session_unset();
      header('location:login');
      die();
    }
    
    public function getDadosSessao() {
      $this->aSessao = array(
        'tmp_atv' => $_SESSION[$this->sCdEmpresa]['tmp_atv'],
        'token'   => $_SESSION[$this->sCdEmpresa]['token'],
        'id_usu'  => $_SESSION[$this->sCdEmpresa]['id_usu'],
        'nm_usu'  => $_SESSION[$this->sCdEmpresa]['nm_usu']
      );
      return true;
    }
    
    
  /* usuarios::verificarPermissaoAcesso
   *
   * Valida as permissões do usuário para ACESSOS
   * @date 30/06/2012
   * @param string $sCodigoLocal - Código que esta na tabela "tc_permissoes.cd_codigo"
   * @param string $sAcao        - ["A"],["V"]
   * @return bool
   */
    public function verificarPermissaoAcesso($sCodigoLocal, $sAcao) {

      if (!isset ($_SESSION[$this->sCdEmpresa]['permissoes'][$sCodigoLocal])) {
        return false;
      }
      if ($_SESSION[$this->sCdEmpresa]['permissoes'][$sCodigoLocal][$sAcao] == 'L') {
        return true;
      }

      return false;
    }

  /* usuarios::buscarPermissoesEspeciais
   *
   * Faz busca das permissões de acesso do usuário tanto por cadastros pessoais quanto
   * de grupo. Caso exista permissão gravada em ambas tabelas, da prioridade à configuração
   * pessoal.
   * 
   * @date 30/06/2012
   * @update 24/05/2015 - Trocado o nome do método (anterior: buscarPermissoesLogin)
   * @param  $iIdUsu - Código do usuário
   * @return $aDados - Array - Permissões
   */
    public function buscarPermissoesEspeciais($iIdUsu) {
      $sSQL = "SELECT tc_usu_admin.id ,
                      tc_permissoes.cd_codigo,
                      'U' as cd_orig,
                      tr_usuarios_permissoes.id_permissao,
                      tr_usuarios_permissoes.cd_inserir,
                      tr_usuarios_permissoes.cd_remover,
                      tr_usuarios_permissoes.cd_editar,
                      tr_usuarios_permissoes.cd_acessar,
                      tr_usuarios_permissoes.cd_visualizar
                      FROM tc_usu_admin
           INNER JOIN tr_usuarios_permissoes ON tr_usuarios_permissoes.id_usuario = tc_usu_admin.id
           INNER JOIN tc_permissoes ON tc_permissoes.id = tr_usuarios_permissoes.id_permissao
                WHERE tc_usu_admin.id = ".$iIdUsu."

                    UNION ALL

             SELECT tr_usuarios_grupo.id_grupo ,
                    tc_permissoes.cd_codigo,
                    'G' as cd_orig,
                    tr_grupos_permissoes.id_permissao,
                    tr_grupos_permissoes.cd_inserir,
                    tr_grupos_permissoes.cd_remover,
                    tr_grupos_permissoes.cd_editar,
                    tr_grupos_permissoes.cd_acessar,
                    tr_grupos_permissoes.cd_visualizar
               FROM tc_usu_admin
         INNER JOIN tr_usuarios_grupo ON tr_usuarios_grupo.id_usuario = tc_usu_admin.id
         INNER JOIN tr_grupos_permissoes ON tr_grupos_permissoes.id_grupo = tr_usuarios_grupo.id_grupo
         INNER JOIN tc_permissoes ON tc_permissoes.id = tr_grupos_permissoes.id_permissao
              WHERE tc_usu_admin.id = ".$iIdUsu."
                    ORDER BY cd_orig";
    
      $sResultado = mysql_query($sSQL, $this->DB_LINK);

      if (!$sResultado) {
        die('Erro ao criar a listagem: ' . mysql_error());
        return false;
      }

      $this->iLinhasPermissoes = mysql_num_rows($sResultado);

      $aDados = array();

      while ($aResultado = mysql_fetch_array($sResultado)) {
        $this->ID[]            = $aResultado['id'];
        $this->CD_CODIGO[]     = $aResultado['cd_codigo'];
        $this->CD_ORIG[]       = $aResultado['cd_orig'];
        $this->ID_PERMISSAO[]  = $aResultado['id_permissao'];
        $this->CD_INSERIR[]    = $aResultado['cd_inserir'];
        $this->CD_REMOVER[]    = $aResultado['cd_remover'];
        $this->CD_EDITAR[]     = $aResultado['cd_editar'];
        $this->CD_ACESSAR[]    = $aResultado['cd_acessar'];
        $this->CD_VISUALIZAR[] = $aResultado['cd_visualizar'];

        $aDados[$aResultado['cd_codigo']] = array ('I' => $aResultado['cd_inserir'],
                                                   'R' => $aResultado['cd_remover'],
                                                   'E' => $aResultado['cd_editar'],
                                                   'A' => $aResultado['cd_acessar'],
                                                   'V' => $aResultado['cd_visualizar'] );
      }

      return $aDados;
    }
    
  /* usuarios::buscarPermissoesUsuario
   *
   * 
   * @date 24/05/2015
   * @param  $iIdUsu - Código do usuário
   * @return $aDados - Array - Permissões
   */
    public function buscarPermissoesUsuario($iIdUsu) {

    }    
  }
?>
