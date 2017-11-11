<?php

// Initialize the template... mainly little settings.
function template_init()
{
  global $context, $settings, $options, $txt;
  $settings['use_default_images'] = 'never';
  $settings['doctype'] = 'xhtml';
  $settings['theme_version'] = '2.0';
  $settings['use_tabs'] = true;
  $settings['use_buttons'] = true;
  $settings['separate_sticky_lock'] = true;
  $settings['strict_doctype'] = false;
  $settings['message_index_preview'] = false;
  $settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
  global $context, $settings, $options, $scripturl, $txt, $modSettings;

  $adsense = "1";
  if (($_SERVER['REQUEST_URI'] == "/index.php?action=login") || ($_SERVER['REQUEST_URI'] == "/index.php?action=login2")) { $adsense = "0"; }
  else if (($context['current_action'] == "login") || ($context['current_action'] == "login2")) { $adsense = "0"; }
  else if ((isset($context['error_message'])) || (isset($context['error_title']))) { $adsense = "0"; }

  // Show right to left and the character set for ease of translating.
  echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml"
      lang="th">
<head>
<meta charset="', $context['character_set'], '">';

  // The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
  echo '
  <link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/bootstrap.css?fin20" />
  <link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/font-awesome.css?fin20" />
  <link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />';
  //<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/normalize.css?fin20" />
  //<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700italic,700,800,800italic" />

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
  <script type="text/javascript" src="', $settings['theme_url'], '/scripts/jquery-2.2.1.js?fin20"></script>
  <script type="text/javascript" src="', $settings['theme_url'], '/scripts/exodus.js?fin20"></script>
  <script type="text/javascript" src="', $settings['theme_url'], '/scripts/bootstrap.min.js?fin20"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $("input[type=button]").attr("class", "btn btn-default btn-sm");
    $(".button_submit").attr("class", "btn btn-info btn-sm");
    $("#advanced_search input[type=\'text\'], #search_term_input input[type=\'text\']").removeAttr("size");
    $(".table_grid").addClass("table table-striped");
    $("img[alt=\'', $txt['new'], '\'], img.new_posts").replaceWith("<span class=\'label label-warning\'>', $txt['new'], '</span>");
    $("#profile_success").removeAttr("id").removeClass("windowbg").addClass("alert alert-success");
    $("#profile_error").removeAttr("id").removeClass("windowbg").addClass("alert alert-danger");
  });
  </script>
  <script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
  <script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
  <script type="text/javascript"><!-- // --><![CDATA[
    var smf_theme_url = "', $settings['theme_url'], '";
    var smf_default_theme_url = "', $settings['default_theme_url'], '";
    var smf_images_url = "', $settings['images_url'], '";
    var smf_scripturl = "', $scripturl, '";
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
  <meta name="description" content="', !empty($context['meta_description']) ? $context['meta_description'] : $context['page_title_html_safe'], '">', !empty($context['meta_keywords']) ? '
  <meta name="keywords" content="' . $context['meta_keywords'] . '">' : '', '
  <title>', $context['page_title_html_safe'], '</title>
  <meta name="author" content="Phumin Chesdmethee">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-site-verification" content="7bllBuZtoI1JWZ9ae1utS6KOyfZUhaV9pI31nq6aZMM">';

  echo '
  <meta property="og:site_name" content="', $context['forum_name'], '">
  <meta property="og:title" content="', $context['page_title_html_safe'],'">
  <meta property="og:type" content="article" />
  <meta property="og:image" content="', $settings['theme_url'], '/images/ssp-small.jpg" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="600" />
  <meta property="og:image:height" content="315" />
  ', !empty($context['canonical_url']) ? '<meta property="og:url" content="'. $context['canonical_url'].'">' : '','
  <meta property="og:description" content="',!empty($context['meta_description']) ? $context['meta_description'] : $context['page_title_html_safe'],'">
  <meta property="fb:app_id" content="326787037445447" />';
  //<meta property="fb:admins" content="1072774422" />

  echo '
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
  include_once("API/googleAnalytics");
  if ($adsense == "1") { include_once("API/googleAdSense-PageLevel"); }
  // include_once("API/pixel");

  echo '
  <style type="text/css">
  .stick-top-left {
    top: 0;
    left: 0;
    position: fixed;
    z-index: 999;
  }
  @media (min-width: 768px)
  {
    .container {
      width: ' . $settings['forum_width'] . ';
    }
  }
  </style>
