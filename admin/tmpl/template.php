<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license     GNU General Public License version 2 or later
 * @link        https://an-software.net
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

?>

<p><label for="ictemplate"><?= Text::_('COM_INLINECONTACT_SELECT_TEMPLATE'); ?></label></p>
<select class="form-select mb-3" name="ictemplate" id="ictemplate">
	<option value="0"><?= Text::_('COM_INLINECONTACT_NO_TEMPLATE'); ?></option>
	<?php foreach($this->templates as $key => $name): ?>
		<option value="<?=($key+1)?>" <?= $this->selectedTemplate === ($key+1) ? 'selected' : '' ?>><?=$name?></option>
	<?php endforeach; ?>
</select>
