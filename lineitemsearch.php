<?php

require_once 'lineitemsearch.civix.php';


/**
 * Implementation of hook_civicrm_queryObjects
 */
function lineitemsearch_civicrm_queryObjects(&$queryObjects, $type) {
    if ($type == 'Contact') {
        $queryObjects[] = new CRM_Contribute_BAO_LineItem_Query();
    }
    //elseif ($type == 'Report') {
    //    $queryObjects[] = new CRM_Contribute_BAO_Line_Item_Query();
    //}
}

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function lineitemsearch_civicrm_config(&$config) {
  _lineitemsearch_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function lineitemsearch_civicrm_xmlMenu(&$files) {
  _lineitemsearch_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function lineitemsearch_civicrm_install() {
  _lineitemsearch_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function lineitemsearch_civicrm_uninstall() {
  _lineitemsearch_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function lineitemsearch_civicrm_enable() {
  _lineitemsearch_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function lineitemsearch_civicrm_disable() {
  _lineitemsearch_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function lineitemsearch_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _lineitemsearch_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function lineitemsearch_civicrm_managed(&$entities) {
  _lineitemsearch_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function lineitemsearch_civicrm_caseTypes(&$caseTypes) {
  _lineitemsearch_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function lineitemsearch_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _lineitemsearch_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
