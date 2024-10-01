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
define( 'AUTH_KEY',          'M=|u!*cjyq4ko>SSzKl?5y^r{YTtyT:Pn5Y+RS4WNe}(SKr1Y/8<,+=rykNYEO,u' );
define( 'SECURE_AUTH_KEY',   '3ZZQ)7BPful:Y0n4u][kL;(Ll_W32IQd/lh]:(E3V!1.vcvJXQ3MWD0[ks:aDc=0' );
define( 'LOGGED_IN_KEY',     ';{uAH}a7`Ec-q9$cmL=f;/zYLm,QmNFMEY}>&ypyL2Xy{J:hwkOm/kWVb`lIxxe5' );
define( 'NONCE_KEY',         'UcR7q)zQVY};6pT4R! 5OO[2fI{o++-q{v>7)V3SVa69(QJK$z x6/*Tb^bsYX0i' );
define( 'AUTH_SALT',         '$3BE?c){OmY020x{^_=ELt~7ong PMK).=@ft:a&Dgkz.5amC)t&xf3_aokf(o5H' );
define( 'SECURE_AUTH_SALT',  '+(],$WADa<6oivk+-:(Y7-WTO r7$`Rq6#Wt1w{n[M)4e ?hbBR7N@S?5FDnvLsb' );
define( 'LOGGED_IN_SALT',    '>XUNM8;cp=9ZmV2?WJ:+:63PrIsx!@L2<3:`p:M:)R)t8mWYEWkWu9/^Ni:{E5uR' );
define( 'NONCE_SALT',        'H~vP*YP6`9hPQfCnw!hs}1H>}?~J*OH[PS@sdM$ l};>a&t8gt v=M*avd/BSKA5' );
define( 'WP_CACHE_KEY_SALT', 'q}B+`]Ei/CF<KPL+y :mQvynfyABn-FT|E)[p/<5}cc:!T$#$4]4q }%!o:0m|@0' );


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
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
