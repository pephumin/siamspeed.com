<?php
/**********************************************************************************
* Subs-BBCode-YouTube.php
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:
*	http://opensource.org/licenses/BSD-2-Clause
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
**********************************************************************************/
if (!defined('SMF')) 
	die('Hacking attempt...');

//=================================================================================
// BBCode Hook functions
//=================================================================================
function BBCode_YouTube_Settings(&$config_vars)
{
	$config_vars[] = array('int', 'youtube_default_width');
	$config_vars[] = array('int', 'youtube_default_height');
}

function BBCode_YouTube_LoadTheme()
{
	global $context, $settings;
	$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . $settings['default_theme_url'] . '/css/BBCode-YouTube.css" />';
	$context['allowed_html_tags'][] = '<iframe>';
}

function BBCode_YouTube_parameters()
{
	return array(
		'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'BBCode_YouTube_width'),
		'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'BBCode_YouTube_height'),
		'autoplay' => array('optional' => true, 'match' => '(1|yes|on|true)', 'validate' => 'BBCode_YouTube_autoplay'),
		'color' => array('optional' => true, 'match' => '(red|white)', 'validate' => 'BBCode_YouTube_color'),
		'theme' => array('optional' => true, 'match' => '(light|dark)', 'validate' => 'BBCode_YouTube_theme'),
		'loop' => array('optional' => true, 'match' => '(1|yes|on|true)', 'validate' => 'BBCode_YouTube_loop'),
		'start' => array('optional' => true, 'match' => '(\d+|\d+\:\d+)', 'validate' => 'BBCode_YouTube_start'),
		'end' => array('optional' => true, 'match' => '(\d+|\d+\:\d+)', 'validate' => 'BBCode_YouTube_end'),
		'privacy' => array('optional' => true, 'match' => '(1|yes|on|true)', 'validate' => 'BBCode_YouTube_privacy'),
		'controls' => array('optional' => true, 'match' => '(0|no|off|false|hide)', 'validate' => 'BBCode_YouTube_controls'),
		'showinfo' => array('optional' => true, 'match' => '(0|no|off|false|hide)', 'validate' => 'BBCode_YouTube_showinfo'),
	);
}

function BBCode_YouTube(&$bbc)
{
	// Since all the bbcodes use the same parameters, let's define them ONCE!
	$params = BBCode_YouTube_parameters();

	// Syntax: [youtube {params}]{URL}[/youtube]
	$bbc[] = array(
		'tag' => 'youtube',
		'type' => 'unparsed_content',
		'content' => '$1',
		'parameters' => $params,
		'validate' => 'BBCode_YouTube_URL',
		'disabled_content' => '$1',
	);

	// Syntax: [youtube]{URL}[/youtube]
	$bbc[] = array(
		'tag' => 'youtube',
		'type' => 'unparsed_content',
		'content' => '$1',
		'validate' => 'BBCode_YouTube_URL',
		'disabled_content' => '$1',
	);

	// Syntax: [yt {params}]{URL}[/yt]
	$bbc[] = array(
		'tag' => 'yt',
		'type' => 'unparsed_content',
		'content' => '$1',
		'parameters' => $params,
		'validate' => 'BBCode_YouTube_URL',
		'disabled_content' => '$1',
	);

	// Syntax: [yt]{URL}[/yt]
	$bbc[] = array(
		'tag' => 'yt',
		'type' => 'unparsed_content',
		'content' => '$1',
		'validate' => 'BBCode_YouTube_URL',
		'disabled_content' => '$1',
	);

	// Syntax: [yt_user {params}]{user name}[/yt_user]
	$bbc[] = array(
		'tag' => 'yt_user',
		'type' => 'unparsed_content',
		'content' => '$1',
		'parameters' => $params,
		'validate' => 'BBCode_YouTube_User',
		'disabled_content' => '$1',
	);

	// Syntax: [yt_user]{user name}[/yt_user]
	$bbc[] = array(
		'tag' => 'yt_user',
		'type' => 'unparsed_content',
		'content' => '$1',
		'validate' => 'BBCode_YouTube_User',
		'disabled_content' => '$1',
	);

	// Syntax: [yt_search {params}]{search spec}[/yt_search]
	$bbc[] = array(
		'tag' => 'yt_search',
		'type' => 'unparsed_content',
		'content' => '$1',
		'parameters' => $params,
		'validate' => 'BBCode_YouTube_Search',
		'disabled_content' => '$1',
	);

	// Syntax: [yt_search]{search spec}[/yt_search]
	$bbc[] = array(
		'tag' => 'yt_search',
		'type' => 'unparsed_content',
		'content' => '$1',
		'validate' => 'BBCode_YouTube_Search',
		'disabled_content' => '$1',
	);
}

function BBCode_YouTube_Button(&$buttons)
{
	global $txt;

	$buttons[count($buttons) - 1][] = array(
		'image' => 'youtube',
		'code' => 'youtube',
		'description' => $txt['youtube'],
		'before' => '[youtube]',
		'after' => '[/youtube]',
	);
}

