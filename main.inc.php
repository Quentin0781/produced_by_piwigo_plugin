<?php
/*
Plugin Name: Show photo produced by
Version: 1.0.1
Description: produced by photo
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=790
Author: plg
Author URI: http://le-gall.net/pierrick
*/

if (!defined('PHPWG_ROOT_PATH'))
{
  die('Hacking attempt!');
}

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+

global $prefixeTable;

//defined('SPI_ID') or define('SPI_ID', basename(dirname(__FILE__)));
defined('PRODUCED_BY_ID') or define('PRODUCED_BY_ID', basename(dirname(__FILE__)));

//define('SPI_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
define('PRODUCED_BY_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

//define('SPI_VERSION', '2.8.a');
define('PRODUCED_BY_VERSION', '1.0.1');


// init the plugin
add_event_handler('init', 'produced_by_init');
/**
 * plugin initialization
 *   - load language
 */
function produced_by_init()
{
  if (script_basename() == 'picture')
  {
    // "Downloads" is a key already available in admin.lang.php
    load_language('admin.lang');
  }
}


add_event_handler('loc_end_picture', 'produced_by_end_picture');
function produced_by_end_picture()
{
  global $template, $picture;

  $template->set_prefilter('picture', 'produced_by_picture_prefilter');

  $template->assign(
    array(
      'IMAGE_PRODUCED_BY' => $picture['current']['produced_by'],
      )
    );
}

function produced_by_picture_prefilter($content, &$smarty)
{
  $search = '{if $display_info.created_on and isset($INFO_CREATION_DATE)}';
  
  $replace = '
	<div id="ImageId" class="imageInfo">
		<dt>{"Produced by"}</dt>
		<dd>{$IMAGE_PRODUCED_BY}</dd>
	</div>
'.$search;
  
  $content = str_replace($search, $replace, $content);

  return $content;
}
?>
