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
define( 'DB_NAME', 'ticketst_productos' );

/** MySQL database username */
define( 'DB_USER', 'ticketst_productos' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Productos2020#' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Vm*>sh3zL9OH,;2)w2A%0TZP`zk7@p.<<:h_[4hk=ua!h)wH)|A@zE1%Cgql{PMk' );
define( 'SECURE_AUTH_KEY',  '0wWl>YG>;lxMzfJdvU*xD1!jt2_N)a!]ma;+h<p^aZGe#FC|q2HflUg)]cLoCYKw' );
define( 'LOGGED_IN_KEY',    'CRI:,GOVczMGGQ3Vk<t,XH#8<3,;u$C2AY=W+>p<vJAg)2k#OAnEe5*:!Qp6c5;k' );
define( 'NONCE_KEY',        'GN{0U24%.`r*ppunZdDNdY6rK-9#1t(vc yWzd|41KBh0^>}ilKMu{g|)6S/ZH q' );
define( 'AUTH_SALT',        'W$RPX>+-3lVA]O+ZY?uxqSF9O<ZhlZz= BI=VS@iAp76xvh#(xT,:0.)nFGRTKd-' );
define( 'SECURE_AUTH_SALT', ':p]{ht3|;08YI`6px^mB~8RSV;/Bsp{xmUfIfTx{C%O<pRPZjW-j[p`bOT|C4K.t' );
define( 'LOGGED_IN_SALT',   '>4%pk[Rzkt|.:j%L7ZgJtIM;cWH2ljdHapkah2|TAogQj*o8b])4c}z-)k?OZ)z5' );
define( 'NONCE_SALT',       'Ix4?g=^@M7;+-z6Y0mwp-Qm< _H7@ 3 |(z2C]{_p_=w#yC|x?It]4TU7(o-oRmX' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
