<?php
/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_calendar_product_tab' );
function woo_calendar_product_tab( $tabs ) {
  if(get_post_meta( get_the_id(), $key = 'has_calendar', $single = true )){
  	// Adds the new tab

  	$tabs['test_tab'] = array(
  		'title' 	=> 'Book now',
  		'priority' 	=> 50,
  		'callback' 	=> 'woo_calendar_product_tab_content'
  	);

  	return $tabs;
  }
}
function woo_calendar_product_tab_content() {

	// The new tab content
  calendarPageHtml();

}
