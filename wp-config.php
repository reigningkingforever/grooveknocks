<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
define('DB_NAME', 'encyclov_grooveknocks');
/** MySQL database username */
define('DB_USER', 'encyclov_groove');
/** MySQL database password */
define('DB_PASSWORD', 'ABC123drm&');
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
define('AUTH_KEY',         'Lrab01)x;L%><XOe}CIVq5i[&}/!V|!nkY&~|/PeUoak_ReRCfaT3 kE2y`n)FCa');
define('SECURE_AUTH_KEY',  'M?#H@~K9,4a=W/=;2BEpELIv=^2OM6E~|bU?7>@4>(=ZUU.!G/o{]~dMs@&pvk->');
define('LOGGED_IN_KEY',    'Xtn#1YfE[-@D:+)r=$]Kmnw~S]`I|d?A}DN^AGd4dG{*fgiN98Zy47~L[b;I.|x<');
define('NONCE_KEY',        'zrY|2}pkLu]eqifOae#RQ}F5APQfsM?[kGGFAJaLtf&l6gp^D&6sfzpO=j$cR=(^');
define('AUTH_SALT',        'O7Jg,YwtHC**^ZkdQ8Wv6Z)RWBA[dH47kW4!b=AV.MWcv3EC-H@V ^+iCSuer;D=');
define('SECURE_AUTH_SALT', '/ub+%/WKfD2_`YCdw*>mzk+8e>}D5Oy~G?Vv#&E;:^M!PWyHHoI.eMnK3NaY(>$-');
define('LOGGED_IN_SALT',   'XKn?.-q`mg^G(!_mpd=6P&fNKq6,tze,dl_TZJS1L^WH|bXf}-/~?o~{t~6jc@>D');
define('NONCE_SALT',       'X]VS6Sh2nnOaSt}XfN:_zE``fU[{Oi*UE}+3Kk%i85~TkYe{u0uV-1EXJ1?GH?/>');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'evt_';
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
define('WP_DEBUG', FALSE);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('WP_MEMORY_LIMIT', '128');
