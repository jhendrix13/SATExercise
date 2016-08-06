$(document).ready(function(){
   //jQUERY OBJECTS, NOT VALUES!
   var group = $('#display-create input[name="group_name"]');
   var timer = $('#display-create select[name="timer"]');
   var privateCheck = $('#display-create input[name="privacy"]');
   
   
   $('#display-create div[name|="step"] button[name="complete"]').click(function(){
       if(validate()){
           var name = group.val();
           var time = timer.val();
           var isPrivate = privateCheck.is(':checked');
           var questions = [];
           
           //add each category selected
           $('#display-create input[name|="cat"]').each(function(){
               if($(this).is(':checked')){
                    var type = $(this).attr('name').split('-')[1];
                   
                   //valid type?
                    if(!( [1,2,3,4].indexOf(type) != -1 ))
                        questions.push(type);
               }
           });
           
           $.ajax({
               url : 'ajax/create.php',
               type : 'POST',
               data : {
                   name : name,
                   time : time,
                   privacy : isPrivate,
                   types : questions
               },
               success : function(r){
                   r = jQuery.parseJSON(r);
                   if(r.type == 'success') {
                       $('#display-create input[name="shareURL"]').val('http://www.satexercise.com/study.php?g='+ r.message);
                       
                       $('#display-create div[name|="step"],#display-create div[name="error"]').hide();
                       $('#display-create div[name="completed"]').show();
                   }else{
                       $('#display-create div[name="error"]').text(r.message);
                   }
               }
           });
       }
   });
   
   function validate(){
       var status = true;
       
       if(group.val().length > 25 || group.val().length <= 0)
           status = false;
       if(!( [0,1,2,3,4,5].indexOf(timer.val()) == -1 ))
           status = false;
       
       return status;
   }
});