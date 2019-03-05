var EventModel = function( data ) {
  this.id = data.ID;
  this.title = data.post_title;
  this.content = data.post_content;
  this.start = data.date_from;
  this.end = data.date_to;

  this.deleteEvent = deleteEvent.bind( this, this.id );
  Events.push( this );
}, Events = [], initial = 1;

function reBindCalendar() {
  jQuery( '#calendar' ).fullCalendar( 'removeEvents' );
  jQuery( '#calendar' ).fullCalendar( 'addEventSource', Events );

}

function handleCreateBtnClick() {
  var data = collectData();
  function collectData() {
    var $ = jQuery;
    var title = $( '#calendar-title' ).val();
    var content = $( '#calendar-content' ).val();
    var dateFrom =  moment( $( '#calendar-dateFrom' ).val(), 'DD/MM/YYYY'  ).format( 'YYYY-MM-DD' );
    var dateTo =  moment( $( '#calendar-dateTo' ).val(), 'DD/MM/YYYY' ).format( 'YYYY-MM-DD' );
    return { title: title, content: content, dateFrom: dateFrom, dateTo: dateTo };
  }

  function validateEventData( data ) {
    var fieldsWithError = '', key, item;
    for (  key in data ) {
       item = data[key];
      if ( 'dateFrom' == key || 'dateTo' == key ) {
        if ( ! moment( item  ).isValid() ) {
          fieldsWithError += '#calendar-' + key + ', ';
        }
      }else {
        if ( ! item ) {
          fieldsWithError += '#calendar-' + key + ', ';
        }
      }
    }
    if ( !! fieldsWithError ) {
      jQuery( fieldsWithError.trim().slice( 0, -1 ) ).addClass( 'validation' ).on( 'keydown change', function() {
        jQuery( this ).removeClass( 'validation' ).off();
      });
      return false;
    }else {
      return true;
    }

  }

  if ( ! validateEventData( data ) ) {
    return false;
  }
  createEvent( data );
}

function createEvent( data ) {
  function emptyInputs() {
    var $ = jQuery;
    $( '#calendar-title' ).val( '' );
    $( '#calendar-content' ).val( '' );
    $( '#calendar-dateFrom' ).val( '' );
    $( '#calendar-dateTo' ).val( '' );
  }

  jQuery.ajax( SETTINGS.api_url,
    {
    method: 'POST', data:JSON.stringify( data ),
    contentType:'application/json',
    success: function( data ) {
      data = JSON.parse( data );
      new EventModel( data );
      reBindCalendar();
      emptyInputs();
    }, error: function( err ) {
      a = err;console.log( err.responseJSON.code );
    }
    });

}

function deleteEvent ( postId ) {
  function removeEventFromCalendar( postId ) {
      Events = Events.filter(function( element ) {
        return element.id != postId;
    });
  }

  jQuery.ajax( SETTINGS.api_url,
    {
    method: 'DELETE',
    data:JSON.stringify( { id: postId } ),
    contentType:'application/json',
    success: function( data ) {
      console.log( 'delete success' );
      removeEventFromCalendar( postId );
      reBindCalendar();
    }, error: function( err ) {
      a = err;
      console.log( err );
    }
    });

}

function getEvents() {
  jQuery.ajax( SETTINGS.api_url,
    {
      method: 'GET',
      success: function( data ) {
        Events = [];
        JSON.parse( data ).forEach(function( element ) {
          console.log( element );
          new EventModel( element );
        });
        jQuery( '#calendar' ).fullCalendar({
          events: Events,
           height: 650,
           selectable:true,
           select: function( start, end ) {
             start = moment( start ).format( 'DD/MM/YYYY' );
             end = moment( end ).format( 'DD/MM/YYYY' );

             jQuery( '#calendar-dateFrom' ).val( start );
             jQuery( '#calendar-dateTo' ).val( end );

           }
        });
        jQuery( '.loader' ).detach();
      },
      error: function( err ) {
        jQuery( '#calendar' ).fullCalendar({
          height: 650,
          selectable:true,
          select: function( start, end ) {
            start = moment( start ).format( 'DD/MM/YYYY' );
            end = moment( end ).format( 'DD/MM/YYYY' );

            jQuery( '#calendar-dateFrom' ).val( start );
            jQuery( '#calendar-dateTo' ).val( end );

          }
        });
        jQuery( '.loader' ).detach();

      }

    });
}

(function( $ ) {
  $(function() {
    getEvents();
    $( '#create-button' ).click( handleCreateBtnClick );

    // Page is now ready, initialize the calendar...
    $( '.datepicker' ).datepicker({
        dateFormat: 'dd/mm/yy'
        });

  });
}( jQuery ) );
