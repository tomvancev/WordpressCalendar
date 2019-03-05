<?php
function register_tmc_rest_routes(){
  register_rest_route('tmc/v1', 'index', array(
        'methods' => 'GET',
        'callback' => 'get_tmc_events',
  ));
  register_rest_route('tmc/v1', 'index', array(
        'methods' => 'POST',
        'callback' => 'create_tmc_event',
  ));
  register_rest_route('tmc/v1', 'index', array(
        'methods' => 'DELETE',
        'callback' => 'delete_tmc_event',
  ));
}

add_action( 'rest_api_init', 'register_tmc_rest_routes');
function get_tmc_events(){
    // The Query
  $args =  array('post_type' => TMC_POST_TYPE_EVENT);
  $the_query = new WP_Query($args);
  if ( $the_query->have_posts() ) {
    $results = array();
    while ( $the_query->have_posts() ) {
		    $the_query->the_post();
		    array_push($results,array(
            'ID'            => get_the_id(),
            'post_content'  => get_the_content( $more_link_text = null, $strip_teaser = false ),
            'post_title'    => get_the_title( $post = 0 ),
            'date_from'     => get_post_meta( get_the_id(), $key = 'date_from', $single = true   ),
            'date_to'     => get_post_meta( get_the_id(), $key = 'date_to', $single = true )
        ));
	 }
    wp_reset_postdata();
    return rest_ensure_response(json_encode( $results ));
  } else {
    return rest_ensure_response(new WP_Error('No Posts Found'));
  }

}

function create_tmc_event($request){
  // validation
  $errors = '';

  $title = $request['title'];
  if(!isset($title)){
    $errors .= 'Title is not set ' . PHP_EOL;
  }

  $content = $request['content'];
  if(!isset($content)){
    $errors .= 'Content is not set ' . PHP_EOL;
  }

  $dateFrom = $request['dateFrom'];
  if(!isset($dateFrom)){
    $errors .= 'DateFrom is not set ' . PHP_EOL;
  }else{
    list($y, $m, $d) = explode('-', $dateFrom);
    if(!checkdate($m, $d, $y)){
      $errors .= 'DateFrom invalid format ' . PHP_EOL;
    }
  }

  $dateTo = $request['dateTo'];
  if(!isset($dateTo)){
    $errors .= 'DateTo is not set ' . PHP_EOL;
  }else{
    list($y, $m, $d) = explode('-', $dateTo);
    if(!checkdate($m, $d, $y)){
      $errors .= 'DateTo invalid format ' . PHP_EOL;
    }
  }

  if(!empty($errors)){
    return rest_ensure_response(new WP_Error($errors));
  }
  //end validation

   $newObject = new CalendarEvent(null,$request['title'],$request['content'],$request['dateFrom'],$request['dateTo']);
   return rest_ensure_response($newObject->to_JSON());

}

function delete_tmc_event($request){

  if(isset($request['id'])){
    $objToDelete = new CalendarEvent($request['id']);
    $status = $objToDelete->delete();
    return rest_ensure_response($status);
  }

}
