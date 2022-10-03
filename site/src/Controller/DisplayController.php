<?php
/**
 * @package         Joomla.Site
 * @subpackage      com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus
 * @license         GNU General Public License version 2 or later
 * @link            https://an-software.net
 */

namespace ANSoftware\Component\Inlinecontact\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use function defined;

/**
 * InlineContact Component Controller
 *
 * @since  1.0.0
 */
class DisplayController extends BaseController
{

	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $default_view = 'select';


	/**
	 * @param   array                         $config   An optional associative array of configuration settings.
	 *                                                  Recognized key values include 'name', 'default_task', 'model_path', and
	 *                                                  'view_path' (this list is not meant to be comprehensive).
	 * @param   MVCFactoryInterface|null      $factory  The factory.
	 * @param   CMSApplication|null           $app      The Application for the dispatcher
	 * @param   \Joomla\CMS\Input\Input|null  $input    The Input object for the request
	 *
	 * @throws \Exception
	 * @since   1.0.0
	 */
	public function __construct($config = array(), MVCFactoryInterface $factory = null, $app = null, $input = null)
	{
		// InlineContact frontpage Editor contacts proxying.
		$input               = Factory::getApplication()->input;
		$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		parent::__construct($config, $factory, $app, $input);
	}

}
