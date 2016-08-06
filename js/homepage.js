$(document).ready(function(){
    var create = false;
    var join = false;
    
    $('#create').click(function(){
        create = !create;
        join = false;
        myToggle('create', create);
    });
    $('#join').click(function(){
        join = !join;
        create = false;
        myToggle('join', join);
    });
    
    function myToggle(selector, open){
        $('#options div').removeClass('selected');
        $('div[id|="display"]').hide();
        
        if(open){
            $('#display-'+ selector).show();
            $('#'+ selector).addClass('selected');
        }else{
            $('#display-welcome').show();
        }
    }
});