//=================================================================================
// Parameter validation functions
//=================================================================================
function BBCode_YouTube_height($height)
{
	global $context;
	$context['bbc_youtube']['height'] = max(0, (int) $height);
}

function BBCode_YouTube_width($width)
{
	global $context;
	$context['bbc_youtube']['width'] = max(0, (int) $width);
}

function BBCode_YouTube_autoplay($autoplay)
{
	global $context;
	$context['bbc_youtube']['autoplay'] = 1;
}

function BBCode_YouTube_color($color)
{
	global $context;
	$context['bbc_youtube']['color'] = $color;
}

function BBCode_YouTube_theme($theme)
{
	global $context;
	$context['bbc_youtube']['theme'] = $theme;
}

function BBCode_YouTube_loop($loop)
{
	global $context;
	$context['bbc_youtube']['loop'] = 1;
}

function BBCode_YouTube_start($start)
{
	global $context;
	$minutes = 0;
	if (strpos($start, ':'))
		list($minutes, $start) = explode(':', $start);
	$context['bbc_youtube']['start'] = ($minutes * 60) + $start;
}

function BBCode_YouTube_end($end)
{
	global $context;
	$minutes = 0;
	if (strpos($end, ':'))
		list($minutes, $end) = explode(':', $end);
	$context['bbc_youtube']['end'] = ($minutes * 60) + $end;
}

function BBCode_YouTube_privacy($privacy)
{
	global $context;
	$context['bbc_youtube']['privacy'] = 1;
}

function BBCode_YouTube_controls($controls)
{
	global $context;
	$context['bbc_youtube']['controls'] = 1;
}

function BBCode_YouTube_showinfo($showinfo)
{
	global $context;
	$context['bbc_youtube']['showinfo'] = 1;
}

//=================================================================================
// YouTube and YT BBCode validation functions:
//=================================================================================
function BBCode_YouTube_URL(&$tag, &$data, &$disabled)
{
	global $txt, $context;

	// Do some preperation to avoid some issues within the code:
	$data = str_replace('&amp;', '&', strip_tags($data));

	// Start building the YouTube URL that we are going to show to the user:
	if (strpos($data, 'youtube-nocookie.com') !== false)
		$context['bbc_youtube']['privacy'] = 1;
	$server = (strpos($data, 'https://') !== false ? 'https://' : 'http://');
	$server = $server . 'www.youtube' . (isset($context['bbc_youtube']['privacy']) ? '-nocookie' : '') . '.com';

	// Figure out if what's been passed is a YouTube video URL or ID:
	if (($len = strlen($data)) == 11)
		$data = $server . '/embed/' . ($url = $data);
	elseif ($len == 18)
		$data = $server . '/embed?listType=playlist&list=' . ($url = $data);
	else
		$data = $server . '/' . ($url = BBCode_YouTube_Parse($data));

	// If the URL variable is empty, return link invalid to user....
	if (empty($url))
		$data = $txt['youtube_link_invalid'];
	// If the YouTube bbcode is disabled, create a simple link to the video:
	elseif (isset($disabled['youtube']))
		$data = '<a href=' . $data . '>' . $data . '</a>';
	// Otherwise, build the YouTube HTML string that we're going to use:
	else
		BBCode_YouTube_Link($data);

	// Remove the validation variables from the context array:
	unset($context['bbc_youtube']);
}

function BBCode_YouTube_User(&$tag, &$data, &$disabled)
{
	global $txt, $context;

	// Create the actual URL we are going to be using:
	$server = (strpos($data, 'https://') !== false ? 'https://' : 'http://');
	$server = $server . 'www.youtube' . (isset($context['bbc_youtube']['privacy']) ? '-nocookie' : '') . '.com';
	$data = $server . '/embed?listType=user_uploads&list=' . str_replace(" ", "+", strip_tags($data));

	// If the YouTube bbcode is disabled, create a simple link to the video:
	if (isset($disabled['youtube']))
		$data = '<a href=' . $data . '>' . $data . '</a>';
	// Otherwise, build the YouTube HTML string that we're going to use:
	else
		BBCode_YouTube_Link($data);

	// Remove the validation variables from the context array:
	unset($context['bbc_youtube']);
}

function BBCode_YouTube_Search(&$tag, &$data, &$disabled)
{
	global $txt, $context;

	// Create the actual URL we are going to be using:
	$server = (strpos($data, 'https://') !== false ? 'https://' : 'http://');
	$server = $server . 'www.youtube' . (isset($context['bbc_youtube']['privacy']) ? '-nocookie' : '') . '.com';
	$data = $server . '/embed?listType=search&list=' . str_replace(" ", "+", strip_tags($data));

	// If the YouTube bbcode is disabled, create a simple link to the video:
	if (isset($disabled['youtube']))
		$data = '<a href=' . $data . '>' . $data . '</a>';
	// Otherwise, build the YouTube HTML string that we're going to use:
	else
		BBCode_YouTube_Link($data);

	// Remove the validation variables from the context array:
	unset($context['bbc_youtube']);
}

