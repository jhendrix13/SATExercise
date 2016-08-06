<?php
    require('../includes/config.php');
    require('../includes/database.php');
   
    $db = new database($db_host, $db_name, $db_user, $db_password);
?>
<html>
<head>
    <title>SAT</title>
    <link rel="stylesheet" type="text/css" href="../style/main.css">
    <script type="text/javascript" src="../js/jquery2.js"></script>
    <script type="text/javascript" src="../js/add.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="container">
        
        <div id="display-admin">
            <div class="content">
                <h2>ADD QUESTION TO DATABASE</h2>
                
                <!-- LIST OF BBCODES -->
                <div class="smalltext">
                    i[filename.png] table[h1:{var1,var2...},h2:{...}]
                </div>
                
                <br/>
                <textarea name="extra_info" style="width:80%;height:150px;font-size:18px;" placeholder="Question data, extra-info"></textarea>
                <br/><br/>
                <textarea name="question" style="width:80%;height:150px;font-size:18px;" placeholder="Question..."></textarea>
                <br/><br/>
                
                <!-- DIFFICULTY LEVEL -->
                <select name="difficulty" class="large">
                    <option value="1">Difficulty 1</option>
                    <option value="2">Difficulty 2</option>
                    <option value="3">Difficulty 3</option>
                    <option value="4">Difficulty 4</option>
                    <option value="5">Difficulty 5</option>
                </select>
                <br/><br/>
                
                <!-- QUESTION CATEGORY -->
                <select name="category" class="large">
                <?php
                    //retrieve all question categories
                    $cats = $db->processQuery("SELECT `id`,`name` FROM `categories` ORDER BY `name` ASC", array(), true);
                    
                    foreach($cats as $cat){
                        ?> 
                            <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                        <?php
                    }
                ?>
                </select>

                <br/><br/>
                
                <!-- POSSIBLE SOLUTIONS -->
                <div name="answer-1" style="margin-bottom:9px;">
                    (A) <input type="radio" name="solution" value="1" /> <input type="text" name="answer" placeholder="Answer 1..." class="large" />
                </div>
                <div name="answer-2" style="margin-bottom:9px;">
                    (B) <input type="radio" name="solution" value="2" /> <input type="text" name="answer" placeholder="Answer 2..." class="large" />
                </div>
                <div name="answer-3" style="margin-bottom:9px;">
                    (C) <input type="radio" name="solution" value="3" /> <input type="text" name="answer" placeholder="Answer 3..." class="large" />
                </div>
                <div name="answer-4" style="margin-bottom:9px;">
                    (D) <input type="radio" name="solution" value="4" /> <input type="text" name="answer" placeholder="Answer 4..." class="large" />
                </div>
                <div name="answer-5" style="margin-bottom:9px;">
                    (E) <input type="radio" name="solution" value="5" /> <input type="text" name="answer" placeholder="Answer 5..." class="large" />
                </div>
                
                <br/><br/>
                <button name="add">Add Question</button>
                
                <div class="clear"></div>
            </div>
        </div>
        
        <div id="footer">
            <div class="content">
                Copyright &copy; 2014 SATStudy.com<br/>
                <i>something@gmail.com</i>
            </div>
        </div>
    </div>
</body>
</html>