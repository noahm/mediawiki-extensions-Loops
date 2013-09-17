<?php

/**
 * 'Loops' is a MediaWiki extension expanding the parser with loops functions
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:Loops
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:Loops
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Loops
 * 
 * @version: 0.5
 * @license: GNU GPL v2 or higher
 * @author:  David M. Sledge
 * @author:  Daniel Werner < danweetz@web.de >
 *
 * @file Loops.php
 * @ingroup Loops
 */

if ( ! defined( 'MEDIAWIKI' ) ) { die( ); }
 
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'author'         => array( 'David M. Sledge', '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]', 'Noah Manneschmidt, Curse Inc.' ),
	'name'           => 'Loops',
	'version'        => '0.5',
	'descriptionmsg' => 'loops-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Loops',
);

$_dir = dirname(__FILE__);

// language files:
$wgExtensionMessagesFiles['Loops'     ] = $_dir . '/Loops.i18n.php';
$wgExtensionMessagesFiles['LoopsMagic'] = $_dir . '/Loops.i18n.magic.php';

// hooks registration:
$wgHooks['ParserFirstCallInit'][] = 'ExtLoops::init';
$wgHooks['ParserLimitReport'  ][] = 'ExtLoops::onParserLimitReport';
$wgHooks['ParserClearState'   ][] = 'ExtLoops::onParserClearState';

// autoloader registration:
$wgAutoloadClasses['ExtLoops'] = $_dir . '/Loops.body.php';

unset($_dir);

// define the settings:

/**
 * Allows to define which functionalities provided by 'Loops' should be enabled for the wiki.
 * If extension 'Variables' is not installed, '#loop', '#forargs' and '#fornumargs' will be
 * disabled automatically.
 * 
 * @example
 * # enable '#while' and '#dowhile' parser functions only:
 * $egLoopsEnabledFunctions = array( 'while', 'dowhile' );
 * 
 * @since 0.4
 * @var array
 */
if (!isset($egLoopsEnabledFunctions) or !is_array($egLoopsEnabledFunctions)) {
	$egLoopsEnabledFunctions = array( 'while', 'dowhile', 'loop', 'forargs', 'fornumargs' );
}

/**
 * Configuration variable defining maximum allowed number of loops ('-1' => no limit).
 * '#forargs' and '#fornumargs' are not limited by this.
 *
 * @var int
 */
if (!isset($egLoopsMax)) {
	$egLoopsMax = 100;
}
