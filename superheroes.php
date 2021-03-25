<?php
/**
 * Plugin Name: Superheroes
 * Plugin URI: https://github.com/Fcog/superheroes
 * Description: Add Super Heroe cards in your posts!
 * Version: 1.0
 * Author: Francisco Giraldo
 * Author URI: https://www.franciscogiraldo.com
 */

$loader = require 'vendor/autoload.php';
$loader->addPsr4('Superheroes\\', 'src/classes/');

include_once 'src/classes/App.php';

$app = new Superheroes\App( __FILE__ );
$app->insert_assets();
$app->create_shortcode();