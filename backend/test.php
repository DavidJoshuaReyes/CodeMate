<?php
	$url = "https://web.njit.edu/~jt275/database.php";
    
    $values = array(
        'code' => '21',
        'questionid' => '57'
       );
    foreach($values as $key=>$value) { $value_string .= $key.'='.$value.'&'; }
    rtrim($value_string, '&');


    //open connection
    $ch = curl_init();
    
    //create post
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $value_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    
    //execute curl
    $results = curl_exec($ch);


    //close connection
    curl_close($ch);

    echo $results;

?>
