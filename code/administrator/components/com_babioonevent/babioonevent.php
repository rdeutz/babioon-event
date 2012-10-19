<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

if (!defined('BABIOON'))
{
	// we need the BABIOON System Plugin
	jexit('we need the BABIOON System Plugin');
}

// Include dependancies
jimport('joomla.application.component.controller');

require JPATH_COMPONENT.'/helpers/babioonevent.php';

// Execute the task.
$controller	= JController::getInstance('BabioonEvent');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

/** EOF **/