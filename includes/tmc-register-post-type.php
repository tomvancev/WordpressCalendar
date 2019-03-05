<?php

function register_calendar_event_post_type(){
$post_type = TMC_POST_TYPE_EVENT;
$labels = array(
  'name'              => 'Calendar Events' ,
  'singular_name'     => 'Calendar Event',

);

$args = array(
  'labels'               => $labels,
  'description'          => __( 'Description.', 'your-plugin-textdomain' ),
 		'public'             => true,
 		'publicly_queryable' => true,
 		'show_ui'            => true,
 		'show_in_menu'       => true,
    'show_in_rest'       => true,
 		'query_var'          => true,
 		'rewrite'            => array( 'slug' => 'book' ),
 		'capability_type'    => 'post',
 		'has_archive'        => true,
 		'hierarchical'       => false,
 		'menu_position'      => null,
 		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
);

register_post_type( $post_type, $args );

}

add_action( 'init', 'register_calendar_event_post_type' );

/*
'description'         => 'Calendar Events with undefined purpose',
'exclude_from_search' =>true,
'public'              => true,
'publicly_queryable'  => true,
'show_ui'             => true,
'show_in_menu'        => false,
'query_var'           => false,
'capability_type'     => 'post',
'has_archive'         => false,
'hierarchical'        => false,
'menu_position'       => null,
'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
*/