</head>
<body>
  <img src="/Themes/exodus/images/black-ribbon.png" class="stick-top-left" alt="ทีมงาน siamspeed.com ขอน้อมรำลึกในพระมหากรุณาธิคุณของพ่อหลวง และขอกราบน้อมเกล้าฯส่งเสด็จสู่สวรรคาลัย">';
// include_once("API/facebookSDK");
if ($adsense == "1") { include_once("API/googleAdSense1"); }
}

function template_body_above()
{
  global $context, $settings, $options, $scripturl, $txt, $modSettings;

  echo'
<div class="container">
  <div id="topbar">
    <ul class="nav navbar-nav pull-left">';
      if($context['user']['is_logged'])
      {
        echo'
        <li class="sign-out"><a href="' , $scripturl , '?action=logout;sesc=', $context['session_id'], '"><i class="fa fa-sign-out visible-xs"></i><span>', $txt['logout'] ,'</span></a></li>';
      }
      else
      {
        echo'
        <li class="sign-in dropdown">
          <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-sign-in visible-xs"></i><span>', $txt['login'] ,'</span></a>
          <ul class="dropdown-menu">
            <li>
              <form id="guest_form" action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
                <input type="text" name="user" size="10" class="input_text" placeholder="', $txt['user'], '" />
                <input type="password" name="passwrd" size="10" class="input_password" placeholder="', $txt['password'], '" /> <br /><span><font style="color: #fff; text-transform: uppercase; font-weight: lighter;font-size: 12px;">REMEMBER ME?&nbsp;</font></span><input type="checkbox" name="cookieneverexp" class="input_check" onclick="this.form.cookielength.disabled = this.checked;">
                <input type="submit" value="" />
                <input type="hidden" name="hash_passwrd" value="" /><input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
              </form>
            </li>
          </ul>
        </li>
        <li class="register"><a href="' , $scripturl , '?action=register"><i class="fa fa-key visible-xs"></i><span>', $txt['register'] ,'</span></a></li>';
      }
      echo'
    </ul>
    <div class="pull-right">
        <form id="search_form" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '" class="search-form hidden-xs">
           <div class="form-group has-feedback">
            <label for="search" class="sr-only">', $txt['search'], '</label>
            <input type="text" class="form-control" name="search" id="search" placeholder="', $txt['search'], '...">
              <span class="fa fa-search form-control-feedback"></span>
          <input type="hidden" name="advanced" value="0" />';
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
      <ul class="nav navbar-nav pull-left visible-xs">
        <li class="search"><a href="' , $scripturl , '?action=search"><i class="fa fa-search visible-xs"></i></a></li>
      </ul>
    </div>
    <div id="logo"><a href="', $scripturl, '"><img src="' , !empty($context['header_logo_url_html_safe']) ? $context['header_logo_url_html_safe'] : $settings['images_url'] . '/logo.png' , '" alt="' . $context['forum_name'] . '" /></a></div>
  </div>
  <header>';
    // Show a random news item? (or you could pick one from news_lines...)
    if (!empty($settings['enable_news']))
      echo '
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 floatleft">
          <p class="text-left">', $txt['news'], ': ', $context['random_news_line'], '</p>
          <br>
        </div>';

    if($context['user']['is_logged'])
    {
      echo'

          <div class="user">
          <img class="avatar img-circle img-thumbnail floatright" src="', !empty($context['user']['avatar']['href']) ? $context['user']['avatar']['href'] : $settings['images_url']. '/noavatar.png' ,'" alt="*" />
          <a class="h4" href="', $scripturl , '?action=profile">', $context['user']['name'], '</a>
          <a href="', $scripturl, '?action=profile;area=forumprofile">', $txt['forumprofile'], '</a><br>
          <a href="', $scripturl, '?action=profile;area=account">', $txt['account'], '</a><br>
          <a href="', $scripturl, '?action=unread">', $txt['unread_topics_visit'], '</a><br>
          <a href="', $scripturl, '?action=unreadreplies">', $txt['unread_replies'], '</a><br>';
          // Is the forum in maintenance mode?
          if ($context['in_maintenance'] && $context['user']['is_admin'])
            echo '
              <div class="h5">', $txt['maintain_mode_on'], '</div>';
          // Are there any members waiting for approval?
  //        if (!empty($context['unapproved_members']))
  //          echo '
  //            <div class="h5">', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' <a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve">', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], '</a> ', $txt['approve_members_waiting'], '</div>';
  //        if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
  //          echo '
  //            <div class="h5"><a href="', $scripturl, '?action=moderate;area=reports">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</a></div>';
          echo'

        </div>';
    }

    echo'
  </header>';

  template_menu();
  theme_linktree();

  // The main content should go here.
  echo '
  <div id="content_section">
    <div id="main_content_section">';

  // Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below()
{
  global $context, $settings, $options, $scripturl, $txt, $modSettings;

  echo '
    </div>';

    // Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
    echo '
    <footer>
      <ul class="social">';
        if(!empty($settings['st_facebook_username']))
        echo'
        <li>
          <a href="http://www.facebook.com/', $settings['st_facebook_username'] ,'" target="_blank"><i class="fa fa-facebook fa-2x"></i></a>
        </li>';
        if(!empty($settings['st_twitter_username']))
        echo'
        <li>
          <a href="http://www.twitter.com/', $settings['st_twitter_username'] ,'" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>
        </li>';
        if(!empty($settings['st_youtube_username']))
        echo'
        <li>
          <a href="http://www.youtube.com/user/', $settings['st_youtube_username'] ,'" target="_blank"><i class="fa fa-youtube fa-2x"></i></a>
        </li>';
        if(!empty($settings['st_rss_url']))
        echo'
        <li>
          <a href="', $settings['st_rss_url'] ,'" target="_blank"><i class="fa fa-rss fa-2x"></i></a>
        </li>';
        echo'
      </ul>
      <ul class="reset">
        <li class="copyright">', theme_copyright(), '</li>
        <li class="copyright">Designed by <a href="/index.php?action=profile;u=2">sinbad</a></li>
        <li class="copyright">', !empty($settings['st_custom_copyright']) ? $settings['st_custom_copyright'] : $context['forum_name'] . ' &copy;' , '</li>
      </ul>';

    // Show the load time?
    if ($context['show_load_time'])
      echo '
      <p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

    echo '
    </footer>
  </div>
</div>';
}

function template_html_below()
{
  global $context, $settings, $options, $scripturl, $txt, $modSettings;

  $adsense = "1";
  if (($_SERVER['REQUEST_URI'] == "/index.php?action=login") || ($_SERVER['REQUEST_URI'] == "/index.php?action=login2")) { $adsense = "0"; }
  else if (($context['current_action'] == "login") || ($context['current_action'] == "login2")) { $adsense = "0"; }
  else if ((isset($context['error_message'])) || (isset($context['error_title']))) { $adsense = "0"; }

  if ($adsense == "1") { include_once("API/googleAdSense2"); }
  echo '
</body>
</html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
  global $context, $settings, $options, $shown_linktree, $scripturl;

  // If linktree is empty, just return - also allow an override.
  if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
    return;

  echo '
    <ol class="breadcrumb">
      <li><a href="' , $scripturl , '"><i class="fa fa-home"></i></a></li>';

  // Each tree item has a URL and name. Some may have extra_before and extra_after.
  foreach ($context['linktree'] as $link_num => $tree)
  {
    echo '
      <li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

    // Show the link, including a URL if it should have one.
    echo $settings['linktree_link'] && isset($tree['url']) ? '
        <a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

    echo '
      </li>';
  }
  echo '
    </ol>';

  $shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
  global $context, $settings, $options, $scripturl, $txt;

  echo '
    <nav class="navbar navbar-default">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="nav navbar-nav">';

    foreach ($context['menu_buttons'] as $act => $button)
    {
      echo '
          <li id="button_', $act, '" class="', $button['active_button'] ? 'active ' : '', '', !empty($button['sub_buttons']) ? 'dropdown' : '', '">
            <a ', !empty($button['sub_buttons']) ? 'class="dropdown-toggle"' : '', ' href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '', !empty($button['sub_buttons']) ? ' data-toggle="dropdown"' : '', '>
              <span class="', isset($button['is_last']) ? 'last ' : '', 'firstlevel">', $button['title'], '</span>
            </a>';
      if (!empty($button['sub_buttons']))
      {
        echo '
            <ul class="dropdown-menu">';

        foreach ($button['sub_buttons'] as $childbutton)
        {
          echo '
              <li>
                <a href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
                  <span', isset($childbutton['is_last']) ? ' class="last"' : '', '>', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '</span>
                </a>';
          // 3rd level menus :)
          if (!empty($childbutton['sub_buttons']))
          {
            echo '
                <ul>';

            foreach ($childbutton['sub_buttons'] as $grandchildbutton)
              echo '
                  <li>
                    <a href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
                      <span', isset($grandchildbutton['is_last']) ? ' class="last"' : '', '>', $grandchildbutton['title'], '</span>
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
      </div>
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
        <li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><i class="fa fa-'.$key.' fa-fw"></i><span>' . $txt[$value['text']] . '</span></a></li>';
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
