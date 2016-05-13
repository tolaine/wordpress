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
define('DB_NAME', 'wp_test');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'wordpress');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         'OTcB99oIskM-r*?h.p%nF>._U(dnK.H6)7}z5L$z+%L<gZg2w!+*I1gsLx1_=NpM');
define('SECURE_AUTH_KEY',  '`cHx4+mzK+I!<EA:E{Rn>0?+dT3@5~/2@]Pm8V_ICBaf m16DG$3dn1?>IDK@U6]');
define('LOGGED_IN_KEY',    '83ftIPSoq?yT[{,o(YxK.mcq)Qbqm^B).?PZ6Tu}ixfSJhzX&#)pzD8FsQTncFJd');
define('NONCE_KEY',        'N+OoUbu_##`4rXpFsW8<U.;}`1#FzPmwV)j-K;IsU-Bz))&xAVM+S{wMRu37Oc}J');
define('AUTH_SALT',        'mDR@hl2raEX~(9AX,GE^C,~R]}WewOTh#n KF5UHP-I#Th-n2w}TG+QvNDH7{ 2z');
define('SECURE_AUTH_SALT', 'fhPaj[YLCy3e:3(}U7~,H~RsnDgl`_bBj.3<N~;D9qSL`^xCSQ76{+xE8%F3q6XI');
define('LOGGED_IN_SALT',   '3(@@kmssl7{K9k,4rZwc_c0sgNpUq&%o1Hg#p$I-9PQEr;L75k[I7Ew#Ajks7smC');
define('NONCE_SALT',       'm+$mV)t.Y3M$9$vY>2P+bHC(i1rTfAX40Qlz:I]C6Q5:HcH[//qNJhvJieGEm_fU');

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
