<?php

class opPMReportExecTotalMemberTask extends opPMReportExecBaseTask
{
  protected function configure()
  {
    $this->namespace = 'opPMReport';
    $this->name = 'totalMember';
    
    $this->addOption('date', null, sfCommandOption::PARAMETER_REQUIRED, 'Which date?', '');
  }

  protected function execute($arguments = array(), $options = array())
  {
    $date = $options['date'];
    $databaseManager = new sfDatabaseManager($this->configuration);

    $conn = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = Doctrine::getTable('Member')->createQuery()
      ->select('count(*)')
      ->where('is_active')
      ->fetchArray(array(), Doctrine_Core::HYDRATE_NONE);
    $isUpdate = false;
    foreach ($results as $result)
    {
      $this->setDailyReport('member', $date, $result['count']);
      $this->setMonthlyReport('member', $date, $result['count']);
      $isUpdate = true;
    }
    if (!$isUpdate)
    {
      $this->setDailyReport('member', $date, 0);
      $this->setMonthlyReport('member', $date, 0);
    }
  }
}
