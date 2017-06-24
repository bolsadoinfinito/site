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
define('DB_NAME', 'site');

/** MySQL database username */
define('DB_USER', 'wpuser');

/** MySQL database password */
define('DB_PASSWORD', 'b04sd34m1gs');

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
define('AUTH_KEY',         ')fG;RoCfw9WcW7|WUDgv8sL79%[8&T=%W^)15P~)}qfiq?f$Kd9T<.B;]hGqKk)9');
define('SECURE_AUTH_KEY',  'zZ9I7 #B0>{R7HH]p*Hh3Ofxl$4k@R2}!(yANGTsN@USot@rP/^;Ghvf}-}Aw9Nd');
define('LOGGED_IN_KEY',    'yBY$|1MpZ*_~+T(UX(odljR9%F#Gd8$zT*CLe9OH+^D6 |;NdQ4Wv(O/C9w}Sr=,');
define('NONCE_KEY',        '`MzM%VJ~bShjB#Bl/5`WwH/W|d&e#J=1ig6/(co8Hgyi<RTw4>M5p&u)Z<oAku?H');
define('AUTH_SALT',        '!{sis.(w575drJJv$&rCpqY$>^>*-*H_A9b}<.iT Q]A-*vwQ%/58m_8c4OcL74i');
define('SECURE_AUTH_SALT', 'eZV$TvEmP.&k)hc:EU.JxPr4@Pn5cIo %{Sk:H8%|jrUM6_IvX8*I)lIQ$fh/fUF');
define('LOGGED_IN_SALT',   '0Z=4@>m=J5:3{?3]!DP6>h(q}a%[^9(W?#e]H!3[waocL5C-eM[9+Ltyv5*77EA0');
define('NONCE_SALT',       ':_3X=-a])?v9Z1WU~P!qroDVU(xW/kUza8im5T`sT&Z[LzHz`n==}|9T@EVZ*k[3');

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
