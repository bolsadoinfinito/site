
jQuery(document).ready(function(a) {
    jQuery( "#drag li " ).draggable({
        helper: 'clone'
    });
jQuery( "#droppable" ).droppable({
  drop: function() {
    alert( "dropped" );
  }
});
});

