<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0.14
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show right to left and the character set for ease of translating.
	echo '<!DOCTYPE html>
<html', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>';

	// The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
	echo '
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/bootstrap.css" />
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/all.css?fin20" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />';

	// Some browsers need an extra stylesheet due to bugs/compatibility issues.
	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
		if ($context['browser']['is_' . $cssfix])
			echo '
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

	// RTL languages require an additional stylesheet.
	if ($context['right_to_left'])
		echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

	// Here comes the JavaScript bits!
	echo '
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/popper.min.js"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/jquery.min.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/bootstrap.min.js?fin20"></script>
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/webslidemenu.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var txtnew = "', $txt['new'], '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

	echo '  
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

	// Please don't index these Mr Robot.
	if (!empty($context['robot_no_index']))
		echo '
	<meta name="robots" content="noindex" />';

	// Present a canonical url for search engines to prevent duplicate content in their indices.
	if (!empty($context['canonical_url']))
		echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';

	// Show all the relative links, such as help, search, contents, and the like.
	echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

	// If RSS feeds are enabled, advertise the presence of one.
	if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
		echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

	// If we're viewing a topic, these should be the previous and next topics, respectively.
	if (!empty($context['current_topic']))
		echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';

	// If we're in a board, or a topic for that matter, the index will be the board's index.
	if (!empty($context['current_board']))
		echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

	// Output any remaining HTML headers. (from mods, maybe?)
	echo $context['html_headers'];

	echo '
</head>
<body class="app sidebar-mini rtl">';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
	<div id="global-loader"></div>
