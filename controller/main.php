<?php
/**
*
* @package phpBB Extension - Extension list
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tas2580\extlist\controller;

class main
{
	/* @var \phpbb\auth\auth */
	protected $auth;
	/* @var \phpbb\config\config */
	protected $config;
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
	* @param \phpbb\config\config		$config		Config
	* @param \phpbb\controller\helper		$helper		Controller helper object
	* @param \phpbb\template\template	$template		Template object
	* @param \phpbb\user				$user		User object
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\extension\manager $phpbb_extension_manager)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
	}

	/**
	* Controller for route /paypal
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function handle()
	{
		// check auth
		if (!$this->auth->acl_get('u_extlist_view'))
		{
			trigger_error('NOT_AUTHORISED');
		}

		$this->user->add_lang_ext('tas2580/extlist', 'common');

		foreach ($this->phpbb_extension_manager->all_enabled() as $name => $location)
		{
			$md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager($name, $this->template);
			$meta = $md_manager->get_metadata('all');

			$authors_list = array();
			foreach ($meta['authors'] as $author)
			{
				$authors_list[] = empty($author['homepage']) ? $author['name'] : '<a href="' . $author['homepage'] . '">' . $author['name']  . '</a>';
			}

			$this->template->assign_block_vars('extension_list', array(
				'NAME'			=> $meta['extra']['display-name'],
				'DESCRIPTION'		=> $meta['description'],
				'VERSION'			=> $meta['version'],
				'AUTHORS'		=> implode(', ', $authors_list),
			));
		}
		return $this->helper->render('extlist_body.html', $this->user->lang['EXTLIST']);
	}
}
