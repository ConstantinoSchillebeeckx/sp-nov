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
define('DB_NAME', 'db215537_1clk_wordpress_6NhAQBnNGLu6hb7E');

/** MySQL database username */
define('DB_USER', 'wordpress_ESDhCh');

/** MySQL database password */
define('DB_PASSWORD', 'daEuzR7L');

/** MySQL hostname */
define('DB_HOST', 'internal-db.s215537.gridserver.com');

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
define('AUTH_KEY',         'u9EHe3MBqzAM5aCuWmawWiBnAL1WDjVoElk3t29uDl4UR8QjAsnAW53oJYvVaLSD');
define('SECURE_AUTH_KEY',  '12OwhyqMZmAf7mx4ol2zyIseQxvFx198gBZAjWn3PyL1PaQWSVecSC6IbyfElm5X');
define('LOGGED_IN_KEY',    'mW5pYOy3soIjghj0WVT6kyNOEhHaPIK2dZ33Aih3a0iEMbAoGpHvJrfDzwJYJmbX');
define('NONCE_KEY',        'yxq4pb2rgrL59CxjcqkiCIIp17GVGD94r3zGlRbBwZGnXE3lWrXVY54F3xzMyCi9');
define('AUTH_SALT',        'M4qwtJSdyszdeUmcWLngaxdPCaVHSg63FKMX6w6DvFDqHKm7XIr7beMMxWljt2RP');
define('SECURE_AUTH_SALT', 'XrVDDxgpUwdBYT4MJ1p8vdeSxhrAH2V50LTXJmAr5GvkcsVly4wJmPeinh5UY0OQ');
define('LOGGED_IN_SALT',   'otvJomJc11YnJqOsL4oTSqx05SbMyuwhF4HXDDVI3BzUiXjDRntUUVLZI67hDw5T');
define('NONCE_SALT',       '5JiG3JFMkVoxv1OEAu7T80KFsM6n742vcGYww4omBTNChlT5yvnPL6SyGInZ9BIO');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'vznp_';

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
