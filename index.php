<html>
<head>
    <title>SATExercise - Practice real SAT questions with friends!</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <script type="text/javascript" src="js/jquery2.js"></script>
    <script type="text/javascript" src="js/homepage.js"></script>
    <script type="text/javascript" src="js/create.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="container">
        <div id="options">
            <div id="create">
                <div class="title">create</div>
            </div>
            <div id="join">
                <div class="title">join</div>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div id="display-welcome">
            <div class="content">
                <h2>OUR PURPOSE</h2>
                <img src="images/sat_dood.jpg" alt="Studying for the SAT" width="150px" height="120px" class="pic_f" />
                
                <p>Welcome to <b>SATExercise.com</b>! Like others, you're probably taking the initiative to study for the SAT so you can make a good score; however, sometimes studying by yourself can be troublesome. You might get bored, or you might need help solving a problem.
                </p>
                
                <p>
                    So, this leads us to the purpose of our website. <b>SATExercise.com</b> aims to help you improve your score through studying, while eliminating the "boring" factor! Our website allows you to create "study groups."
                    You can invite friends or family to join your study group, allowing you to solve problems <i>with</i> them. These study groups are customizable, allowing you to choose how much time you should have per question, and what type of questions you want to include. (More options soon)
                </p>
                
                <p>
                    And if you're going to work with friends, you're going to need tools that let you communicate effectively. These tools include: drawing pads where you can write your work for your friends to see; chat area where you can ask questions and share information; highlighters; more coming soon!
                </p>
                
                <h2>WILL YOU ADD...?</h2>
                
                <p>
                    This website is in the <b>alpha</b> stages, meaning it is still in early development. This means some things might not yet be added or completed. But, if you see something missing that would improve
                    your experience here, please feel free to suggest it!
                </p>
                
                <p>
                    If you wish to suggestions & feedback, contact us at <i>satexerciseofficial@gmail.com</i>. We will try to respond to you within 24 hours!
                </p>
                
                <h2>WHAT'S HAPPENING?</h2>
                
                <p>
                    <a class="twitter-timeline"  href="https://twitter.com/SATExercise" data-widget-id="518244254355697665">Tweets by @SATExercise</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </p>
                
                <div class="clear"></div>
            </div>
        </div>
        
        <div id="display-create" class="hidden">
            <div class="content">
                <h2>CREATE A STUDY GROUP</h2>
                
                <div name="error" class="steperror"></div>
                
                <div name="step-1" class="step">
                    <div class="title">
                        Step 1 - Give your group a name
                    </div>
                    
                    <div class="content">
                        <input type="text" name="group_name" maxlength="30" placeholder="Group Name" class="large" />
                    </div>
                    
                    <div class="clear"></div>
                </div>
                
                <!-- STEP 2 -->
                
                <div name="step-2" class="step">
                    <div class="title">
                        Step 2 - Areas to study
                    </div>
                    
                    <div class="content">
                        <table>
                            <tr>
                                <td><input type="checkbox" name="cat-1" checked /></td>
                                <td>Math</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cat-2" checked /></td>
                                <td>Sentence Completion</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cat-3" checked /></td>
                                <td>Improving Sentences</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cat-4" checked /></td>
                                <td>Identifying Sentence Errors</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="clear"></div>
                </div>
                
                <!-- STEP 3 -->
                
                <div name="step-3" class="step">
                    <div class="title">
                        Step 3 - Question Timer
                    </div>
                    
                    <div class="content">
                        You can set a maximum time limit per question. If there is no timer, then <b>66%</b> the people in your group must submit an answer to go to the next question.
                        <br/><br/>
                        <select name="timer" class="large">
                            <option value="0">No timer</option>
                            <option value="1">1 Minute</option>
                            <option value="2">2 Minutes</option>
                            <option value="3">3 Minutes</option>
                            <option value="4">4 Minutes</option>
                            <option value="5">5 Minutes</option>
                        </select>
                    </div>
                    
                    <div class="clear"></div>
                </div>
                
                <!-- STEP 4 -->
                
                <div name="step-4" class="step">
                    <div class="title">
                        Step 4 - Privacy
                    </div>
                    
                    <div class="content">
                        SATExercise.com has a join feature that will put anyone looking for a study group into an existing one. If you don't want people you don't know joining your group, then you can restrict your privacy by checking the box below.
                        <br/><br/>
                        <input type="checkbox" name="privacy" /> I want only people I invite to join my group
                    </div>
                    
                    <button name="complete">Complete</button>
                    <div class="clear"></div>
                </div>
                
                <!-- COMPLETE -->
                
                <div name="completed" class="step hidden">
                    <div class="title">
                        Done!
                    </div>
                    
                    <div class="content">
                        Your study group has successfully been created! To invite people, share the following link:
                        <br/><br/>
                        <input type="text" name="shareURL" class="large" />
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        
        <div id="display-join" class="hidden">
            <div class="content">
                <h2>JOIN EXISTING GROUP</h2>
                <p>Coming soon! Until this feature exists, you can have your friend invite you to his or her study group, or create your own!</p>
            </div>
        </div>
        
        <div id="footer">
            <div class="content">
                Copyright &copy; 2014 SATExercise.com<br/>
                <i>satexerciseofficial@gmail.com</i>
            </div>
        </div>
    </div>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-55389904-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>