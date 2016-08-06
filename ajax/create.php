<?php
    require('../includes/config.php');
    require('../includes/database.php');
   
    $db = new database($db_host, $db_name, $db_user, $db_password);
    
    if(isset($_POST['name']) && isset($_POST['time']) && isset($_POST['privacy']) && isset($_POST['types'])){
        $name = $_POST['name'];
        $time = $_POST['time'];
        $privacy = ($_POST['privacy'] == 'false') ? 0 : 1;
        $types = $_POST['types'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if(strlen($name) > 0 && strlen($name) <= 25 && validTypes($types) && in_array($time, array(0,1,2,3,4,5))){
            //ok, seems like everything is valid
            
            @$db->processQuery("SELECT * FROM `groups` WHERE `creator` = ? AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) < `date_created` LIMIT 1", array(
                $ip
            ));
            
            if($db->getRowCount() <= 0){
                //generate hash
                $hash = substr(sha1(mt_rand() . microtime()), mt_rand(0,25), 9);

                //convert types to string for storage
                $types = implode(',',$types);

                @$db->processQuery("INSERT INTO `groups` VALUES (null, ?, ?, ?, NOW(), ?, 0, 0, ?, ?)", array(
                    $ip,
                    $name,
                    $hash,
                    $types,
                    $privacy,
                    $time
                ));

                if($db->getRowCount() > 0){
                    echo json_encode(array(
                        'type' => 'success',
                        'message' => $hash
                    ));
                }else{
                    echo json_encode(array(
                        'type' => 'fail',
                        'message' => 'Could not create group. Please try again!'
                    ));
                }
           }else{
               echo json_encode(array(
                   'type' => 'fail',
                   'message' => 'You can only create a group once per five minutes.'
               ));
           }
        }
    }
    
    function validTypes(array $types){
        $valid = true;
        
        foreach($types as $type){
            if(!in_array($type, array(1,2,3,4)))
                $valid = false;
        }
        
        return $valid;
    }
?>