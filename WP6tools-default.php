<?php
/*
Plugin Name: Plugin de base 6-Design
Plugin URI: http://www.6-design.com/
Description: Base site administration 6-Design
Version: 0.1
Author: mOveo
Author URI: http://www.moveo.fr
License: Private
Text Domain: 6tools_domain

Copyright 2012 - 6-Design
*/


/**
 * Constante : Chemin absolu du plugin
 * @global string SIXTOOLS_DIR
 * @since 0.1
 */
define( 'SIXTOOLS_DIR', dirname(__FILE__) );



/**
 * Constante : Nom du fichier de base du plugin
 * @global string SIXTOOLS_BASENAME
 * @since 0.1
 */
define( 'SIXTOOLS_BASENAME', basename( SIXTOOLS_DIR ) );


/**
 * Constante : URL du plugin
 * @global string SIXTOOLS_URL
 * @since 0.1
 */
define( 'SIXTOOLS_URL', plugins_url( "/" . SIXTOOLS_BASENAME . "/") );


/**
 * Constante : Chemin absolu du repertoire de templates du plugin
 * @global string SIXTOOLS_TPL_DIR
 * @since 0.1
 */
define( 'SIXTOOLS_TPL_DIR', SIXTOOLS_DIR . '/templates' );


/**
 * Fonctions du plugin
 * Utilisées dans les templates
 * @since 0.1
 */
require_once SIXTOOLS_DIR . '/includes/WP6tools_plugin_functions.php' ;


/**
 * Classe pricipale du plugin
 * @since 0.1
 */
require_once 'WP6tools.php' ;


?>