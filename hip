#!/bin/env php
<?php
namespace theseer\hip;

if (!defined('HHVM_VERSION') && (version_compare(phpversion(), '5.6', 'lt'))) {
    fwrite(
        STDERR,
        sprintf(
            "hip requires PHP 5.6 or later; " .
            "Upgrading to the latest version of PHP is highly recommended. (Version used: %s)\n\n",
            phpversion()
        )
    );

    die(1);
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/autoload.php';

$rc = (new Factory())->createCliRunner()->run(
    new Request($_SERVER['argv'])
);

die($rc);
