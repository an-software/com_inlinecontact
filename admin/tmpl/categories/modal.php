<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_inlinecontact
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$app = Factory::getApplication();

if ($app->isClient('site'))
{
	Session::checkToken('get') or die(Text::_('JINVALID_TOKEN'));
}

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('com_inlinecontact.inlinecontact-modal');

HTMLHelper::_('behavior.core');

$editor    = $app->input->getCmd('editor', '');
$extension = $this->escape($this->state->get('filter.extension'));
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

$this->document->addScriptOptions('xtd-inlinecontact', array('editor' => $editor));
$function = 'inlineContactSelect';

?>
<div class="container-popup">

	<form action="<?php echo Route::_('index.php?option=com_inlinecontact&view=categories&layout=modal&tmpl=component&editor=' . $editor . '&function=' . $function . '&' . Session::getFormToken() . '=1'); ?>" method="post" name="adminForm" id="adminForm">

        <div class="row">
            <div class="col">
	            <?php include(__DIR__ . '/../template.php') ?>
            </div>
            <div class="col">
                <p><label for="icsort"><?= Text::_('COM_INLINECONTACT_SELECT_SORT'); ?></label></p>
                <select class="form-select mb-3" name="icsort" id="icsort">
                    <option value="0" <?= $this->sortMode === 0 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_SORT_0'); ?></option>
                    <option value="1" <?= $this->sortMode === 1 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_SORT_1'); ?></option>
                    <option value="2" <?= $this->sortMode === 2 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_SORT_2'); ?></option>
                </select>
            </div>
            <div class="col">
                <p><label for="icfeatured"><?= Text::_('COM_INLINECONTACT_SELECT_FEATURED'); ?></label></p>
                <select class="form-select mb-3" name="icfeatured" id="icfeatured">
                    <option value="0" <?= $this->featuredMode === 0 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_FEATURED_0'); ?></option>
                    <option value="1" <?= $this->featuredMode === 1 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_FEATURED_1'); ?></option>
                    <option value="2" <?= $this->featuredMode === 2 ? 'selected' : '' ?>><?= Text::_('COM_INLINECONTACT_FEATURED_2'); ?></option>
                </select>
            </div>
        </div>


		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

		<?php if (empty($this->items)) : ?>
			<div class="alert alert-info">
				<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
				<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table" id="categoryList">
				<caption class="visually-hidden">
					<?php echo Text::_('COM_INLINECONTACT_CATEGORIES_TABLE_CAPTION'); ?>,
							<span id="orderedBy"><?php echo Text::_('JGLOBAL_SORTED_BY'); ?> </span>,
							<span id="filteredBy"><?php echo Text::_('JGLOBAL_FILTERED_BY'); ?></span>
				</caption>
				<thead>
					<tr>
						<th scope="col" class="w-1 text-center">
							<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
						</th>
						<th scope="col">
							<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
						</th>
						<th scope="col" class="w-10 d-none d-md-table-cell">
							<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'access_level', $listDirn, $listOrder); ?>
						</th>
						<th scope="col" class="w-15 d-none d-md-table-cell">
							<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language_title', $listDirn, $listOrder); ?>
						</th>
						<th scope="col" class="w-1 d-none d-md-table-cell">
							<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$iconStates = array(
						-2 => 'icon-trash',
						0  => 'icon-times',
						1  => 'icon-check',
						2  => 'icon-folder',
					);
					?>
					<?php foreach ($this->items as $i => $item) : ?>
						<?php if ($item->language && Multilanguage::isEnabled())
						{
							$tag = strlen($item->language);
							if ($tag == 5)
							{
								$lang = substr($item->language, 0, 2);
							}
							elseif ($tag == 6)
							{
								$lang = substr($item->language, 0, 3);
							}
							else
							{
								$lang = '';
							}
						}
						elseif (!Multilanguage::isEnabled())
						{
							$lang = '';
						}
						?>
						<tr class="row<?php echo $i % 2; ?>">
							<td class="text-center">
								<span class="tbody-icon">
									<span class="<?php echo $iconStates[$this->escape($item->published)]; ?>" aria-hidden="true"></span>
								</span>
							</td>
							<th scope="row">
								<?php echo LayoutHelper::render('joomla.html.treeprefix', array('level' => $item->level)); ?>
								<a class="select-link" href="javascript:void(0)" data-function="<?php echo $this->escape($function); ?>" data-id="<?php echo $item->id; ?>" data-type="category">
									<?php echo $this->escape($item->title); ?></a>
								<div class="small" title="<?php echo $this->escape($item->path); ?>">
									<?php if (empty($item->note)) : ?>
										<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
									<?php else : ?>
										<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS_NOTE', $this->escape($item->alias), $this->escape($item->note)); ?>
									<?php endif; ?>
								</div>
							</th>
							<td class="small d-none d-md-table-cell">
								<?php echo $this->escape($item->access_level); ?>
							</td>
							<td class="small d-none d-md-table-cell">
								<?php echo LayoutHelper::render('joomla.content.language', $item); ?>
							</td>
							<td class="d-none d-md-table-cell">
								<?php echo (int) $item->id; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php // load the pagination. ?>
			<?php echo $this->pagination->getListFooter(); ?>

		<?php endif; ?>

		<input type="hidden" name="extension" value="<?php echo $extension; ?>">
		<input type="hidden" name="task" value="">
		<input type="hidden" name="boxchecked" value="0">
		<input type="hidden" name="forcedLanguage" value="<?php echo $app->input->get('forcedLanguage', '', 'CMD'); ?>">
		<?php echo HTMLHelper::_('form.token'); ?>

	</form>
</div>
