$(document).ready(function(){
    $('button[name="add"]').click(function(){
        var extra_info = $('textarea[name="extra_info"]');
        var question = $('textarea[name="question"]');
        var difficulty = $('select[name="difficulty"]');
        var a1 = $('div[name="answer-1"] input[name="answer"]');
        var a2 = $('div[name="answer-2"] input[name="answer"]');
        var a3 = $('div[name="answer-3"] input[name="answer"]');
        var a4 = $('div[name="answer-4"] input[name="answer"]');
        var a5 = $('div[name="answer-5"] input[name="answer"]');
        var solution = $('div[name|="answer"] input[name="solution"]:checked');
        var category = $('select[name="category"]');
        
        $.ajax({
            url : '../ajax/addQuestion.php',
            type : 'POST',
            data : {
                extra_info : extra_info.val(),
                question : question.val(),
                difficulty : difficulty.val(),
                a1 : a1.val(),
                a2 : a2.val(),
                a3 : a3.val(),
                a4 : a4.val(),
                a5 : a5.val(),
                solution : solution.val(),
                category : category.val()
            },
            success: function(m){
                if(m == 'success'){
                    extra_info.val('');
                    question.val('');
                    difficulty.prop('selectedIndex',0);
                    a1.val('');
                    a2.val('');
                    a3.val('');
                    a4.val('');
                    a5.val('');
                    solution.prop('checked', false);
                    category.prop('selectedIndex',0);
                }else{
                    alert('Fail');
                }
            }
        });
    });
});