<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license     GNU General Public License version 2 or later
 * @link        https://an-software.net
 */


use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$app = Factory::getApplication();

if ($app->isClient('site'))
{
	Session::checkToken('get') or die(Text::_('JINVALID_TOKEN'));
}

$url = JRoute::_('index.php?option=com_contact');
$app->redirect($url);
