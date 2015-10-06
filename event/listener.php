<?php

/**
*
* @package phpBB Extension - Extension list
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tas2580\extlist\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'						=> 'page_header',
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper		$helper		Controller helper object
	* @param \phpbb\template			$template		Template object
	* @param \phpbb\user				$user		User object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}

	public function page_header($event)
	{
		$this->user->add_lang_ext('tas2580/extlist', 'common');
		$this->template->assign_vars(array(
			'U_EXTLIST'	=> $this->helper->route('tas2580_extlist_controller', array()),
		));
	}
}
