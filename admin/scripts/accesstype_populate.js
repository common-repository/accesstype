/*
 * Post bulk and quick Edit Script
 * Hooks into the inline post editor functionality to extend it to our custom metadata
 */

 jQuery(document).ready(function($) {
  $('.accesstype-color-field').wpColorPicker();

  if (!(typeof inlineEditPost == 'undefined')) {
    //Prepopulating our quick-edit post info
    var $inline_editor = inlineEditPost.edit;
    inlineEditPost.edit = function(id){
      //call old copy
      $inline_editor.apply( this, arguments);

      //our custom functionality below
      var post_id = 0;
      if( typeof(id) == 'object')
        post_id = parseInt(this.getId(id));

      //if we have our post
      if(post_id != 0) {
        //find our row
        var row = $('#edit-' + post_id);

        //post visibility
        var accesstype_visibility = $('#accesstype_visibility_' + post_id);
        // set default value as public if it is blank
        var accesstype_visibility_value = accesstype_visibility.text() || 'public';
        row.find('#accesstype_visibility').val(accesstype_visibility_value);
        row.find('#accesstype_visibility').children('[value="' + accesstype_visibility_value + '"]').attr('selected', true);
      }
    }
  }

  $( 'body' ).on( 'click', 'input[name="bulk_edit"]', function() {
    // let's add the WordPress default spinner just before the button
    $( this ).after('<span class="spinner is-active"></span>');
      // define: accesstype visibility and the bulk edit table row
      var bulk_edit_row = $( 'tr#bulk-edit' ),
          post_ids = new Array()
          accesstype_visibility = bulk_edit_row.find( 'select[name="accesstype_visibility"]' ).val(),

      // now we have to obtain the post IDs selected for bulk edit
      bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
        post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
      });

      // save the data with AJAX
      $.ajax({
        url: ajaxurl, // WordPress has already defined the AJAX url for us (at least in admin area)
        type: 'POST',
        data: {
          action: 'accesstype_save_bulk', // wp_ajax action hook
          post_ids: post_ids, // array of post IDs
          accesstype_visibility: accesstype_visibility, // new visibility
          accesstype_post_class_nonce: $('#accesstype_post_class_nonce').val() // nonce field for verfication
        }
      });
  });
});