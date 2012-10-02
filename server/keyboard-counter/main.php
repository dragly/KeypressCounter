<?php
/*
Plugin Name: Keyboard Press Counter
Plugin URI: http://dragly.org/source
Description: Stores keyboard presses online
Version: 0.0.1
Author: Svenn-Arne Dragly
Author URI: http://dragly.org/
License: GNU GPLv3
*/

global $keyboard_counter_db_version;
$keyboard_counter_db_version = "0.0.1";

function keyboard_counter_install () {
    global $wpdb;
    global $keyboard_counter_db_version;

    $table_name = $wpdb->prefix . "keyboard_counter";
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            `user` varchar(255) NOT NULL,
            `presses` integer NOT NULL
            UNIQUE KEY `id` (`id`)
            );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option("keyboard_counter_db_version", $keyboard_counter_db_version);
}

register_activation_hook(__FILE__,'keyboard_counter_install');
?>