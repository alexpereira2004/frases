<?php

  include_once 'modulosPHP/class.wTools.php';
  $oUtil   = new wTools();

//  include_once 'modulosPHP/load.php';
  
  include 'modulosPHP/model/model.modelo.php';
  include 'modulosPHP/class.controller.php';
  include 'modulosPHP/view/view.modelo.php';

  $oModel = new Model_modelo();
  $oView = new View_modelo();

  $oControle = new Controller($oModel, $oView);
