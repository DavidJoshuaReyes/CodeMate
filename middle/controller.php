<?php

    function post_to_url($url, $data) {

       $post = curl_init();

       curl_setopt($post, CURLOPT_URL, $url);
       curl_setopt($post, CURLOPT_POST, true);
       curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
       curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

       $result = curl_exec($post);

       curl_close($post);
       return $result;
    }

    $backendURL = 'https://web.njit.edu/~jt275/database.php';
    $grader = 'https://web.njit.edu/~dmr37/python.php';
    $code = $_POST['code'];

    if($code == 2) { // add a user

    }
    elseif($code == 3) {

        $payload = array (
            code => 3
            );
        $response = post_to_url($backendURL, $payload);
        echo $response;

    }
    elseif($code == 4) { // get question names
        $response = post_to_url($backendURL, $_POST);
        printf($response);
    }
    elseif($code == 5) { // Add question

        $insertRows = 0;

        $payload5 = array(
            code => $code,
            question => $_POST['question'],
            returnType => $_POST['returnType'],
            filter1 => $_POST['filter1'],
            filter2 => $_POST['filter2']
            );

        $questionId = intval(post_to_url($backendURL, $payload5 ));
        printf($questionId);
        $insertRows++;

        if(isset($_POST['inout']) == true){
            $inout = $_POST['inout'];
            for($x = 0; $x < count($inout); $x++){
                $payload7 = $inout[$x];
                $payload7['code'] = "7";
                $payload7['id'] = $questionId;
                print_r($payload7);
                $resp = post_to_url($backendURL, $payload7);
                $insertRows++;
            }
        }

        if(isset($_POST['conditions']) == true){
            $cond = $_POST['conditions'];
            for($x = 0; $x < count($cond); $x++){
                $payload9 = $cond[$x];
                $payload9['code'] = "9";
                $payload9['id'] = $questionId;
                print_r($payload9);
                $resp = post_to_url($backendURL, $payload9);
                $insertRows++;
            }
        }

        printf($insertRows);

    }
    elseif ($code == 11) { // student answer submission

      $answers = $_POST['answers'];
      for($i = 0; $i < count($answers); $i++){
        $payload = $answers[$i];
        $payload['code'] = 11;
        //print_r($payload);
        $resp = post_to_url($grader, $payload);
        printf($resp);
      }

    }
    elseif($code == 13) {

        $payload = array (
            code => 13
            );

        $resp = post_to_url($backendURL, $payload);
        echo $resp;

    }
    elseif($code == 14) {

        $payloadTest = array (
            code => 14,
            testname => $_POST['testname'],
            questions => $_POST['questions']
            );

        $payloadTestStudent = array(
            code => 16,
            username => $_POST['username'],
            test => $_POST['testname']
            );

        $resp1 = post_to_url($backendURL, $payloadTest);
        $resp2 = post_to_url($backendURL, $payloadTestStudent);

        echo $resp1 . $resp2;
    }
    elseif($code == 15){

        $payloadTest = array(
            code => 15,
            testname => $_POST['testname']
            );

        $response = post_to_url($backendURL, $payloadTest);
        $resp = json_decode($response,true);


        $testquestions = array();
        $questions = $resp[0]['VCHQUESTIONS'];

        $payload4 = array(
            code => 4,
            questionid => $questions
            );

        $getQuestions = post_to_url($backendURL, $payload4);


        echo $getQuestions;

    }
    elseif($code == 17){  // get list of test for student
        $payloadStudent = array(
            code => $code,
            username => $_POST['username']
            );
        $test = post_to_url($backendURL, $payloadStudent);
        echo $test;
    }
    elseif($code == 18){ // submit feedback from teacher

        $data = $_POST['teacherResponse'];
        
        
        //print_r($data);
        for($x = 0; $x < count($data); $x++){

          $payload = $data[$x];
          $payload['code'] = 18;
          //$payload['username'] = $_POST['username'];
          //print_r($payload);
          $response = post_to_url($backendURL, $payload);
          printf($response);
        }
    }
    elseif($code == 19){ // teacher get feedback table
    
      $getquestions = array(
        code => 15,
        testname => $_POST['testname']
      );

      //print_r($getquestions);
      $questions = json_decode(post_to_url($backendURL, $getquestions));
      //printf($questions[0]->VCHQUESTIONS);

      $feedback = array(
        code => 10,
        questionid => $questions[0]->VCHQUESTIONS,
        testid => $_POST['testname'],
        username => $_POST['student']
      );

      $returntouser = post_to_url($backendURL, $feedback);
      printf($returntouser);
    }
    elseif($code == '20') {
		$feedback = array(
			code => 19,
			filter1 => $_POST['filter1'],
			filter2 => $_POST['filter2']
		);

		$returntouser = post_to_url($backendURL, $feedback);
		printf($returntouser);
    }
    elseif($code == 'getQuestionTotal'){
        //echo "hello there";
        $questionid = $_POST['questionid'];
        //printf($questionid);
        $query = "SELECT SUM(TOTAL) AS QUESTIONTOTAL FROM (".
          "SELECT NUMPOINTS AS TOTAL FROM TBL_CONDITION WHERE NUMID = ". ($questionid) ." UNION ALL ".
          "SELECT NUMPOINTS AS TOTAL FROM TBL_INPUTOUTPUT WHERE NUMID = " . ($questionid) . ") AS QUESTIONTOTAL";
        // printf($query);
        $payload = array(
           code => 'david',
           query => $query
        );
        $returntouser = post_to_url($backendURL, $payload);
        print_r($returntouser);
    }
    else if($code == 'getInputOutput'){
    	
	$questionid = $_POST['questionid'];
	$payload = array(
		code => 6, 
		questionid => $questionid
	);	
    
	$return = post_to_url($backendURL, $payload);
	printf($return);
    }
    else if($code == 'getCondition'){
    	
	$questionid = $_POST['questionid'];
	$payload = array(
		code => 8, 
		questionid => $questionid
	);
  	
	$return = post_to_url($backendURL, $payload);
	printf($return);
    }

?>
