<?php

    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="An University application to improve the efficeincy of teacher-student test taking">

        <title>Instructor</title>

        <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" />

        <link rel="stylesheet" href="../css/animate.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/skeleton.css">

    </head>
    <body>

        <div class="navigation">
            <div class="container">
                <div class="row">
                    <!-- <a href="home.php" class="header-link">Home</a> -->
                    <a href="../logout.php" class="header-link u-pull-right">Log Out</a>
                    <a href="home.php" class="header-link u-pull-left">Back</a>
                </div>
            </div>
        </div>

        <div class="section-upper animated fadeIn">
            <div class="container">
                <div class="row">
                    <h1 class="splash-head">Create a Test</h1>
                    <!--input type="button" name="postQuestion" onclick="getQuestions();" value="Get All Questions"/-->
                    <br>
                </div>

                <div class="row">
                    <div class="one-half column u-pull-left">
                        <h5 class="u-pull-left">Select questions to add to the Test</h5>

                        <table id="questionsTable">
                        </table>

                    </div>
                    <div class="one-half column">


				<label>Filter Questions</label>
				<select id="filter1">
					<option value="None">None</option>
					<option value="Difficulty: Simple">Difficulty: Simple</option>
					<option value="Difficulty: Medium">Difficulty: Medium</option>
					<option value="Difficulty: Hard">Difficulty: Hard</option>
                </select>

                <select id="filter2">
					<option value="None">None</option>
					<option value="Type: Loops">Type: Loops</option>
					<option value="Type: Recursion">Type: Recursion</option>
					<option value="Type: Conditions">Type: Conditions</option>
                </select>

                <br>
                <input type="button" name="filter" onclick="filter();" value="Filter"/>
                <input type="button" name="reset" onclick="reset();" value="Reset"/>


                        <div class="row">
                            <label for="students" class="u-pull-left">Select A Student</label>
                            <select name="students" id="selectStudent" class="u-full-width">
                                <option value="">Assign Test To..</option>
                                <option value="All Students">All Students</option>
                            </select>
                        </div>

                        <div class="row">
                            <input class="u-full-width" type="text" name="testName" placeholder="Name Your Test"/>
                            <input class="u-full-width" type="button" name="addTest" onclick="submitTest();" value="Submit Test"/>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="../js/main.js"></script>

        <script type="text/javascript">

            document.addEventListener( 'DOMContentLoaded', function () {
                // Get questions from database and insert them into tables

                getQuestions();
                getStudentList();

            }, false );


			//filter
			function filter() {
				var table = document.getElementById("questionsTable");
				table.innerHTML = "";

				var payload = {};
                payload['code'] = 20;
				payload['filter1'] = document.getElementById("filter1").value;
                payload['filter2'] = document.getElementById("filter2").value;


                //var url = "https://cs490-somsai002.c9users.io/php/front/instructor.php";
                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(payload));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {

                                var response = xmlhttp.responseText;
                                var questions = JSON.parse(response);
                                //console.log(response);
                                for(var i in questions){
                                    // insert questions into table
                                    var id  = questions[i]['NUMID'];
                                    var question = questions[i]['VCHQUESTION'];

                                    var table = document.getElementById("questionsTable");
                                    var row = table.insertRow(0);

                                    var checkbox = document.createElement("INPUT");
                                    checkbox.type = "checkbox";
                                    checkbox.name = "check";
                                    checkbox.value = id;

                                    row.insertCell(0).appendChild(checkbox);
                                    row.insertCell(1).innerHTML = question;
                                }
                        } else {
                                alert("Data lost");
                        }
                    }
                }
			}

			//reset
			function reset() {
				var table = document.getElementById("questionsTable");
				table.innerHTML = "";
				getQuestions();
			}


            function getQuestions(){
                var payload = {};
                payload['code'] = 13;

                //var url = "https://cs490-somsai002.c9users.io/php/front/instructor.php";
                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(payload));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {
                                var response = xmlhttp.responseText;
                                var questions = JSON.parse(response);
                                //console.log(response);
                                for(var i in questions){
                                    // insert questions into table
                                    var id  = questions[i]['NUMID'];
                                    var question = questions[i]['VCHQUESTION'];

                                    var table = document.getElementById("questionsTable");
                                    var row = table.insertRow(0);

                                    var checkbox = document.createElement("INPUT");
                                    checkbox.type = "checkbox";
                                    checkbox.name = "check";
                                    checkbox.value = id;

                                    row.insertCell(0).appendChild(checkbox);
                                    row.insertCell(1).innerHTML = question;
                                }
                        } else {
                                alert("Data lost");
                        }
                    }
                }
            }

            function getStudentList(){
                var payload = {};
                payload['code'] = 3;

                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(payload));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {
                                var response = xmlhttp.responseText;
                                var students = JSON.parse(response);
                                //console.log("Jaga");
                                //console.log(students);
                                for (var i in students){
                                    var username = students[i]['VCHUSERNAME'];
                                    var sel = document.getElementById('selectStudent');

                                    var opt = document.createElement("OPTION");
                                    opt.value = username;
                                    opt.innerHTML = username;

                                    sel.appendChild(opt);
                                }

                        } else {
                                alert("Data lost");
                        }
                    }
                }
            }


            function submitTest(){

                var test = {};
                var testName = document.getElementsByName('testName')[0].value;
                var assignTo = document.getElementById('selectStudent').value;

                // add questions to array
                var questions = [];
                var checkbox = document.getElementsByName('check');

                for(var i in checkbox){
                    var question = checkbox[i];
                    if (question.checked){
                        questions.push(question.value);
                    }
                }

                test['code'] = 14; //Code to add test


                if(document.getElementById('selectStudent').value == "All Students") {

                    console.log("All Students Selected");

                    var payload = {};
                    payload['code'] = 3;

                    var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                    var xmlhttp1 = new XMLHttpRequest();

                    xmlhttp1.open("POST", url , true);
                    xmlhttp1.onreadystatechange = function() {

                        if(xmlhttp1.readyState == 4) {
                            if(xmlhttp1.status == 200) {
                                    var response = xmlhttp1.responseText;
                                    var students = JSON.parse(response);
                                    console.log("jaga");
                                    console.log(students);
                                    for (var i in students){
                                        var username = students[i]['VCHUSERNAME'];


                                        if(testName.length > 0)
                                            test['testname'] = testName; // test name not coming through for some odd reason

                                        if(assignTo.length > 0)
                                            test['username'] = username;

                                        if(questions.length)
                                            test['questions'] = questions.toString();


                                        // ********************************************** start ajax call to add test
                                        var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                                        var xmlhttp = new XMLHttpRequest();

                                        xmlhttp.open("POST", url , true);
                                        xmlhttp.onreadystatechange = display_data;
                                        xmlhttp.send(JSON.stringify(test));

                                        function display_data() {
                                            if(xmlhttp.readyState == 4) {
                                                if(xmlhttp.status == 200) {
                                                        var response = xmlhttp.responseText;
                                                        window.location = 'https://web.njit.edu/~sv389/instructor/home.php';
                                                } else {
                                                        alert("Data lost");
                                                }
                                            }
                                        }


                                    }

                            } else {
                                    alert("Data lost");
                            }
                        }

                    };
                    xmlhttp1.send(JSON.stringify(payload));


                }
                else {

                        console.log("tranvo");
                        if(testName.length > 0)
                            test['testname'] = testName; // test name not coming through for some odd reason

                        if(assignTo.length > 0)
                            test['username'] = assignTo;

                        if(questions.length)
                            test['questions'] = questions.toString();


                        // ********************************************** start ajax call to add test
                        var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                        var xmlhttp = new XMLHttpRequest();

                        xmlhttp.open("POST", url , true);
                        xmlhttp.onreadystatechange = display_data;
                        xmlhttp.send(JSON.stringify(test));

                        function display_data() {
                            if(xmlhttp.readyState == 4) {
                                if(xmlhttp.status == 200) {
                                        var response = xmlhttp.responseText;
                                        window.location = 'https://web.njit.edu/~sv389/instructor/home.php';
                                } else {
                                        alert("Data lost");
                                }
                            }
                        }
                        // ************************************************* End ajax call to add test


                    }
                }





        </script>
    </body>
</html>
