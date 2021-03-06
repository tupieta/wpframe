<?php

// Setup the YAML parser, load some yaml files
require_once( dirname( __FILE__ ) . './../vendor/php/yaml/lib/sfYamlParser.php' );
$yaml     = new sfYamlParser();
$project  = $yaml->parse( file_get_contents( dirname( __FILE__ ) . './../config/project.yml' ) );
$database = $yaml->parse( file_get_contents( dirname( __FILE__ ) . './../config/database.yml' ) );

// ===================================================
// Setup the dev, staging, and production environments
// ===================================================
$urlParts = explode( '.', $_SERVER['HTTP_HOST'] );
if ( $urlParts[0] == 'dev' ) {
	// Local dev
	define( 'WP_STAGE',   'dev' );
	define( 'WP_HOME',    'http://dev.' . $project['application']['domain'] );
	define( 'WP_SITEURL', 'http://dev.' . $project['application']['domain'] . '/wp' );

	// Show errors
	ini_set( 'display_errors', 1 );
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_DISPLAY', true );

	foreach ( $database['dev'] as $db_variable => $value ) {
		define( ( 'DB_' . strtoupper( $db_variable ) ), $value );
	}
} elseif ( $urlParts[0] == 'staging' ) {
	// Staging
	define( 'WP_STAGE', 'staging' );
	define( 'WP_HOME',    'http://staging.' . $project['application']['domain'] );
	define( 'WP_SITEURL', 'http://staging.' . $project['application']['domain'] . '/wp' );

	// Show errors
	ini_set( 'display_errors', 1 );
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_DISPLAY', true );

	foreach ( $database['staging'] as $db_variable => $value ) {
		define( ( 'DB_' . strtoupper( $db_variable ) ), $value );
	}
} else {
	// Production
	define( 'WP_STAGE', 'production' );
	define( 'WP_HOME',    'http://www.' . $project['application']['domain'] );
	define( 'WP_SITEURL', 'http://www.' . $project['application']['domain'] . '/wp' );

	// Hide errors
	ini_set( 'display_errors', 0 );
	define( 'WP_DEBUG', false );
	define( 'WP_DEBUG_DISPLAY', false );

	foreach ( $database['production'] as $db_variable => $value ) {
		define( ( 'DB_' . strtoupper( $db_variable ) ), $value );
	}
}

// ==============
// Misc. Settings
// ==============
define( 'WP_POST_REVISIONS', 8 );

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define('AUTH_KEY',         'Your');
define('SECURE_AUTH_KEY',  'salts');
define('LOGGED_IN_KEY',    'go');
define('NONCE_KEY',        'in');
define('AUTH_SALT',        'place');
define('SECURE_AUTH_SALT', 'of');
define('LOGGED_IN_SALT',   'this.');
define('NONCE_SALT',       'Thanks!');

// ============
// Table prefix
// ============
$table_prefix  = 'wp_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ===========
// Hide errors
// ===========
ini_set( 'display_errors', 0 );
define( 'WP_DEBUG_DISPLAY', false );

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
