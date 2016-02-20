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
define('DB_NAME', 'abril');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'admin');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'x<z=3{_Ovlvo|U0Ebe#],h(k*}Xr@^LOSU}-aaN8fWkFH{o0e+]Eyb~i>^D4wCq.');
define('SECURE_AUTH_KEY',  'qPobDEslETw6?O?VT$9RtWA@&tDLo.gU2aHq+bg,:e^JFi9Up;<0|H[:Tr)c4LtX');
define('LOGGED_IN_KEY',    '6HfL=Q9}YD5W0M}/}`s6+Ie;@M.{ Rm25V}sy7cBE|i-lzsGH|I?l.yAqc-|PI73');
define('NONCE_KEY',        'tvSdNFnGF8oHCW0C5s1:<2+unK*1UO?^y-n&9L}WH|qQVP9|z#r>v&^rz6=bY?.]');
define('AUTH_SALT',        '7fFRD6$Y|y+T}.Z}fd+{<+93 SV5pGvDHStDQt@!6Rqvz:r#eSF^#ax=@euu;V7d');
define('SECURE_AUTH_SALT', 'TL;lZJXWp<:oRo/os+/jFivP}<RIwj.z=P~X4W3VbuE|-fVFP36y@wICWHmtm2jh');
define('LOGGED_IN_SALT',   '11snfB/ABk0@HJYP|-?FQH`L=MhS +%bEy#L+u|_%y,hnC-IYbH+wcRB|SO0#50$');
define('NONCE_SALT',       'L:=|nj+/ID$*]T)BMOLP}7EcswQe~5!lC[i|j=){~r4y->`-u]nVUCp|oq!<&wIC');

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
