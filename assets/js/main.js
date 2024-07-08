// Cookie popup
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#3a3a3a"
    },
    "button": {
      "background": "#f7931e",
      "text": "#ffffff"
    }
  },
  "theme": "classic",
  "content": {
    "href": ' "data-toggle="modal" data-target="#popTerms',
    "dismiss": "Agree"
  }
});


      $("#frmLogin").validate(
            {
                debug: false,
                focusInvalid: false,
                onclick: false,
                submitHandler: function (form) {
                    try
                    {
                         var options = {
                          clearForm : true,
                          url: "newlogin_validate.php",
                          type: 'POST',
                          dataType: 'json',
                          success: function (response, status) {
                              
                              console.log(response);

                              if(response != null && response.status)
                              {
                                $("#divLoginMessage").removeClass("alert-danger");
                                $("#divLoginMessage").addClass('alert alert-success');
                              }
                              else
                              {
                                $("#divLoginMessage").removeClass("alert-success");
                                $("#divLoginMessage").addClass('alert alert-danger');
                                shakeModal();
                              }

                              $("#divLoginMessage").html(response.message);
                              if(typeof(response.redirect) != "undefined")
                              {
                                window.location.href = response.redirect;
                              }
                              
                            }
                        };

                      $("#frmLogin").ajaxSubmit(options);
                    }
                    catch(ex)
                    {
                      console.log(ex)
                    }
                },
                errorPlacement: function (error, element) {
                    $(element).addClass("error");
                },
                showErrors: function (errorMap, errorList) {
                    this.defaultShowErrors();
                },
                highlight: function (element, errorClass, validClass) {
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass("error");
                }
            });

          $("#frmGetInTouch").validate(
            {
                debug: false,
                focusInvalid: false,
                onclick: false,
                submitHandler: function (form) {
                    try
                    {
                         var options = {
                          clearForm : true,
                          url: "newcontact_mail.php",
                          type: 'POST',
                          dataType: 'json',
                          success: function (response, status) {
                              
                              console.log(response);
                              
                              if(response != null && response.status)
                              {
                                
                              }
                              else
                              {
                                
                              }

                              $("#divContactMessage").html(response.message);
                              
                            }
                        };

                      $("#frmGetInTouch").ajaxSubmit(options);
                    }
                    catch(ex)
                    {
                      console.log(ex)
                    }
                },
                errorPlacement: function (error, element) {
                    $(element).addClass("error");
                },
                showErrors: function (errorMap, errorList) {
                    this.defaultShowErrors();
                },
                highlight: function (element, errorClass, validClass) {
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass("error");
                }
            });





});


// Header Animation
$(window).scroll(function(){
  var wscroll = $(this).scrollTop();
  if(wscroll > 150){
   $(".navbar").addClass("slim-fat");
    //$(".logo").addClass("shrink-logo");
  }
  else{
    $(".navbar").removeClass("slim-fat");
    //$(".logo").removeClass("shrink-logo");
  }
});


// Single Page Nav
(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 70)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 70
  });

})(jQuery); // End of use strict



/*
 *
 * login-register modal
 * Autor: Creative Tim
 * Web-autor: creative.tim
 * Web script: http://creative-tim.com
 * 
 */
function showRegisterForm(){
    $('.loginBox').fadeOut('fast',function(){
        $('.modal').modal('hide');
    }); 
    $('.error').removeClass('alert alert-danger').html('');
       
}
function showLoginForm(){
    $('#loginModal .registerBox').fadeOut('fast',function(){
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast',function(){
            $('.login-footer').fadeIn('fast');    
        });
        
        $('.modal-title').html('Sign in');
    });       
     $('.error').removeClass('alert alert-danger').html(''); 
}

function openLoginModal(){
    showLoginForm();
    setTimeout(function(){
        $('#loginModal').modal('show');    
    }, 230);
    
}
function openRegisterModal(){
    showRegisterForm();
    setTimeout(function(){
        $('#loginModal').modal('show');    
    }, 230);
    
}

function loginAjax(){
    /*   Remove this comments when moving to server
    $.post( "/login", function( data ) {
            if(data == 1){
                window.location.replace("/home");            
            } else {
                 shakeModal(); 
            }
        });
    */

/*   Simulate error message from the server   */
     shakeModal();
}

function shakeModal(){
    $('#loginModal .modal-dialog').addClass('shake');
            
             setTimeout( function(){ 
                $('#loginModal .modal-dialog').removeClass('shake'); 
    }, 1000 ); 
}

   