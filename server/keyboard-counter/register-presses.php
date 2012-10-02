<?php
require_once('../../../wp-load.php');

if( isset($_GET['user']) ) {
    //Reads the posted values
    $user = $_GET["user"];
    $presses = $_GET["presses"];

    global $wpdb;
    $runid = uniqid("", true);
    $wpdb->show_errors();
    $table_name = $wpdb->prefix . "keyboard_counter_runs";
    $rows_affected = $wpdb->insert( $table_name, 
                                    array( 'user' => $user,
                                            'presses' => $presses,
                                            'date' => current_time('mysql')) 
                                   );
    if($rows_affected) {
        print json_encode(array("runid" => $runid));
    } else {
        $wpdb->print_error();
    }
}
?> 
