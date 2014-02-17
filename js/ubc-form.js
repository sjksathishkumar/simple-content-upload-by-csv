/**
 * Generic *SIMPLE* Ajax Form handling
 */
jQuery(document).ready(function($){
 $('.form-table').each(function(){
  $(this).attr('method', 'post');
  var target = $(this).attr('target');
  var func   = $(this).attr('function');
  options    = {};
  if( target || func ){
   if( target ) $('#'+target).html('').hide();
   options = { success: simpleajaxform_success, beforeSubmit: simpleajaxform_submit };
  }

  $(this).ajaxForm(options);
 });
});

/**
 * On submit: clear any previous update and inform we're trying to update
 */
function simpleajaxform_submit(formData, jqForm, options) {
 if( !jqForm.valid() ) return false;
 target = jqForm.attr('target');
 
 if( target )
  jQuery('#'+target).html('<p>Updating, please wait...</p>').removeClass('updated').addClass('updating').show();
 return true;
}

/**
 * Response: show message in target div
 */
function simpleajaxform_success(responseText, statusText, xhr, jQForm){
 if( jQForm === undefined )
  jQForm = xhr;
 if( jQForm === undefined ){
  alert('Cannot handle response properly');
  return;
 }
 target = jQForm.attr('target');
 if( target )
  jQuery('#'+target).removeClass('updating').addClass('updated').html(responseText);
 
 hide = jQForm.attr('hide');
 if( hide )
  jQuery('#'+hide).hide();

 handler = jQForm.attr('function');
 if( handler )
  eval( handler+'(responseText, jQForm)' );
}
