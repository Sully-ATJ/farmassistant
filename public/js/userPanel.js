$(document).ready(function() {

    /**
     * 
     * jQuery code for swapping main sidebar tabs
     * by default, the home tab is the shown
     */

     $('#menu li a:not(:first)').addClass('inactive');
     $('.page-content').hide();
     $('.page-content:first').show();
   
     $('#menu li a').click(function() {
       var t = $(this).attr('id');
       if ($(this).hasClass('inactive')) { //this is the start of our condition 
         $('#menu li a').addClass('inactive');
         //$('#menu li a').removeClass('lightBtn');
         $(this).removeClass('inactive');
         //$(this).addClass('lightBtn');
   
         $('.page-content').hide();
         $('#' + t + 'C').fadeIn('fast');
       }
     });

     /**
      * 
      * The below function checks the url for params and grabs them
      */
     $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results==null){
         return null;
      }
      else{
         return results[1] || 0;
      }
    }

    /**
     * 
     * if the 'dest' param is null, i.e it is not set
     * the user starts on the home page, otherwise they are rerouted to
     * the targeted tab.
     */
    if ($.urlParam('dest') == null) {
      $('#menu li a:not(:first)').addClass('inactive');
      $('.page-content').hide();
      $('.page-content:first').show();
    
      $('#menu li a').click(function() {
        var t = $(this).attr('id');
        if ($(this).hasClass('inactive')) { //this is the start of our condition 
          $('#menu li a').addClass('inactive');
          $(this).removeClass('inactive');
    
          $('.page-content').hide();
          $('#' + t + 'C').fadeIn('fast');
        }
      });
    }
    else{
      $('#menu li a').addClass('inactive');
      $('#' + $.urlParam('dest') ).removeClass('inactive');
      $('.page-content').hide();
      $('#' + $.urlParam('dest')).fadeIn('fast');
    }

    //check params for error and success messages
    if ($.urlParam('msg') == "nametaken") {
      $('#fname-error').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "farmupdated") {
      $('#farm-updated').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "farmadded") {
      $('#farmadded').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "farmdeleted") {
      $('#farm-deleted').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "movesuccess") {
      $('#movesuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addanimalsuccess") {
      $('#addanimalsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "cownotexist") {
      $('#cownotexist').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "sheepnotexist") {
      $('#sheepnotexist').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "govidupdated") {
      $('#govidupdated').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "localidupdated") {
      $('#localidupdated').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "statusupdated") {
      $('#statusupdated').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "wronggender") {
      $('#wronggender').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addbirthrecsuccess") {
      $('#addbirthrecsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addweightsuccess") {
      $('#addweightsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addvaxsuccess") {
      $('#addvaxsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "moveanimalsuccess") {
      $('#moveanimalsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addmpsuccess") {
      $('#addmpsuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addsalesuccess") {
      $('#addsalesuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "deletesalesuccess") {
      $('#deletesalesuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "addnotesuccess") {
      $('#addnotesuccess').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "deleted-note") {
      $('#deleted-note').fadeIn().delay(3000).fadeOut();
    }
    else if ($.urlParam('msg') == "pwdchngsuccess") {
      $('#pwdchngsuccess').fadeIn().delay(3000).fadeOut();
    }
    



    /**
     * 
     * jQuery code for swapping tabs in the Farm side tab
     */
     $('#f-tabs li a:not(:first)').addClass('inactive');
     $('.f-container').hide();
     $('.f-container:first').show();
     $('#f-tabs li a').click(function(){
       var t = $(this).attr('id');
     
       if($(this).hasClass('inactive')){ //this is the start of our condition 
         $('#f-tabs li a').addClass('inactive');           
         $(this).removeClass('inactive');
     
         $('.f-container').hide();
         $('#'+ t + 'C').fadeIn('slow');
      }
     });
    
    /**
     * 
     * jQuery code for swapping tabs in the cow registry side tab
     */
    $('#c-tabs li a:not(:first)').addClass('inactive');
    $('.container').hide();
    $('.container:first').show();
    $('#c-tabs li a').click(function(){
      var t = $(this).attr('id');
    
      if($(this).hasClass('inactive')){ //this is the start of our condition 
        $('#c-tabs li a').addClass('inactive');           
        $(this).removeClass('inactive');
    
        $('.container').hide();
        $('#'+ t + 'C').fadeIn('slow');
     }
    });


    /**
     * 
     * jQuery code for swapping between tabs in sheep registry
     * tab
     */
    $('#s-tabs li a:not(:first)').addClass('inactive');
    $('.s-container').hide();
    $('.s-container:first').show();
    $('#s-tabs li a').click(function(){
      var t = $(this).attr('id');
    
      if($(this).hasClass('inactive')){ //this is the start of our condition 
        $('#s-tabs li a').addClass('inactive');           
        $(this).removeClass('inactive');
    
        $('.s-container').hide();
        $('#'+ t + 'C').fadeIn('slow');
     }
    });

     /**
     * 
     * jQuery code for swapping tabs in the milk production side tab
     */
      $('#mp-tabs li a:not(:first)').addClass('inactive');
      $('.mp-container').hide();
      $('.mp-container:first').show();
      $('#mp-tabs li a').click(function(){
        var t = $(this).attr('id');
      
        if($(this).hasClass('inactive')){ //this is the start of our condition 
          $('#mp-tabs li a').addClass('inactive');           
          $(this).removeClass('inactive');
      
          $('.mp-container').hide();
          $('#'+ t + 'C').fadeIn('slow');
       }
      });

    /**
     * 
     * jQuery code for swapping tabs in the Sales side tab
     */
       $('#sales-tabs li a:not(:first)').addClass('inactive');
       $('.sales-container').hide();
       $('.sales-container:first').show();
       $('#sales-tabs li a').click(function(){
         var t = $(this).attr('id');
       
         if($(this).hasClass('inactive')){ //this is the start of our condition 
           $('#sales-tabs li a').addClass('inactive');           
           $(this).removeClass('inactive');
       
           $('.sales-container').hide();
           $('#'+ t + 'C').fadeIn('slow');
        }
       });


    /**
     * 
     * jQuery code and ajax call for displaying information in  Cow modal
     */
    
    $('.viewBtnC').on('click',function(){
      var cowGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getCowInfo.inc.php',
        type: 'post',
        data: {cowGovId:cowGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#myCowModal').css("display","block");
        }
      });
    });

    $('.viewBtnC2').on('click',function(){
      var cowGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getSoldCowsInfo.inc.php',
        type: 'post',
        data: {cowGovId:cowGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#myCowModal').css("display","block");
        }
      });
    });
    
    $('.viewBtnC3').on('click',function(){
      var cowGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getDeadCowsInfo.inc.php',
        type: 'post',
        data: {cowGovId:cowGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#myCowModal').css("display","block");
        }
      });
    });

    $('.closeBtn1').on('click',function(){
      $('#myCowModal').css("display","none");
    });
    $(window).on('click',function(event){
      if (event.target == $('#myCowModal')) {
        $('#myCowModal').css("display","none");
      }
    });

    /**
     * 
     * jQuery code and ajax for displaying information in  Sheep modal
     */
     $('.viewBtnS').on('click',function(){
      var sheepGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getSheepInfo.inc.php',
        type: 'post',
        data: {sheepGovId:sheepGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#mySheepModal').css("display","block");
        }
      });
    });
    $('.viewBtnS2').on('click',function(){
      var sheepGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getSoldSheepInfo.inc.php',
        type: 'post',
        data: {sheepGovId:sheepGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#mySheepModal').css("display","block");
        }
      });
    });
    $('.viewBtnS3').on('click',function(){
      var sheepGovId = $(this).attr("data-id");

      //AJAX request
      $.ajax({
        url:'/farmassistant/src/FormHandlers/read/getDeadSheepInfo.inc.php',
        type: 'post',
        data: {sheepGovId:sheepGovId},
        success: function(response){
          $('.modal-body').html(response);
          $('#mySheepModal').css("display","block");
        }
      });
    });
    $('.closeBtn2').on('click',function(){
      $('#mySheepModal').css("display","none");
    });
    $(window).on('click',function(event){
      if (event.target == $('#mySheepModal')) {
        $('#mySheepModal').css("display","none");
      }
    });
});

