<?php
/**
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 *
 *
 * Common configuration directives for Wild West
 *
 */
require_once( dirname( __FILE__ ) .'/config.base.php');
require_once( dirname( __FILE__ ) .'/config.traits.php');
require_once( dirname( __FILE__ ) .'/config.class.php');
/**
 * Initialize system settings
 */
TheWildWest::init();
/**
 * Load vendor plugins
 */
Load::vendor_plugin("autoload.php");
/**
 * Load Library's
 * Only include the ones intended to be used.
 */
Load::library("system.interfaces");
Load::library("db");
Load::library("logger");
Load::library("smartyview");






