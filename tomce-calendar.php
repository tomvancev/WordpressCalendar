<?php
/*
Plugin Name: Tomce's Calendar
Description: Calendar for a specific pupropse.
Version: 1.0.0
Author: Tomce
*/
define( "TMC_PAGE_NAME", 'calendar' );
define( "TMC_POST_TYPE_EVENT", 'calendar-event');
define( "TMC_PLUGIN_URL", plugins_url( '/', __FILE__ ) );
define( "TMC_PLUGIN_ASSETS_URL", plugins_url( 'assets/', __FILE__ ) );
define( "TMC_PLUGIN_INCLUDES_DIR", plugin_dir_path( __FILE__ ) . 'includes/' );

include(TMC_PLUGIN_INCLUDES_DIR . 'tmc-register-post-type.php');
include(TMC_PLUGIN_INCLUDES_DIR . 'classes/CalendarEvent.php');
include(TMC_PLUGIN_INCLUDES_DIR . 'tmc-rest-api.php');
include(TMC_PLUGIN_INCLUDES_DIR . 'tmc-enqueue-scripts.php');
include(TMC_PLUGIN_INCLUDES_DIR . 'tmc-calendar-html.php');
include(TMC_PLUGIN_INCLUDES_DIR . 'tmc-woocommerce-integration.php');