//=================================================================================
// YouTube and YT BBCode link creation function:
//=================================================================================
function BBCode_YouTube_Link(&$data)
{
	global $context, $modSettings;
	
	// Set width or height with respect to aspect ratio if just one is set.  Set both if neither:
	if (!isset($context['bbc_youtube']['width']) && isset($context['bbc_youtube']['height']))
		$context['bbc_youtube']['width'] = floor($context['bbc_youtube']['height'] * 1.6);
	elseif (isset($context['bbc_youtube']['width']) && !isset($context['bbc_youtube']['height']))
		$context['bbc_youtube']['height'] = floor($context['bbc_youtube']['width'] * 0.625);
	$width = (isset($context['bbc_youtube']['width']) ? $context['bbc_youtube']['width'] : (!empty($modSettings['youtube_default_width']) ? $modSettings['youtube_default_width'] : 0));
	$height = (isset($context['bbc_youtube']['height']) ? $context['bbc_youtube']['height'] : (!empty($modSettings['youtube_default_height']) ? $modSettings['youtube_default_height'] : 0));

	// Process the rest of the parameters we've saved in the validation functions:
	if (isset($context['bbc_youtube']['autoplay']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'autoplay=1';
	if (isset($context['bbc_youtube']['color']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'color=' . $context['bbc_youtube']['color'];
	if (isset($context['bbc_youtube']['theme']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'theme=' . $context['bbc_youtube']['theme'];
	if (isset($context['bbc_youtube']['start']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'start=' . $context['bbc_youtube']['start'];
	if (isset($context['bbc_youtube']['end']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'end=' . $context['bbc_youtube']['end'];
	if (isset($context['bbc_youtube']['loop']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'loop=1';
	if (isset($context['bbc_youtube']['controls']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'controls=0';
	if (isset($context['bbc_youtube']['showinfo']))
		$data = $data . (strpos($data, '?') !== false ? '&' : '?') . 'showinfo=0';

	// Build the HTML string that we are going to display to the user:
	$data = '<div style="' . (!empty($width) ? 'max-width: ' . $width . 'px;' : '') . (!empty($height) ? ' max-height: ' . $height . 'px;' : '') . '"><div class="yt-wrapper"><iframe class="youtube-player" type="text/html" src="' . $data . '" allowfullscreen frameborder="0"></iframe></div></div>';
}

//=================================================================================
// Regular Expression function for URL validation:
//=================================================================================
function BBCode_YouTube_Parse($url)
{
	if (preg_match('#(/|/e/|/embed/|/p/|\?list=|\&list=)([\w-]{18})#i', $url, $matches))
	{
		parse_str(parse_url(str_replace('&amp;', '&', $url), PHP_URL_QUERY), $out);
		return ('embed?listType=playlist&list=' . $matches[2] . (isset($out['v']) ? '&v=' . $out['v'] : ''));
	}
	preg_match_all('#(/|/v/|/e/|/embed/|\?v=|\&v=)([\w-]{11})#i', $url, $matches);
	return (isset($matches[2][count($matches[2]) - 1]) ? 'embed/' . $matches[2][count($matches[2]) - 1] : false);
}

//=================================================================================
// Function to fix parameter order of the YouTube bbcode:
//=================================================================================
function BBCode_YouTube_Params(&$message, $pos, &$parameters)
{
	$match = substr($message, $pos - 1);
	$match = substr($match, 0, strpos($match, ']'));
	$params = explode(' ', $match);
	unset($params[0]);
	$order = array();
	$replace_str = $old = '';
	foreach ($params as $param)
	{
		if (strpos($param, '=') === false)
			$order[$old] .= ' ' . $param;
		else
			$order[$old = substr($param, 0, strpos($param, '='))] = substr($param, strpos($param, '=') + 1);
	}
	foreach ($parameters as $key => $ignore)
	{
		$replace_str .= (isset($order[$key]) ? ' ' . $key . '=' . $order[$key] : '');
		unset($order[$key]);
	}
	$message = str_replace($match, $replace_str, $message);
	return count($order) == 0;
}

//=================================================================================
// Function to auto-embed YouTube URLs:
//=================================================================================
function BBCode_YouTube_Embed(&$message, &$smileys, &$cache_id, &$parse_tags)
{
	$pattern = '~(?<=[\s>\.(;\'"]|^)(?:https?\:\/\/)?(?:www\.)?(youtube\.com|youtube-nocookie\.com|youtu\.be)/?(?:/[\w\-_\~%\.@!,\?&;=#(){}+:\'\\\\]*)*(/|/e/|/embed/|/p/|\?list=|\&list=)([\w-]{18})+\??[/\w\-_\~%@\?;=#}\\\\]?~';
	$message = preg_replace($pattern, '[youtube]$0[/youtube]', $message);
	$pattern = '~(?<=[\s>\.(;\'"]|^)(?:https?\:\/\/)?(?:www\.)?(youtube\.com|youtube-nocookie\.com|youtu\.be)/?(?:/[\w\-_\~%\.@!,\?&;=#(){}+:\'\\\\]*)*(/|/v/|/e/|/embed/|\?v=|\&v=)([\w-]{11})+\??[/\w\-_\~%@\?;=#}\\\\]?~';
	$message = preg_replace($pattern, '[youtube]$0[/youtube]', $message);
}

?>