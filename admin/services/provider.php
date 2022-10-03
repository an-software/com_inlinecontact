<?php
/**
 * @package         Joomla.Administrator
 * @subpackage      com_inlinecontact
 *
 * @copyright   (C) Alexander Niklaus. All rights reserved.
 * @license         GNU General Public License version 2 or later
 * @link            https://an-software.net
 */

defined('_JEXEC') or die;

use ANSoftware\Component\Inlinecontact\Administrator\Extension\InlinecontactComponent;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The contact service provider.
 *
 * @since  1.0.0
 */
return new class implements ServiceProviderInterface {
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function register(Container $container)
	{
		$container->registerServiceProvider(new MVCFactory('\\ANSoftware\\Component\\Inlinecontact'));
		$container->registerServiceProvider(new ComponentDispatcherFactory('\\ANSoftware\\Component\\Inlinecontact'));

		$container->set(
			ComponentInterface::class,
			function (Container $container) {
				$component = new InlinecontactComponent($container->get(ComponentDispatcherFactoryInterface::class));
				$component->setMVCFactory($container->get(MVCFactoryInterface::class));

				return $component;
			}
		);
	}
};
