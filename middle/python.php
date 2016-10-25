<?php


$questionid = $_POST["questionid"];
$source = $_POST["SourceCode"];
$username = $_POST["username"];
$testname = $_POST["testname"];

$file = fopen("source.txt","w");
fwrite($file, $source);
fclose($file);
//===========================

$questionValues = array(
	'code' => '4',
	'questionid' => $questionid
);
$question = curlToDatabase($questionValues);
//print_r($question);

$inputOutputValues  = array(
	'code' => '6',
	'questionid' => $questionid
);
$inputOutput = curlToDatabase($inputOutputValues);
//print_r($inputOutput);

$conditionValues = array(
	'code' => '8',
	'questionid' => $questionid
);
$conditionValues = curlToDatabase($conditionValues);
//===========================



$points = 0;
$reportString = "";

//print_r($question);
$string = "python JavaParser.py source.txt ".($question[0]->VCHRETURNTYPE)." ";

$executeString = "";



foreach($inputOutput as $row) { // write inputs to file so that the puthon can grab from it
	//($row->VCHINPUT);
	
	
	$filein = fopen("input.txt", "w");
	fwrite($filein, $row->VCHINPUT);
	fclose($filein);
		
		
	
	$executeString = $string."input.txt";
	//echo $executeString."@@@@@@@@@@@@";
	
	$x = shell_exec($executeString);
	//echo "@@@@".$x."~~~~~~~~~~~~~~~~~~`";
	$y = str_replace("'", "\"", $x);
	$decodedResults = json_decode($y);
	//print_r($decodedResults);
	


	$input = $row->VCHINPUT;
	$expectedOutput = $row->VCHOUTPUT;
	$gottenOutput = $decodedResults[0]->output;
	$reportString = $reportString.$input."=".$gottenOutput."|";

	if($expectedOutput == $gottenOutput) {
		$points = $points + $row->NUMPOINTS;
	}
}




//print_r($inputOutput);

//echo $executeString;
$verifyfilein = fopen("input.txt", "w");
fwrite($verifyfilein, $inputOutput[0]->VCHINPUT);
fclose($verifyfilein);

//Verify functionName and Params
$results = shell_exec($string."input.txt");
//print_r($results);
$fixResults = str_replace("'", "\"", $results);
$decodedResults = json_decode($fixResults);
//print_r($decodedResults);



foreach($decodedResults as $result) {
	foreach($result as $key=>$value) {
		if($key != "functionName" && $key != "input" && $key != "output") {
			foreach($conditionValues as $row) {
				if($key == $row->VCHCONDITION) {
					$points = $points + ($row->NUMPOINTS);
				}
			}
			$reportString = $reportString.$key."=".$value."|";
		}elseif($key == "functionName"){
			foreach($conditionValues as $row) {
				if($value == $row->VCHVALUE) {
					$points = $points + ($row->NUMPOINTS);
				}
			}
		}
	}
}


$functionName = $decodedResults[0]->functionName;
$reportString = $reportString."FunctionName=".$functionName;


$insertFeedBack = array(
	'code' => '21',
	'questionid' => $questionid,
);
$questionType = curlToDatabase($insertFeedBack);
//print_r($questionType);
if($questionType[0] -> VCHVALUE == "Type: Loops") {
	$cmd = "python sourcePointAdjuster.py source.txt ".$question[0]->VCHRETURNTYPE." loop";
	$x = shell_exec($cmd);
	
	if($x > 0) {
		//echo $questionType[0]->NUMPOINTS;
		$points = $points + $questionType[0]->NUMPOINTS;
		$reportString = $reportString."|LOOPS"."="."VALID";
		
	}
	else {
		$reportString = $reportString."|LOOPS"."="."INVALID";
	}
}
elseif($questionType[0] -> VCHVALUE == "Type: Recursion") {
	$cmd = "python sourcePointAdjuster.py source.txt ".$question[0]->VCHRETURNTYPE." recur";
	$x = shell_exec($cmd);
	
	//echo $x;
	
	if($x > 1) {
		$points = $points + ($questionType[0]->NUMPOINTS);
		$reportString = $reportString."|RECURSION"."="."VALID";
	}
	else {
		$reportString = $reportString."|RECURSION"."="."INVALID";
	}
}



//echo "~~~~~~~~~~~~~~~~~~~~~";
echo "@@@@@@@@@@".$username."|".$questionid."|".$source."|".$points."|".$reportString;

//clear out old data
$insertFeedBack = array(
	'code' => '20',
	'questionid' => $questionid,
	'username' => $username
);
curlToDatabase($insertFeedBack);


$insertFeedBack = array(
	'code' => '11',
	'username' => $username,
	'questionid' => $questionid,
	'testid' => $testname,
	'studentanswer' => $source,
	'score' => $points,
	'points' => $reportString
);
//print_r($insertFeedBack);
curlToDatabase($insertFeedBack);


function curlToDatabase($values) {
	$url = "https://web.njit.edu/~jt275/database.php";

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


    //echo $results;
    //echo "Jaga";
  
    return json_decode($results);

}


?>
