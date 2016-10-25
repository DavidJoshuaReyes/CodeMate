<?php
    $url = "https://web.njit.edu/~dmr37/python.php";

  
    
    $values = array(
        'username' => 'jaga',
        'questionid' => 59,
		'testname' => 'RecurTest',
        'SourceCode' => 'public int factorialRecur(int n) { if(n == 0) { return 1; } return factorialRecur(n-1) * n; }'
	);
    
	

    //open connection
    $ch = curl_init();

    //create post
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($values));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

    //execute curl
    $results = curl_exec($ch);
    //close connection
    curl_close($ch);


    echo $results;
    

?>
