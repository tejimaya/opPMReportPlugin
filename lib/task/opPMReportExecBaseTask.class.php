<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opPMReportExecBaseTask
 *
 * @package    opPMReportPlugin 
 * @author     Yuya Watanabe <watanabe@openpne.jp>
 */
abstract class opPMReportExecBaseTask extends sfBaseTask
{
  protected function setDailyReport($name, $date, $count)
  {
    $snsConfigTable = Doctrine::getTable('SnsConfig');
    $daily = json_decode($snsConfigTable->get('pm_report_daily', '{}'), true);
    if (!isset($daily[$name]))
    {
      $daily[$name] = array();
    }
    $daily[$name][$date] = $count;
    $snsConfigTable->set('pm_report_daily', json_encode($daily));
  }

  protected function setMonthlyReport($name, $date, $count)
  {
    $snsConfigTable = Doctrine::getTable('SnsConfig');
    $monthly = json_decode($snsConfigTable->get('pm_report_monthly', "{}"), true);
    if (!isset($monthly[$name]))
    {
      $monthly[$name] = array();
    }
    $month = substr($date, 0, 7);
    if (!isset($monthly[$name][$month]))
    {
      $monthly[$name][$month] = 0;
    }
    $monthly[$name][$month] = $count;
    $snsConfigTable->set('pm_report_monthly', json_encode($monthly));
  }

  protected function addMonthlyReport($name, $date, $count)
  {
    $snsConfigTable = Doctrine::getTable('SnsConfig');
    $monthly = json_decode($snsConfigTable->get('pm_report_monthly', "{}"), true);
    if (!isset($monthly[$name]))
    {
      $monthly[$name] = array();
    }
    $month = substr($date, 0, 7);
    if (!isset($monthly[$name][$month]))
    {
      $monthly[$name][$month] = 0;
    }
    $monthly[$name][$month] += $count;
    $snsConfigTable->set('pm_report_monthly', json_encode($monthly));
  }
}
