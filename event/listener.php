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
			'core.permissions'						=> 'permissions',
		);
	}

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth			$auth		Auth object
	* @param \phpbb\controller\helper		$helper		Controller helper object
	* @param \phpbb\template			$template		Template object
	* @param \phpbb\user				$user		User object
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}

	/*
	 * Add permissions
	 */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions += array(
			'u_extlist_view'		=> array(
				'lang'		=> 'ACL_U_EXTLIST_VIEW',
				'cat'		=> 'misc'
			),
		);
		$event['permissions'] = $permissions;
	}

	public function page_header($event)
	{
		if ($this->auth->acl_get('u_extlist_view'))
		{
			$this->user->add_lang_ext('tas2580/extlist', 'common');
			$this->template->assign_vars(array(
				'U_EXTLIST'	=> $this->helper->route('tas2580_extlist_controller', array()),
			));
		}
	}
}
