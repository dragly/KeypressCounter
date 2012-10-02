<?php
require_once('../../../wp-load.php');

if( isset($_GET['project']) ) {
    global $wpdb;
    $project = $_GET['project'];
    $table_name = $wpdb->prefix . "keyboard_counter_runs";
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT user, SUM(presses) as presses_total FROM $table_name WHERE date >= DATE_SUB(NOW(),INTERVAL 1 HOUR) GROUP BY user;" ) );
    $wpdb->print_error();
    $returnArray = array();
    foreach($results as $result) {
        //print_r($result);
        $returnArray[$result->state] = $result->occurences;
    }
}
//print_r($returnArray);
print json_encode($returnArray); 
?>