<?php
if(!class_exists('schedule')){
    include(PLUGIN_DIR . 'controllers/schedule.php');
}
class event {
    public function __construct()
    {
        $this->convention_magic_event();
    }

    static function convention_magic_event()
    {
        $labels = array(
            'name' => __('Events', 'convention-magic'),
            'singular_name' => __('Event', 'convention-magic'),
            'add_new' => 'Add New Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'new_item' => 'New Event',
            'all_items' => 'All Events',
            'view_item' => 'View Event',
            'search_items' => 'Search Events',
            'not_found' => 'No Events Found',
            'not_found_in_trash' => 'No Events found in Trash',
        );
        $args = array(
            'labels' => $labels,
            'taxonomy' => array('category', 'cm-room'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'has_archive' => true,
            'menu_position' => 7,
            'menu_name' => 'Events',
            'menu_icon' => 'dashicons-calendar-alt',
            'register_meta_box_cb' => 'event::convention_magic_event_meta_boxes',
            'show_in_rest' => true,
            'rest_base' => 'events',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title', 'editor','revisions', 'page_attributes'),
            'rewrite' => ['slug' => 'events']
        );
        register_post_type('cm-event', $args);
    }

    static function convention_magic_event_meta_boxes()
    {
        add_meta_box(
            'Time',
            __('Event Time', 'convention-magic'),
            'event::convention_magic_event_time_set',
            'cm-event',
            'side',
            'low'
        );
    }


    static function convention_magic_event_time_set()
    {
        wp_nonce_field(plugin_basename(__FILE__), 'event_nonce');
        //TODO:: Write function to set the event time in something that will convert to a C# DateTime variable.
        $the_date = schedule::set_date();
        $the_time = schedule::set_time();
        $minute = $the_time[1];
        $pm = $the_time[2];
        $hour = $the_time[0];
        $day = $the_date[1];
        $month = $the_date[0];
        $year =$the_date[2];
        schedule::set_schedule($year, $month, $day, $hour, $pm, $minute);
    }



}
