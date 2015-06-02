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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpblog');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', '3vgm394k4x');

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
define('AUTH_KEY',         ']7Lmh(Pp2{GQ-{Z0+Rpn/]~a3=P,Xl1F7+x]< 1/JR91Kk|e1SA0~03C-+0PCp6}');
define('SECURE_AUTH_KEY',  'i=5e{Yu]2H4Ax^P8+ZWB2F#zue(`d10p_(V@!fZsefX8}P@d>K.i 0I{!Z#H|xdM');
define('LOGGED_IN_KEY',    'M([}) K2{Q+S2)Aw`Ym[if(C9R.t~B!bI/gtuEYz/rsUY#w?ZQ;KYIgS%37|FU1{');
define('NONCE_KEY',        'b>SxB-c:r~>~4idYiKF3L;LZ*f3&+t8>,o2a*#`#9AoZV!|tdtP m+l|cq$bP6Y<');
define('AUTH_SALT',        'X#D])5L=&!w5AiS+gq((+&lJ3DNOZ1v+&7qu+ZQjq|dST|(hm!n+GB?qA#~|#-sL');
define('SECURE_AUTH_SALT', '`MyBbgxJF8F2el)fH:GmE&O~zOI+n}Ba1SZuXD:_QoII<4e7X{/;,Iaw5uZ.)??.');
define('LOGGED_IN_SALT',   'Ff*}0_/=?Dd(9ykODYu9C]=-*5cKjj&Y]q|O*]N||#h^*Yn$[rrQ|y~c(+_+|(5N');
define('NONCE_SALT',       'x:!GUz2&w|)7cv_@Ue0T-9H8#9I4UIGc!,Fh|F-g-!@xf-31)g%=PL.0`=R6N0_!');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.jawhm.or.jp');
define('PATH_CURRENT_SITE', '/blog/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', '');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
