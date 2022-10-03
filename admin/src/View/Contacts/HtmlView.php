<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license         GNU General Public License version 2 or later
 * @link            https://an-software.net
 */

namespace ANSoftware\Component\Inlinecontact\Administrator\View\Contacts;

\defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Contact\Administrator\View\Contacts\HtmlView as BaseHtmlView;

/**
 * View class for a list of contacts.
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
		$templateKey     = 'stemplates';
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
