<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'stroyka_tek');

/** MySQL database username */
define('DB_USER', 'stroyka_root');

/** MySQL database password */
define('DB_PASSWORD', '#OIUPuqy0d43');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'y7?5z$SY)`tl%S7@E3&53Yd-MX~_3;K@or^3Ev6/IzCTtc?<m2FzYJ-:^xjq13Pw');
define('SECURE_AUTH_KEY',  'p?;ODoM,hM)q+RK.iT/D%hyy8p|>+3=40$W<g**|ZGkEv|8j#b(@EYgc1*SFCCK0');
define('LOGGED_IN_KEY',    'h!|,LE#SCUb5&X`1|S4U6NW~27^uY*v[|S~~_`pCb<FrrqFN1uXSlG;Tget[C^Kv');
define('NONCE_KEY',        '.%y>{Q-^DZqO6rws*F3$Wd&Nd$5?JT.]+WuF91e-[uvrYBX/ez*_GgBc7@nPq3=]');
define('AUTH_SALT',        'dbj&QJ([oqj7=G+tRXRd4PC8J)+64=_LNgf]9Yc8c7kAcs0RIYQCo!@4v0FO}&Yv');
define('SECURE_AUTH_SALT', '$n%Zs@B)1TCivwQgWRi%An*y+4S [DwRf]m$A#UyTCgKPSRdy;:3#_oU1B7{9g49');
define('LOGGED_IN_SALT',   '%-t~ &nQ~mZ(cx-I|JE@^lbK<hS=jaKGQ,-HS|ObMUnt og{1`-d8!(KZ(8@Z`!D');
define('NONCE_SALT',       '<&3t{~cTf o1FOl &HQ1|eASXA9mu>Mm)g9Sa!GTo~p<CIU[=9K#.tZTBG__[{yh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');


/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');