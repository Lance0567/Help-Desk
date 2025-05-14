<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ustl_helpdesk' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'jB:d>h5wjX62#(qK}[<%qL|kc1SUD5Zlm}PWOn--u[NJ1fYl@oV@-z1J>[=JT`nP' );
define( 'SECURE_AUTH_KEY',  'E!zS, NX$K(-m<o2rp{yTm;a)rlufG-n3PSpe2*`HDNyjSon,xeV|RNm<?aKm9AI' );
define( 'LOGGED_IN_KEY',    '=8rj_D&a C3o_e2O2(?+QZZ@qB>]6QBjxA optf`t&-^]pz/6WOSxSv.X=Zw674Y' );
define( 'NONCE_KEY',        '?ZBao ljNlKV1ALueYykwQE@Hz oi#jNFz^l@UKG:c)H<!E|kL2f_Gne%FO6J ;J' );
define( 'AUTH_SALT',        '&_Nlbv,4pJ/=6Gj8YAh:X&5ga*xs kV?q8_bq|6CdBodD;*>0p7{eqCg~+_%nQHo' );
define( 'SECURE_AUTH_SALT', ':$z;bD[m?@NKcZ?8OSe+aEI>Oie:Ke~zWu{FwS[ComcnLL(Vjr?|{`-iHk83&hf ' );
define( 'LOGGED_IN_SALT',   'IE%afQSs@3f>7 vIdM8y`h.iIE??Gy/VS*Y!:7;jU g2)Q[_ugeA:=jTNSBdwC}w' );
define( 'NONCE_SALT',       '~.qVgMl9e<Z*=mG?a@cw_erEN>>iab0#2YF[a0X}8G|ihp~7fzHAQ%q1o6,Z9O@M' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
