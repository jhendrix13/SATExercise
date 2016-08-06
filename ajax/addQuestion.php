<?php
    require('../includes/config.php');
    require('../includes/database.php');
   
    $db = new database($db_host, $db_name, $db_user, $db_password);
    
    $extra_info = $_POST['extra_info'];
    $question = $_POST['question'];
    $difficulty = $_POST['difficulty'];
    $ans = array(
        1 => $_POST['a1'],
        2 => $_POST['a2'],
        3 => $_POST['a3'],
        4 => $_POST['a4'],
        5 => $_POST['a5']
    );
    
    $solution = (int)$_POST['solution'];
    $cat = $_POST['category'];
    
    if(in_array($solution, array(1,2,3,4,5)) && in_array($difficulty, array(1,2,3,4,5))){
        //insert answers
        $db->processQuery("INSERT INTO `answers` VALUES (null, ?)", array($ans[1]));
            $a1 = $db->getInsertId();
        $db->processQuery("INSERT INTO `answers` VALUES (null, ?)", array($ans[2]));
            $a2 = $db->getInsertId();
        $db->processQuery("INSERT INTO `answers` VALUES (null, ?)", array($ans[3]));
            $a3 = $db->getInsertId();
        $db->processQuery("INSERT INTO `answers` VALUES (null, ?)", array($ans[4]));
            $a4 = $db->getInsertId();
        $db->processQuery("INSERT INTO `answers` VALUES (null, ?)", array($ans[5]));
            $a5 = $db->getInsertId();
            
        //ID to correct answer
        $solution_answerID = 0;
        
        switch($solution){
            case 1:
                $solution_answerID = $a1;
                break;
            case 2:
                $solution_answerID = $a2;
                break;
            case 3:
                $solution_answerID = $a3;
                break;
            case 4:
                $solution_answerID = $a4;
                break;
            case 5:
                $solution_answerID = $a5;
                break;
        }
        
        //insert question
        @$db->processQuery("INSERT INTO `questions` VALUES (null, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0)", array(
            $cat,
            nl2br($extra_info),
            nl2br($question),
            $difficulty,
            $a1,
            $a2,
            $a3,
            $a4,
            $a5,
            "",
            "",
            $solution_answerID
        ));
        
        echo 'success';
    }

?>