<div class="page">
		<div class="page-main">
		<header class="p-header" id="header_ust">
			<!-- app-content-->
						<div class="p-2 d-block d-sm-none navbar-sm-search">
							<!-- Form -->
							<form class="navbar-search navbar-search-dark form-inline ml-lg-auto" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
								<div class="form-group mb-0">
									<div class="input-group input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-search"></i></span>
										</div><input type="text" name="search" class="form-control header-search" value="', $txt['forum_search'], '" onfocus="this.value = \'\';" onblur="if(this.value==\'\') this.value=\'', $txt['forum_search'], '\';" />';

				// Search within current topic?
				if (!empty($context['current_topic']))
				echo '
					<input type="hidden" name="topic" value="', $context['current_topic'], '" />';

				// If we're on a certain board, limit it to this board ;).
				elseif (!empty($context['current_board']))
				echo '
					<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '" />';

			echo '
									</div>
								</div>
							</form>
						</div>
						<!-- Top navbar -->';
						echo '
						<nav class="navbar navbar-top  navbar-expand-md navbar-dark" id="navbar-main">
							<div class="container">
								<a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
								<a class="navbar-brand" href="', $scripturl, '">', empty($context['header_logo_url_html_safe']) ? $context['forum_name'] : '<img src="' . $context['header_logo_url_html_safe'] . '" alt="' . $context['forum_name'] . '" class="navbar-brand-img main-logo"  />', '</a>
								<!-- Form -->
								<form class="search navbar-search navbar-search-dark form-inline ml-3  ml-auto" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
									<div class="search__wrapper pr-md-0 mr-md-2 pl-1">
									<input type="text" name="search" class="search__field" value="', $txt['forum_search'], '" onfocus="this.value = \'\';" onblur="if(this.value==\'\') this.value=\'', $txt['forum_search'], '\';" />
									<button type="submit" class="fa fa-search search__icon"></button>';

				// Search within current topic?
				if (!empty($context['current_topic']))
				echo '
					<input type="hidden" name="topic" value="', $context['current_topic'], '" />';

				// If we're on a certain board, limit it to this board ;).
				elseif (!empty($context['current_board']))
				echo '
					<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '" />';

			echo '
									</div>
								</form>
								<!-- User -->
								<!-- User -->
								<div class="navbar-nav align-items-center ">';
	
	                             // If the user is logged in, display stuff like their name, new messages, etc.
	if ($context['user']['is_logged'])
	{
	if ($context['allow_pm'])
		echo '
		<a class="nav-link p-navgroup-link d-none d-md-flex" href="', $scripturl, '?action=pm" data-toggle="tooltip" data-placement="bottom" title="', $txt['pm'], '"><i class="fa fa-envelope"></i><span class="badge badge-danger badge-pill noti-icon-badge">', $context['user']['messages'], '</span></a>';
        echo '
		<a  href="', $scripturl, '?action=profile" class="nav-link p-navgroup-link dropdown-toggle" data-toggle="dropdown">';
		if (!empty($context['user']['avatar']))
			echo '<img class="av rounded-circle" src="', $context['user']['avatar']['href'], '" alt="*"/>';
		else
			echo '<img class="av rounded-circle"  src="'.$settings['images_url'].'/noavatar.png" alt="*"/>';
		echo '
			
			<span class="user-name d-none d-sm-block float-right">', $context['user']['name'], ($context['user']['unread_messages'] == 0) ? '' : ' <span class="label label-primary visible-xs-inline">' . $context['user']['unread_messages'] . '</span>', ' <span class="caret"></span>
			</span></a>';
					
					echo '
 <div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="', $scripturl, '?action=profile"><span class="fa fa-user"></span> ', $txt['summary'], '</a>
					<a class="dropdown-item" href="', $scripturl, '?action=profile;area=forumprofile"><span class="fa fa-wrench"></span> ', $txt['forumprofile'], '</a>
					<a class="dropdown-item" href="', $scripturl, '?action=profile;area=account"><span class="fa fa-cog"></span> ', $txt['account'], '</a>
					<a class="dropdown-item" href="', $scripturl, '?action=unread"><span class="fa fa-list"></span> ', $txt['unread_topics_visit'], '</a>
					<a class="dropdown-item" href="', $scripturl, '?action=unreadreplies"><span class="fa fa-comment"></span> ', $txt['unread_replies'], '</a>
					<div class="dropdown-divider"></div>';

		echo '
		<a class="dropdown-item" href="', $scripturl, '?action=logout;' . $context['session_var'] . '=' . $context['session_id']. '"><span class="fa fa-sign-out"></span> ', $txt['logout'], '</a></div>';
	}
	// Otherwise they're a guest - this time ask them to either register or login - lazy bums...
	elseif (!empty($context['show_login_bar']))
	{
		echo '
		<div class="dropdown show">
			<a class="p-navgroup-link nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sign-in-alt"></i></a>
			<a class="p-navgroup-link nav-link" href="', $scripturl, '?action=register"><i class="fas fa-user-edit"></i></a>
				<div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
				<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/sha1.js"></script>
				<form id="guest_form" action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
					
					<input type="text" name="user" size="10" class="form-control input_text" /><br />
					<input type="password" name="passwrd" size="10" class="form-control input_password" /><br />
					<select name="cookielength">
						<option value="60">', $txt['one_hour'], '</option>
						<option value="1440">', $txt['one_day'], '</option>
						<option value="10080">', $txt['one_week'], '</option>
						<option value="43200">', $txt['one_month'], '</option>
						<option value="-1" selected="selected">', $txt['forever'], '</option>
					</select>
					<input type="submit" value="', $txt['login'], '" class="button_submit" /><br />';

		if (!empty($modSettings['enableOpenID']))
			echo '
					<br /><input type="text" name="openid_identifier" id="openid_url" size="25" class="input_text openid_login" />';

		echo '
					<input type="hidden" name="hash_passwrd" value="" /><input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				</form>
				</div>
				</div>';
	}

	echo '
	                            </div>
							</div>
						</nav>
						<div id="header">
	 <div class="container">
		<h1 class="forumtitle">';
	echo '
			', empty($settings['site_slogan']) ? '<img id="smflogo" src="' . $settings['images_url'] . '/smflogo.png" alt="Simple Machines Forum" title="Simple Machines Forum" />' : '<div id="siteslogan" class="floatright">' . $settings['site_slogan'] . '</div>', '
		</h1>
	</div>
						<div class="horizontal-main clearfix" id="headerMenuCollapse">
							<div class="horizontal-mainwrapper container clearfix">';

	// Show the menu here, according to the menu sub template.
	template_menu();

	echo '
		</div></div></div></header></div></div>';

	// The main content should go here.
	echo '
	<div id="content_section">
	<div class="container">';

	// Custom banners and shoutboxes should be placed here, before the linktree.

	// Show the navigation tree.
	theme_linktree();
}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
      </div></div>';

	// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	echo '
	<div id="footer_section"><div class="frame">
		<ul class="reset">
			<li class="copyright">', theme_copyright(), '| ' , $txt['wt_copyright'], '</li>
			<li><a id="button_xhtml" href="http://validator.w3.org/check?uri=referer" target="_blank" class="new_win" title="', $txt['valid_xhtml'], '"><span>', $txt['xhtml'], '</span></a></li>
			', !empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']) ? '<li><a id="button_rss" href="' . $scripturl . '?action=.xml;type=rss" class="new_win"><span>' . $txt['rss'] . '</span></a></li>' : '', '
			<li class="last"><a id="button_wap2" href="', $scripturl , '?wap2" class="new_win"><span>', $txt['wap2'], '</span></a></li>
		</ul>';

	// Show the load time?
	if ($context['show_load_time'])
		echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

	echo '
	</div></div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
	global $context, $settings, $options, $shown_linktree;

	// If linktree is empty, just return - also allow an override.
	if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
		return;

	echo '
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">';

	// Each tree item has a URL and name. Some may have extra_before and extra_after.
	foreach ($context['linktree'] as $link_num => $tree)
	{
		echo '
			<li class="breadcrumb-item"', ($link_num == count($context['linktree']) - 1) ? ' ' : '', '>';

		// Show the link, including a URL if it should have one.
		echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

		echo '
			</li>';
	}
	echo '
		</ol>
	</nav>';

	$shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
	<nav class="horizontalMenu clearfix">
	<div class="overlapblackbg"></div>
									<ul class="horizontalMenu-list">';

	foreach ($context['menu_buttons'] as $act => $button)
	{
		echo '
				<li id="button_', $act, '">
					<a class="', $button['active_button'] ? 'active ' : '', 'firstlevel" href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
						<span class="', isset($button['is_last']) ? 'last ' : '', 'firstlevel">', $button['title'], '</span>
					</a>';
		if (!empty($button['sub_buttons']))
		{
			echo '
					<ul class="sub-menu">
						<li aria-haspopup="true">
							<a  href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>', $button['title'], '</a>
						</li>';

			foreach ($button['sub_buttons'] as $childbutton)
			{
				echo '
						<li', !empty($childbutton['sub_buttons']) ? ' aria-haspopup="true"' : '', '>
							<a  href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
								', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '
							</a>';
				// 3rd level menus :)
				if (!empty($childbutton['sub_buttons']))
				{
					echo '
							<ul class="sub-menu">';

					foreach ($childbutton['sub_buttons'] as $grandchildbutton)
						echo '
								<li aria-haspopup="true">
									<a  href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
										', $grandchildbutton['title'], '
									</a>
								</li>';

					echo '
							</ul>';
				}

				echo '
						</li>';
			}
				echo '
					</ul>';
		}
		echo '
				</li>';
	}

	echo '
			</ul>
	</nav>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// List the buttons in reverse order for RTL languages.
	if ($context['right_to_left'])
		$button_strip = array_reverse($button_strip, true);

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><i class="fa fa-'.$value['text'].' fa-fw"></i> <span class="d-none d-sm-block float-right">' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="buttonlist', !empty($direction) ? ' float' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>
			<ul class="nav nav-pills">',
				implode('', $buttons), '
			</ul>
		</div>';
}

?>