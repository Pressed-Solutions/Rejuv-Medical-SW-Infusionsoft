<?php
/*
 * Plugin Name: Rejuv Medical SW Infusionsoft
 * Plugin URI: https://github.com/Pressed-Solutions/Rejuv-Medical-SW-Infusionsoft
 * Description: Custom Infusionsoft API actions
 * Version: 1.0.0
 * Author: Pressed Solutions
 * Author URI: http://pressedsolutions.com.com
 * GitHub Plugin URI: https://github.com/Pressed-Solutions/Rejuv-Medical-SW-Infusionsoft
 */

// block direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// check if required SDK plugin is active
add_action( 'plugins_loaded', 'rmswi_plugin_init' );
function rmswi_plugin_init() {
    if ( class_exists( 'Infusionsoft_Classloader' ) ) {
        include( 'functions.php' );
    } else {
        add_action( 'admin_notices', 'rmswi_parent_missing' );
    }
}

// show error if required plugin is not active
function rmswi_parent_missing() { ?>
    <div class="notice notice-error">
        <p>Required plugin <a href="https://wordpress.org/plugins/infusionsoft-sdk/" target="_blank">Infusionsoft SDK</a> is not active or not installed. Please <a href="<?php echo admin_url( 'plugin-install.php?s=infusionsoft-sdk&tab=search&type=term' ); ?>">install</a> or <a href="<?php echo admin_url( 'plugins.php?s=infusionsoft-sdk' ); ?>">activate</a> it.</p>
    </div>
<?php }
