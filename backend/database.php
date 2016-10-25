<?php

$host = "sql1.njit.edu";
$user = "jt275";
$pass = "deferent2";
$db = "jt275";

$dbhandle = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect");

if (mysqli_connect_errno()) { //check if connection is successful
    printf("<br>Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//get url parameter mysql.php?code=1....
$code = $_POST['code'];

if($code == "1") { //Verify username & password login  *this should also return if the user is a student or a teacher*
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT VCHLEVEL FROM TBL_CREDENTIALS WHERE VCHUSERNAME=? AND VCHPASSWORD=?";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "ss", $username, $password);
    mysqli_stmt_execute($pstmt);
    mysqli_stmt_bind_result($pstmt, $queryLevel);
    mysqli_stmt_fetch($pstmt);

    printf($queryLevel);

    /*if(($username == $queryUsername) && ($password == $queryPassword)) {
        echo "true";
    }
    else {
        echo "false";
    }*/
}
elseif($code == "2") { //Add new user

    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $query = "INSERT INTO TBL_CREDENTIALS (VCHUSERNAME, VCHPASSWORD, VCHLEVEL) VALUES (?, ?, ?)";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "sss", $username, $password, $level);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "3") { //Get all student IDs
    $query = "SELECT VCHUSERNAME FROM TBL_CREDENTIALS WHERE VCHLEVEL='Student'";
    generateArrayOfRows($dbhandle, $query);

}
elseif($code == "4") { //Get question
    $questionid = $_POST['questionid'];
    $query = "SELECT * FROM TBL_QUESTIONBANK WHERE NUMID in (".$questionid.")";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "5") { //Add question

    $pstmt = mysqli_stmt_init($dbhandle);

    //increment question counter
    $query = "SELECT NUMQUESTIONCOUNT FROM TBL_QUESTIONCOUNTER";
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_execute($pstmt);
    mysqli_stmt_bind_result($pstmt, $queryCounter);
    mysqli_stmt_fetch($pstmt);

    $queryCounter = $queryCounter + 1;

    $query = "UPDATE TBL_QUESTIONCOUNTER SET NUMQUESTIONCOUNT=?";
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "i", $queryCounter);
    mysqli_stmt_execute($pstmt);

    //Insert new question
    $question = $_POST['question'];
    $returnType = $_POST['returnType'];
    $filter1 = $_POST['filter1'];
    $filter2 = $_POST['filter2'];
    
    
    $query = "INSERT INTO TBL_QUESTIONBANK (NUMID, VCHQUESTION, VCHRETURNTYPE, VCHFILTER1, VCHFILTER2) VALUES (?, ?, ?, ?, ?)";

    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "issss", $queryCounter, $question, $returnType, $filter1, $filter2);
    mysqli_stmt_execute($pstmt);

    printf($queryCounter);
}
elseif($code == "6") { //Get INPUT/OUTPUT
    $questionid = $_POST['questionid'];
    $query = "SELECT * FROM TBL_INPUTOUTPUT WHERE NUMID=".$questionid;
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "7") { //Add INPUT/OUTPUT
    $id = $_POST['id'];
    $input = $_POST['input'];
    $output = $_POST['output'];
    $points = $_POST['points'];

    $query = "INSERT INTO TBL_INPUTOUTPUT (NUMID, VCHINPUT, VCHOUTPUT, NUMPOINTS) VALUES (?, ?, ?, ?);";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "issi", $id, $input, $output, $points);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "8") { //Get Conditions
    $questionid = $_POST['questionid'];
    $query = "SELECT * FROM TBL_CONDITION WHERE NUMID=".$questionid;
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "9") { //Add Conditions
    $id = $_POST['id'];
    $condition = $_POST['condition'];
    $value = $_POST['value'];
    $points = $_POST['points'];

    $query = "INSERT INTO TBL_CONDITION (NUMID, VCHCONDITION, VCHVALUE, NUMPOINTS) VALUES (?, ?, ?, ?)";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "issi", $id, $condition, $value, $points);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "10") { //Get Feedback Teacher
    $questionid = $_POST['questionid'];
    $testid = $_POST['testid'];
    $username = $_POST['username'];

    $query = "SELECT * FROM TBL_FEEDBACK WHERE VCHQUESTIONID IN (".$questionid.") AND VCHTESTID = '".$testid."' and VCHUSERNAME = '".$username."'";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "11") { //Add Feedback
    $username = $_POST['username'];
    $questionid = $_POST['questionid'];
    $testid = $_POST['testid'];
    $studentanswer = $_POST['studentanswer'];
    $score = $_POST['score'];
    $points = $_POST['points'];
    $feedback = $_POST['feedback'];
    //print_r($_POST);

    $query = "INSERT INTO TBL_FEEDBACK (VCHUSERNAME, VCHQUESTIONID, VCHTESTID, VCHSTUDENTANSWER, NUMSCORE, VCHPOINTS, VCHFEEDBACK) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "ssssiss", $username, $questionid, $testid, $studentanswer, $score, $points, $feedback);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "12") { //Get All users
    $query = "SELECT VCHUSERNAME, VCHLEVEL FROM TBL_CREDENTIALS";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "13") { //Get All Questions
    $query = "SELECT * FROM TBL_QUESTIONBANK";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "14") { //Add Test table
    $testname = $_POST['testname'];
    $questions = $_POST['questions'];

    $query = "INSERT INTO TBL_TESTS (VCHTESTNAME, VCHQUESTIONS) VALUES (?, ?)";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "ss", $testname, $questions);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "15") { //Get test table
    $testname = $_POST['testname'];
    $query = "SELECT VCHQUESTIONS FROM TBL_TESTS WHERE VCHTESTNAME='". $testname ."'";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "16") { //Add Test-Student
    $username = $_POST['username'];
    $test = $_POST['test'];

    $query = "INSERT INTO TBL_STUDENTTEST (VCHUSERNAME, VCHTEST) VALUES (?, ?)";
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "ss", $username, $test);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "17") { //Get student-test
    $username = $_POST['username'];
    $query = "SELECT * FROM TBL_STUDENTTEST WHERE VCHUSERNAME='".$username."'";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "18") { //Update Feedback table
    $username = $_POST['username'];
    $questionid = $_POST['questionid'];
    $testid = $_POST['testid'];
    $feedback = $_POST['feedback'];
    $questiontotal = $_POST['questiontotal'];

    echo $username."|".$questionid."|".$feedback."|".$testid."|".$questiontotal;

    $query = "UPDATE TBL_FEEDBACK SET VCHFEEDBACK=?, NUMSCORE=? WHERE VCHUSERNAME=? AND VCHQUESTIONID=? AND VCHTESTID=?";
    echo $query;
    $pstmt = mysqli_stmt_init($dbhandle);
    mysqli_stmt_prepare($pstmt, $query);
    mysqli_stmt_bind_param($pstmt, "sisss", $feedback, $questiontotal, $username, $questionid, $testid);
    mysqli_stmt_execute($pstmt);
}
elseif($code == "19") {
    $filter1 = $_POST['filter1'];
    $filter2 = $_POST['filter2'];
    
    if($_POST['filter1'] != "None" && $_POST['filter2'] != "None") {
		
		$query = "SELECT * FROM TBL_QUESTIONBANK WHERE VCHFILTER1='".$filter1."' AND VCHFILTER2='".$filter2."'";	
		generateArrayOfRows($dbhandle, $query);
	}
	elseif($_POST['filter2'] == "None" && $_POST['filter1'] != "None") {
		$query = "SELECT * FROM TBL_QUESTIONBANK WHERE VCHFILTER1='".$filter1."'";
		generateArrayOfRows($dbhandle, $query);
	}
	elseif($_POST['filter1'] == "None" && $_POST['filter2'] != "None") {	
		$query = "SELECT * FROM TBL_QUESTIONBANK WHERE VCHFILTER2='".$filter2."'";
		generateArrayOfRows($dbhandle, $query);
	}
	else {
		$query = "SELECT * FROM TBL_QUESTIONBANK";
		generateArrayOfRows($dbhandle, $query);
	}
}
else if($code == "20") {
	$query = "DELETE FROM TBL_FEEDBACK WHERE VCHQUESTIONID=".$_POST['questionid']." AND VCHUSERNAME='".$_POST['username']."'";
	generateArrayOfRows($dbhandle, $query);
}
else if($code == "21") {
    $questionid = $_POST['questionid'];
    $query = "SELECT * FROM TBL_CONDITION WHERE NUMID=".$questionid." AND VCHCONDITION='ConditionType'";
    generateArrayOfRows($dbhandle, $query);
}
elseif($code == "david") { // get all tests for teacher
  $query = $_POST['query'];
  generateArrayOfRows($dbhandle, $query);
}
else {
    printf("Code not found: %s", $code);
}

//Creates an on-going array
function appendToJSON($holder, $fields, $values) {
    $row = array();
    for($i = 0; $i < count($fields); ++$i) {
        $row[$fields[$i]] = $values[$i];
    }
    array_push($holder, $row);
    return $holder;
}

//Read table meta data to get column names
function getColumnNames($dbhandle, $query) {
    $columnNames = array();
    if($result=mysqli_query($dbhandle, $query)) {
        $info = mysqli_fetch_fields($result);
        foreach($info as $val) {
            array_push($columnNames, ($val->name));
        }
    }
    return $columnNames;
}

//echos results
function generateArrayOfRows($dbhandle, $query) {

    $arrayOfRows = array();
    $fields = getColumnNames($dbhandle, $query);

    if($result=mysqli_query($dbhandle, $query)) {
        while ($row=mysqli_fetch_row($result)) {
            $arrayOfRows = appendToJSON($arrayOfRows, $fields, $row);
        }
    }

    echo json_encode($arrayOfRows);
}

?>
