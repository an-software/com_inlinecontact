<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license         GNU General Public License version 2 or later
 * @link            https://an-software.net
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

$app = Factory::getApplication();

if ($app->isClient('site'))
{
	Session::checkToken('get') or die(Text::_('JINVALID_TOKEN'));
}

$function  = $app->input->getCmd('function', 'jSelectContact');
$editor    = $app->input->getCmd('editor', '');

?>

<div class="container-popup">
    <p><?= Text::_('COM_INLINECONTACT_SELECT_TYPE'); ?></p>
    <div class="row justify-content-center">

        <div class="col-md-6">
            <a class="d-block card border" href="<?php echo Route::_('index.php?option=com_inlinecontact&view=contacts&layout=modal&tmpl=component&editor=' . $editor . '&' . Session::getFormToken() . '=1'); ?>">
                <div class="card-body text-center">
                    <i class="fas fa-user"></i><br>
                    <?= Text::_('COM_INLINECONTACT_SINGLE_CONTACT'); ?>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a class="d-block card border" href="<?php echo Route::_('index.php?option=com_inlinecontact&view=categories&layout=modal&tmpl=component&extension=com_contact&editor=' . $editor . '&' . Session::getFormToken() . '=1'); ?>">
                <div class="card-body text-center">
                    <i class="fas fa-users"></i><br>
                    <?= Text::_('COM_INLINECONTACT_CONTACT_LIST'); ?>
                </div>
            </a>
        </div>


    </div>
</div>
