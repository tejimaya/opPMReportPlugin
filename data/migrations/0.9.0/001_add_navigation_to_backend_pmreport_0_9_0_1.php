<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class addNavigationToBackendPMReport_0_9_0_1 extends Doctrine_Migration_Base
{
  public function up()
  {
    Doctrine::loadData(sfConfig::get('sf_plugins_dir').'/opPMReportPlugin/data/fixtures/001_backend_navigation_menu.yml', true);
  }

  public function down()
  {
  }
}
