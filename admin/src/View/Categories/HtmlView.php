<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_categories
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license     GNU General Public License version 2 or later
 * @link        https://an-software.net
 */

namespace ANSoftware\Component\Inlinecontact\Administrator\View\Categories;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Categories\Administrator\View\Categories\HtmlView as BaseHtmlView;
use function defined;

/**
 * Categories view class for the Category package.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{

	/**
	 * @var array
	 *
	 * @since 1.0.1
	 */
	protected $selectedTemplate;

	/**
	 * @var array
	 *
	 * @since 1.0.1
	 */
	protected $sortMode;

	/**
	 * @var array
	 *
	 * @since 1.0.1
	 */
	protected $featuredMode;

	/**
	 * @var array contains list of available templates
	 *
	 * @since 1.0.0
	 */
	protected $templates;

	/**
	 * @param $tpl
	 *
	 *
	 * @throws Exception
	 * @since 1.0.0
	 */
	public function display($tpl = null)
	{
		$app = Factory::getApplication();
		$plugin = PluginHelper::getPlugin('content', 'inlinecontact');

		$this->selectedTemplate = $app->input->getInt('ictemplate',0);
		$this->sortMode = $app->input->getInt('icsort',0);
		$this->featuredMode = $app->input->getInt('icfeatured',0);

		$templateKey     = 'templates';
		$this->templates = [];
		$params          = json_decode($plugin->params);
		if (is_object($params) && property_exists($params, $templateKey) && is_object($params->$templateKey))
		{
			foreach ($params->$templateKey as $key => $template)
			{
				$key                   = intval(str_replace($templateKey, '', $key));
				$this->templates[$key] = $template->name;
			}
		}

		parent::display($tpl);
	}

}
