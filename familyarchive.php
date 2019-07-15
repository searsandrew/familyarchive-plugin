<?php
/*
Plugin Name: Family Archive
Plugin URI: http://www.mayfifteenth.com/
Description: Family Archive is a plugin that provides an easy way to upload and tag photos for family members to see and still use the fiull features of WordPress where desired.
Version: 1.0
Author: Andrew Sears
Author URI: http://www.mayfifteenth.com
*/

use Mayfifteenth\FamilyArchive\Core\FamilyArchive;

// Family Archive depends on PSR-4 Autoload
require('autoload.php');

// Family Archive has global constants
require('constants.php');

// Register and load Family Archive
(static function () {
    add_action('init', static function() {
        (new FamilyArchive(__FILE__))->execute();
    }, 1000);
})();