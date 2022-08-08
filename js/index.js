function booking_function() {
  //
 }

$( document ).ready(function() {
    setTimeout(function(){
        $("#pass").attr('readonly', false);
        $("#pass").focus();
    },500);
});

$(document).ready(function() {
  
    	$('#form input').each(function(e){
      		var $this = $(this);
          label = $this.prev('label');
      	 	
          var username = document.getElementsByName("username")[0].value;
      	 	var email = document.getElementsByName("email")[0].value;
        	if(username.length > 0 || email.length > 0 ){
            label.addClass('active highlight');
          }
         /* $("input").on('click keyup blur focus' , function () {    
              label.addClass('active highlight');
             
          });*/
         

    	 });
});





$('.form').find('input').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();   // nasconde la registrazione
  
  $(target).fadeIn(600);
  
});