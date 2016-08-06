$(document).ready(function(){
    var timerTimeout = false;
    var alreadyLoaded = false;
    var currentAnswer = false;
    var correctAnswer = false;
    var lastChatMessage = 0;
    var votedToSkip = false;
    
    var currentQuestion = {};
    
    //init connection to the server
    var client = io.connect('http://localhost:466');
    //var client = io.connect('http://212.1.213.193:466');
    
    client.on('connect', function(){
        console.log('Connected');
        setLMessage('Connected, preparing . . .');
        
        client.emit('join', {groupID : groupID});
    });
    client.on('test', function(data){console.log(data)});
    client.on('anError', setEMessage);
    client.on('ready', ready);
    client.on('setQuestion', setQuestion);
    client.on('answerData', updateAnswerStats);
    client.on('correctAnswer', markCorrectAnswer);
    client.on('timer', setTimer);
    client.on('endTimer', endTimer);
    client.on('newChatMessage', function(data){
        updateChat(data.username, data.message);
    });
    client.on('disconnect', function(){
        console.log('Disconnected from server ...');
    });
    
    function ready(data){
        if(!alreadyLoaded){
            $('div[name="group_name"]').text(data.name);
            $('#loadingScreen').hide();
            $('#theContent').show();
            sketchpad();
            alreadyLoaded = true;
        }
    }
    
    function setQuestion(data){
        //clean up, as if the previous question were never here!
        if(currentAnswer && correctAnswer){
            $('#answers tr').removeClass('selected');
            $('#answers tr').removeClass('correct');

            $('#answers tr[name="answer-'+ correctAnswer +'"]').children('td').eq(0).text(correctAnswer.toUpperCase());

            if(correctAnswer != currentAnswer)
                $('#answers tr[name="answer-'+ currentAnswer +'"]').children('td').eq(0).text(currentAnswer.toUpperCase());
        }

        
        //continue...
        correctAnswer = false;
        currentQuestion = data;
        votedToSkip = false;
        
        //change BBCode to HTML, etc
        var questionHTML = htmlFormat(data.q.question);
        var extra_infoHTML = htmlFormat(data.q.extra_info);
        
        //append extra buttons/html
        questionHTML += '<div id="questionToolbit"><button name="skip" class="toolbit">Vote to Skip</button></div>';
        
        $('#question_box div[name="question_info"]').html(data.q.category +' &bull; Difficulty '+ data.q.difficulty);
        $('#question_box div[name="question_data"]').html(extra_infoHTML);
        $('#question_box div[name="question"]').html(questionHTML);
        
        var corresponding = ['a', 'b', 'c', 'd', 'e'];
        for(var i = 0; i < data.answers.length; i++){
            $('#answers tr[name="answer-'+ corresponding[i] +'"]').children('td').eq(1).text(data.answers[i]);
        }
        
        //mathjax the math, yeaaah!
        MathJax.Hub.Queue(["Typeset",MathJax.Hub,["question_box", "answers"]]);
        
        //group statistics
        var correct = data.stats.amount_correct;
        var total = data.stats.total_answered;
        var percent_correct;
        
        if(total == 0 || correct == 0)
            percent_correct = 0;
        else
            percent_correct = Math.round((correct/total)*100);
        
        $('#stats td[name="percent_correct"]').html('<b>'+percent_correct+'%</b> correct out of <b>'+ nF(total) +'</b> questions answered.');
    }
    
    function setLMessage(message){
        $('#loadingScreen div[name="message"]').text(message);
    }
    
    function setEMessage(message){
        $('#loadingScreen div[name="message"]').text(message);
        $('#theContent').hide();
        $('#loadingScreen').show();
    }
    
    function setTimer(seconds){
        var time = seconds;
        
        if(seconds > 0){
            if(seconds >= 60)
                time = (time/60).toFixed(0)+'m';
            else
                time = seconds+'s';
            
            $('#timer div[name="time"]').text(time);
            $('#timer').show();
            
            timerTimeout = setTimeout(function(){
                setTimer(seconds-1);
            },1000);
        }else{
            $('#timer').hide();
        }
    }
    
    function endTimer(){
        clearTimeout(timerTimeout);
        $('#timer').hide();
    }
    
    function updateChat(username, message){
        $('#messages').prepend('<div class="message"><b>'+ htmlEnc(username) +':</b> '+ chatFormat(htmlEnc(message)) +'</div>');
        
        //mathjax the math, yeaaah!
        MathJax.Hub.Queue(["Typeset",MathJax.Hub,["messages"]]);
    }
    
    function sendChatMessage(){
        var input = $('#chat input[name="chat_input"]');
        var message = input.val().trim();
            
        var time = new Date().getTime();
        
        if(message.length > 0 && (time-lastChatMessage) >= 1500){
            client.emit('chatMessage', message);
            updateChat('you', message);
            input.val('');
            
            lastChatMessage = time;
        }
    }
    
    function sendAnswer(){
        if(!correctAnswer){
            var answer = $(this).attr('name').split('-')[1];
            currentAnswer = answer;
            client.emit('answer', answer);

            $('#answers tr').removeClass('selected');
            $('#answers tr[name="answer-'+ answer +'"]').addClass('selected');
        }
    }
    
    function markCorrectAnswer(answer){
        correctAnswer = answer;
        
        $('#answers tr[name="answer-'+ answer +'"]').children('td').eq(0).html(
            '<img src="images/correct.png" style="width:30px;height:30px;" />'
        );
        
        if(answer != currentAnswer){
            $('#answers tr[name="answer-'+ currentAnswer +'"]').children('td').eq(0).html(
                '<img src="images/incorrect.png" style="width:30px;height:30px;" />'
            );
        }
    }
    
    function updateAnswerStats(data){
        var a = data.a;
        var b = data.b;
        var c = data.c;
        var d = data.d;
        var e = data.e;
        var totalAnswers = a+b+c+d+e;
        var withoutAnswers = (data.clients-totalAnswers);
            withoutAnswers = (withoutAnswers <= 0) ? 0 : withoutAnswers;
        
        var chartData = google.visualization.arrayToDataTable([
            ['Answer', 'Chosen'],
            ['No Answer', withoutAnswers],
            ['A', a],
            ['B', b],
            ['C', c],
            ['D', d],
            ['E', e]
        ]);

        options = {
            title : 'Answers',
            legend : 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('percentbox'));

        chart.draw(chartData, options);
    }
    
    function htmlFormat(text){
        text = text.replace(/\[u\](.+?)\[\/u\]/igm, '<u>$1</u>');
        text = text.replace(/\[b\](.+?)\[\/b\]/igm, '<b>$1</b>');
        text = text.replace(/\[i\](.+?)\[\/i\]/igm, '<i>$1</i>');
        text = text.replace(/\[ol\]([^~,]+?)\[\/ol\]/igm, '<ol type="I">$1</ol>');
        text = text.replace(/^\*(.+?)$/igm, '<li>$1</li>');
        text = text.replace(/(\-\*)/igm, '-------');
        text = text.replace(/\[center\](.+?)\[\/center\]/igm, '<center>$1</center>');
        text = text.replace(/\[img\](.+?):(.+?)\[\/img\]/igm, '<img src="images/$1/$2" />');
        text = text.replace(/~(.+?):(.+?)~/igm, '\\( \\mathop{\\underline{\\text{$1}}}\\limits_{\\hbox{$2}} \\)');
        
        return text;
    }
    
    function chatFormat(text){
        text = text.replace('\\', '');
        text = text.replace(/\[f\](.+?)\/(.+?)\[\/f\]/igm, '\\( \\frac{\\text{$1}}{\\text{$2}} \\)');
        text = text.replace(/\[eq\](.+?)\[\/eq\]/igm, '\\( $1 \\)');
        text = text.replace(/ (.+?)\^(.+?) /igm, '\\( {\\text{$1}}^{\\text{$2}} \\)');
        text = text.replace(/\[sqrt\](.+?)\[\/sqrt\]/igm, '\\( \\sqrt{\\text{$1}} \\)');
        
        return text;
    }
    
    //make user-input safe for displaying
    function htmlEnc(s) {
        return s.replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/'/g, '&#39;')
            .replace(/"/g, '&#34;');
    }
    
    //credits: http://stackoverflow.com/a/2901298/1748664
    nF = function(x) {
            return Math.round(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    //http://stackoverflow.com/questions/10730362/javascript-get-cookie-by-name
    getCookie = function(name){
        var parts = document.cookie.split(name + "=");
        if(parts.length == 2) {
            return parts.pop().split(";").shift();
        }
        return false;
    }
    
    //http://stackoverflow.com/a/9964945
    $.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}
    
    //chatbox
    $(document).on('click', '#chat input[name="chat_submit"]', sendChatMessage);
    $('#chat input[name="chat_input"]').enterKey(sendChatMessage);
    $('a[name="chathelp"]').click(function(e){
        e.preventDefault();
        
        $('div[name="chatbox"]').toggle(0);
        $('#messages').toggle(0);
        $('#help').toggle(0);
    });
    
    //skip question
    $(document).on('click', '#questionToolbit button[name="skip"]', function(){
        if(!votedToSkip && confirm('Are you sure you wish to vote to skip this question?')){
            client.emit('skip', true);
            $(this).html('<i>Voted</i>');
            votedToSkip = true;
        }
    });
    
    //submit answer
    $(document).on('click', '#answers tr[name|="answer"]', sendAnswer);
});