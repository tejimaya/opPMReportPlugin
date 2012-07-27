<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opPMReportExecTotalAllTask
 *
 * @package    opPMReportPlugin 
 * @author     Yuya Watanabe <watanabe@openpne.jp>
 */
class opPMReportExecTotalAllTask extends sfBaseTask
{
  protected function configure()
  {
    $this->namespace = 'opPMReport';
    $this->name = 'totalall';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $tasks = $this->setdefaulttask();

     foreach ($tasks as $task)
     {
       $taskName = sprintf('opPMReportExec%sTask', $task['task']);
       $t = new $taskName($this->dispatcher, $this->formatter);
       $t->run($arguments = array(),$options = $task['option']);
       unset($t);
     }
  }

  protected function setdefaulttask()
  {
    $config = sfYaml::load(sfConfig::get('sf_plugins_dir').'/opPMReportPlugin/config/reports.yml');

    $tasks = array();
    foreach ($config['report'] as $report)
    {
      $tasks[] = $report['task'];
    }

    foreach ($tasks as $task)
    {
      $taskoptions[] = array('task' => $task, 'option' => array('date' => date('Y-m-d', strtotime('-1 day'))));
    }

     return $taskoptions;
  }
}
