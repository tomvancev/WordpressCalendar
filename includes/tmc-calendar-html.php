<?php

function calendarPageHtml(){
    ?>
<div>
  <h1 class="calendar-heading">Calendar</h1>
  <div id="calendar"><div class="loader"</div></div>
    <div class="form-group">
      <div class="row--gutters">
        <div class="row__medium-6">
          <label for="dateFrom">Date From</label>
          <input type="text" class="form-control datepicker" id="calendar-dateFrom" />
        </div>
        <div class="row__medium-6">
          <label for="dateTo">Date To</label>
          <input type="text" class="form-control datepicker" id="calendar-dateTo" />
        </div>
      </div>
      <div class="row--gutters">
        <div class="row__medium-6">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="calendar-title" />

          <label for="calendar-content">Content</label>
          <textarea class="form-control" id="calendar-content"></textarea>
        </div>
        <div class="row__medium-6">
          <button id="create-button">Create Event</button>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php
}

function renderCalculatorHtml($content){
  if(is_page(TMC_PAGE_NAME)){
      ob_start();
      calendarPageHtml();
      $out = ob_get_contents();
      ob_end_clean();
      return $out;
  }
}

add_filter('the_content', 'renderCalculatorHtml');
