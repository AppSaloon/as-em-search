<?php
/**
 * AS EM Search
 *
 * Adds a search form for bookings and events
 *
 * @package   AS_EM_Search
 * @author    KoenG
 * @link      http://www.appsaloon.be
 * @copyright 2014 AppSaloon
 *
 * @wordpress-plugin
 * Plugin Name:       AS EM Search
 * Description:       Makes it possible to search in bookings and events
 * Version:           1.0.0
 * Author:            KoenG
 * Author URI:        http://www.appsaloon.be
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_filter('em_create_events_submenu', 'as_em_search_admin_menu');

function as_em_search_admin_menu($plugin_pages){
    $plugin_pages['search_form'] =
        add_submenu_page(
            'edit.php?post_type='.EM_POST_TYPE_EVENT,
            __('Search','as_em_search'),
            __('Search','as_em_search'),
            'list_users',
            "events-manager-search-form",
            'as_em_search_show_form'
        );
    return $plugin_pages;
}

function as_em_search_show_form(){
    include_once __DIR__ . '/search-form.php';
}

function as_em_search( $search_term ) {
    global $wpdb;
    $table_name = EM_BOOKINGS_TABLE;

    $query = $wpdb->prepare(
        "SELECT booking_id, event_id, booking_spaces, booking_meta FROM $table_name WHERE booking_meta LIKE %s ORDER BY event_id",
        '%' . $search_term . '%'
    );

    return $wpdb->get_results($query) ;
}

function as_em_get_event_name( $event_id ) {
    global $wpdb;

    $query = $wpdb->prepare('SELECT event_name FROM ' . EM_EVENTS_TABLE . ' WHERE event_id = %d', $event_id);
    $event = $wpdb->get_row($query, ARRAY_A);

    return $event['event_name'];
}