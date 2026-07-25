<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'MC[)5;w_2.MlrO:PH)wv7Cs3UueFSf@lAygT5%tg}.}8^(8}-Tq`kaw%|x/}WoX-' );
define( 'SECURE_AUTH_KEY',   ';>*_l.qn92?wR55Ph*)yJIZjYzCY@1S,Ind#q3FZM%fpJ[N^,h0K26:Zz0!2Fc!u' );
define( 'LOGGED_IN_KEY',     'C lRu_GO:tN|[b[YfW3qH_*6e{sZ4Q48%>#W-.alO/C#LT +)Z[~4:Ebk:X>A2MZ' );
define( 'NONCE_KEY',         'qe5G@RX~V)%3k6XxYk-dPDVaZj9fk$swf?t]7(ctvQC7cLs{y+j*3<1[*g~0||LK' );
define( 'AUTH_SALT',         'KrAfA#O.d2hQY8ElCLIPo7~]#k}nL<7/Jw<9$Tbj8l%diCugmwaH&&.95Xw88Ux`' );
define( 'SECURE_AUTH_SALT',  'E`8U+Mb=13.>zwKmyo>d,- z9_* C0^-Z2cNCv.9b>,G|JO=R-iU/p[Ll=tvk}7B' );
define( 'LOGGED_IN_SALT',    'ZAw6^w{T<}k(<c,*%Be]PE: lgJ#g[i/kkk1XT:v,n_]&vT?jLY6f/b[dyn=ed5Z' );
define( 'NONCE_SALT',        'XyAaO>%2aJ5(PmF7}E3}wg[V#K%8t8ENn008oy:@de#Ylg`V7p_Muj8ih6H_Y_s?' );
define( 'WP_CACHE_KEY_SALT', '-o6T/WJ%->f_st&*%KV#,lG&l+c34E8Z]AZT*EORP9}q,Kw]13amXb0aK9XWqHz5' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
	define('WP_DEBUG_LOG', true);
	define('WP_DEBUG_DISPLAY', true);
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
