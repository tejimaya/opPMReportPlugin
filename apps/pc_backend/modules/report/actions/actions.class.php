<?php

/**
 * report actions.
 *
 * @package    OpenPNE
 * @subpackage report
 * @author     Your name here
 */
class reportActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $config = sfYaml::load(sfConfig::get('sf_plugins_dir').'/opPMReportPlugin/config/reports.yml');

    $snsConfig = Doctrine::getTable('SnsConfig');
    $this->daily = json_decode($snsConfig->get('pm_report_daily', '{}'), true);
    $this->nowDates = array();
    $this->lastDates = array();
    $this->nowDaily = array();
    $this->lastDaily = array();
    $this->captions = array();
    foreach($this->daily as $type => $data)
    {
      $typeCaption = $config['report'][$type]['caption'];
      $this->nowDaily[$typeCaption] = array();
      $this->lastDaily[$typeCaption] = array();
      $this->captions[] = $typeCaption;
      foreach ($data as $date => $count)
      {
        if (substr($date, 0, 7) === date('Y-m'))
        {
          $this->nowDaily[$typeCaption][$date] = $count;
          $this->nowDates[] = $date;
        }
        elseif(substr($date, 0, 7) === date('Y-m', strtotime('-1 month')))
        {
          $this->lastDaily[$typeCaption][$date] = $count;
          $this->lastDates[] = $date;
        }
      }
    }
    $this->nowDates = array_unique($this->nowDates);
    $this->lastDates = array_unique($this->lastDates);
    $this->months = array();
    $monthly = json_decode($snsConfig->get('pm_report_monthly', '{}'), true);
    $this->monthly = array();
    foreach ($monthly as $key => $data)
    {
      foreach ($data as $month => $count)
      {
        $this->monthly[$config['report'][$key]['caption']][$month] = $count;
        $this->months[] = $month;
      }
      ksort($this->monthly[$config['report'][$key]['caption']]);
    }
    $this->months = array_unique($this->months);
    sort($this->months);
  }
}
