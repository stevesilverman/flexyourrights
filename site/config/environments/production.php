<?php
/* Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
define('DISALLOW_FILE_MODS', true); // this disables all file modifications including updates and update notifications

define('FORCE_SSL_ADMIN', true);
define('FORCE_SSL_LOGIN', true);
define('WP_CACHE', true);
