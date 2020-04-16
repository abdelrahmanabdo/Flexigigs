

setTimeout(function(){ $(".loader").fadeOut("slow"); },0);

$(document).ready(function() {


    
  $(window).scroll(function() {
    if ($("#header-wrap").offset().top > 100) {
      $("#top-search").css('padding-top' , '0px');
    } else {
      $("#top-search").css('padding-top' , '38px');
    }
    
  });


  $(".sub-ul .fa-times").click(function(){
    $('body').removeClass('top-search-open');
  });

  if ($(window).width() < 960) {
   $( ".portfolio-item:nth-child(2)" ).insertBefore( $( ".portfolio-item:nth-child(1)" ) );
   //alert("hi");
  }

  else{
    $( ".portfolio-item:nth-child(1)" ).insertBefore( $( ".portfolio-item:nth-child(2)" ) );
  }


  if ($(window).width() < 991) {
   $( "#filter-reset" ).insertBefore( $( "#filter-submit" ) );
   $( "#filter-container .col-md-8" ).insertBefore( $( "#make-your-tour" ) );

      //alert("hi");
  }

  if ($(window).width() < 767){
    $( ".notes" ).insertBefore( $( "#recaptcha" ) );
  }

  });

    $("#input-11").rating({
      starCaptions: {0: "Not Rated",1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
      starCaptionClasses: {0: "text-danger", 1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
    });

    $("#input-13").on("rating.clear", function(event) {
      $('#rating-notification-message').attr('data-notify-type','error').attr('data-notify-msg', 'Your rating is reset');
      SEMICOLON.widget.notifications( jQuery('#rating-notification-message') );
    });
    $("#input-13").on("rating.change", function(event, value, caption) {
      $('#rating-notification-message').attr('data-notify-msg', 'You rated: ' + value + ' Stars');
      SEMICOLON.widget.notifications( jQuery('#rating-notification-message') );
    });

    $("#input-14").on("rating.change", function(event, value, caption) {
        $("#input-11").rating("refresh", {disabled: true, showClear: false});
    });
    $(".range_13").ionRangeSlider({
      type: "double",
      grid: true,
      min: 0,
      max: 10000,
      from: 1000,
      prefix: "$"
    });
    $(".range_13").on("change", function () {
      var $this = $(this),
          from = $this.data("from"),
          to = $this.data("to");
          $('#min_price').val(from);
          $('#max_price').val(to);
    });
    $( document ).ready(function() {
      var $this = $(".range_13"),
          from = $this.data("from"),
          to = $this.data("to");
          $('#min_price').val(from);
          $('#max_price').val(to);
    });
    $('.travel-date-group').datepicker({
      autoclose: true,
      format: "dd-mm-yyyy",
    });

    $('#validBeforeDatepicker,#validAfterDatepicker').datepicker();











