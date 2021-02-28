<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

#define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/content' );
#define( 'WP_CONTENT_URL', 'http://97.200.97.247:81/content' );

#define( 'WP_PLUGIN_DIR', dirname(__FILE__) . '/content/plugins' );
#define( 'WP_PLUGIN_URL', 'http://97.200.97.247:81/content/plugins' );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'myanmarsme');

/** MySQL database username */
define('DB_USER', 'myanmar_user');

/** MySQL database password */
define('DB_PASSWORD', 'myanmar!12x');

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
/*define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');*/
define('AUTH_KEY',         'mj7{L`vPG`)||H(~toaUMU7)}bt..i>WLo32)XYclD3Nkrc%)$$Oap2u4{*x(Gdp');
define('SECURE_AUTH_KEY',  '_=W4UWDg^B3w3_y$L?c3`JxrP*M9yrqw:~>L% -)TA9 :uW/ N&YkSbSsS._;j!C');
define('LOGGED_IN_KEY',    'W+i^{uwj^n;HodS<x8j{Kt[=5[;E $<#+VmZ(;F*.u;e0%9CB+:KpnA-U9dq0>g|');
define('NONCE_KEY',        'n=@MW[=u>3&|U+zGpVzRX?IL+v{%GDozE<)jT63y!)|,<.ypH#zj|+q|#?75$2}P');
define('AUTH_SALT',        'ftsdBc+}fp-BheZ L}+M4N02Cc^|:YsCaXwNY~U/u4Q==_?HoC.Xz1Tas7Wk.<cl');
define('SECURE_AUTH_SALT', 'bn{PQ.*AE>}vc_6SG#BvD||VT,;a)q3{9o<qwUhkF}+}|e^n(3oPgU-@7#K*W;=T');
define('LOGGED_IN_SALT',   'd#Be3-!y++77SiOp%^:,XDXooX62C}~L%,,{]p[# +n@q-b+?}KHjv.^)/6UXPe4');
define('NONCE_SALT',       'C`s><M=(kdl]v_h>K`Zm+nR*iM@c:u=(!cM.&zkSd/23g,z_T_wA-!d_qQsx]QI;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
