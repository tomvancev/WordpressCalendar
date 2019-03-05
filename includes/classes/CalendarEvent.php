<?php
class CalendarEvent {
  public $id;
  public $title;
  public $content;
  public $dateFrom;
  public $dateTo;

    public function __construct($id, $title, $content, $dateFrom, $dateTo){
      if(isset($id)){
        $this->load($id);
      }else{
        $this->title    = $title;
        $this->content  = $content;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->create();
      }

    }

    private function load($id){
      $post = get_post( $post = $id, $output = OBJECT, $filter = 'raw' );
      $this->id = $post->ID;
      $this->content = $post->post_content;
      $this->title = $post->post_title;
      $this->dateFrom = get_post_meta( $id, $key = 'date_from', $single = false );
      $this->dateTo = get_post_meta( $id, $key = 'date_to', $single = false );

    }

    private function create(){
      $postarr = array(
        post_type       => TMC_POST_TYPE_EVENT,
        post_status     => 'publish',
        post_title      => $this->title,
        post_content    => $this->content
      );
      $id = wp_insert_post( $postarr, new WP_Error( 'broke', "The Event could not be inserted" ) );
      if( is_wp_error( $id ) ) {
        echo $id->get_error_message();
      }

      add_post_meta( $id, 'date_from', $this->dateFrom, $unique = false );
      add_post_meta( $id, 'date_to', $this->dateTo, $unique = false );
      $this->id = $id;

    }

    public function delete(){
      if(wp_delete_post( $this->id, true )){
        $this->id = null;
        $this->content = null;
        $this->title = null;
        $this->dateFrom = null;
        $this->dateTo = null;
      }else {
        throw new Exception("Error deleting the event", 1);
      }

    }

    public function to_JSON(){
      return json_encode( array(
        'ID'      => $this->id,
        'post_content' => $this->content,
        'post_title' => $this->title,
        'date_from' => $this->dateFrom,
        'date_to' => $this->dateTo
      ) );

    }

// end of class

}
