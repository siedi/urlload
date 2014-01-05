#!/usr/bin/php
<?php

/**
 * Runs URLLoad2Graphite
 * example: php run.php -c urlload2graphite
 */

$dir = dirname(__FILE__);

require($dir . '/../lib/URLLoad.php');
require($dir . '/../lib/Graphite.php');

$options = getopt('c:');

$config_file = isset($options['c']) ? $dir . '/../etc/'.$options['c'] : $dir . '/../etc/urlload.conf';
$config = json_decode(file_get_contents($config_file), true);

if (!$config || json_last_error()) {
    die('Error parsing config file.');
}

$loader = new URLLoad($config['curl_options']);
$grapher = new Graphite($config['graphite_options']);

foreach($config['urls'] as $url_name => $url) {
    $date = time();
    echo "Starting $url_name...\n";
    $stats = $loader->run($url);
    // TODO Add some exception handling
    $grapher->save($url_name, $date, $stats);
    echo "Done.";
}

