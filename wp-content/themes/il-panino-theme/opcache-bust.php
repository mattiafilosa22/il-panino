<?php
/**
 * Temporary script: reset PHP-FPM opcache on Pantheon.
 * Delete right after use.
 */
header('Content-Type: text/plain');
if (function_exists('opcache_reset')) {
    $ok = opcache_reset();
    echo $ok ? 'opcache-reset-ok' : 'opcache-reset-failed';
} else {
    echo 'opcache-disabled';
}
