<?php

/*DEFINITIONS*/
define('SMART_LIB_DIRECTORY', '/smart-lib/');
define('SMART_TEMPLATE_DIRECTORY', get_template_directory());
define('SMART_TEMPLATE_DIRECTORY_URI', get_template_directory_uri());
define('SMART_STYLESHEET_DIRECTORY', get_stylesheet_directory_uri());
define('SMART_ADMIN_DIRECTORY_URI', SMART_TEMPLATE_DIRECTORY_URI.'/admin');
define('SMART_ADMIN_DIRECTORY', SMART_TEMPLATE_DIRECTORY.'/admin');

/*LOAD TGM*/
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'class-tgm-plugin-activation.php');

require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'theme-utils.php');
// Load theme base class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'core/class-base.php');
// Load base utils class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'core/class-base-utils.php');
// Load base admin utils class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'core/class-base-admin.php');
// Load base utils class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'project/class-project-admin-utils.php');

// Load project base class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'project/class-project-base.php');
// Load project layout class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'project/class-project-layout.php');

// Load theme customizer class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'project/class-project-customizer.php');
// Load theme customizer class
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'core/class-base-widget.php');

// Load external function - helpers
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'template-tags.php');
// Load external widget classes
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. 'project/class-custom-widgets.php');
// Load theme plugin functions
require(SMART_TEMPLATE_DIRECTORY .SMART_LIB_DIRECTORY. '/premium-info.php');

 
