<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opPMReportExecTotalLoginTask
 *
 * @package    opPMReportPlugin 
 * @author     Yuya Watanabe <watanabe@openpne.jp>
 */
class opPMReportExecTotalLoginTask extends opPMReportExecBaseTask
{
  protected function configure()
  {
    $this->namespace = 'opPMReport';
    $this->name = 'totalLogin';

    $this->addOption('date', null, sfCommandOption::PARAMETER_REQUIRED, 'Which date?', '');
  }

  protected function execute($arguments = array(), $options = array())
  {
    $date = $options['date'];
    $databaseManager = new sfDatabaseManager($this->configuration);

    $conn = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = Doctrine::getTable('MemberConfig')->createQuery()
      ->select('substring(value_datetime, 1, 10) as date, count(*)')
      ->where('name="lastLogin"')
      ->groupBy('date')
      ->fetchArray(array(), Doctrine_Core::HYDRATE_NONE);
    $isUpdate = false;
    foreach ($results as $result)
    {
      if ($result['date'] === $date)
      {
        $this->setDailyReport('login', $date, $result['count']);
        $this->addMonthlyReport('login', $date, $result['count']);
        $isUpdate = true;
        break;
      }
    }
    if (!$isUpdate)
    {
      $this->setDailyReport('login', $date, 0);
      $this->addMonthlyReport('login', $date, 0);
    }
  }
}
