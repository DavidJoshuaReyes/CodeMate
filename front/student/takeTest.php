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

        <!-- code mirror imports -->
        <link rel="stylesheet" href="../codeMirror/codemirror.css">
        <script src="../codeMirror/codemirror.js"></script>
        <script src="../codeMirror/clike.js"></script>
        <script src="../codeMirror/matchbrackets.js"></script>

    </head>
    <body>
        <div id="user" hidden><?php echo $_SESSION['user']?></div>

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
                    <h1 class="splash-head" id="header">Take a Test</h1>
                    <div class="offset-by-four four columns">
                        <select id="testDropDown" class="u-full-width" onchange="getTest(this.value)">
                            <option value="">Select Test...</option>
                        </select>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="offset-by-four four columns">
                        <select id="testDropDown" class="u-full-width" onchange="getTest(this.value)">
                            <option value="">Select Test...</option>
                        </select>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="section-lower animated fadeIn">
          <div class="container">
            <form>
              <div class="row">
                <table class="full column" id="tableForm">
                    <tbody id="answers">
                      <!-- <div><textarea id="testCodeMirror" style="text-align: left;"></textarea></div> -->
                    </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>

        <div id="submitDiv" class="offset-by-four four columns" hidden="true">
            <input id="submitButton" class="u-full-width" type="button" name="postQuestion" onclick="submitStudentAnswers();" value="Submit Answers"/>
        </div>


        <script type="text/javascript" src="../js/main.js"></script>
        <script type="text/javascript">

            document.addEventListener( 'DOMContentLoaded', function () {

                getUserTests();

            }, false );

            function getUserTests(){
                var student = document.getElementById("user").innerHTML;
                var payload = {};
                payload['code'] = 17;
                payload['username'] = student;

                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                //var url = "https://web.njit.edu/~sv389/frontend.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(payload));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {
                            var response = xmlhttp.responseText;
                            var questions = JSON.parse(response);
                            var select = document.getElementById('testDropDown');

                            for(var x in questions){
                                var option = document.createElement('OPTION');
                                option.value = questions[x]['VCHTEST'];
                                option.innerHTML = questions[x]['VCHTEST'];
                                select.appendChild(option);
                            }
                        } else {
                                alert("Data lost");
                        }
                    }
                }
            }

            function getTest(testName){
                var payload = {};
                payload['code'] = 15;
                payload['testname'] = testName;

                // hide drop down
                document.getElementById('testDropDown').setAttribute("hidden", true);
                document.getElementById('header').innerHTML = testName;

                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                //var url = "https://web.njit.edu/~sv389/frontend.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(payload));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {
                            var response = xmlhttp.responseText;
                            var tojson = JSON.parse(response);

                            var emptyTbody = document.getElementById('answers').innerHTML = "";
                            // debugg
                            //console.log(response);

                            var table = document.getElementById('tableForm');
                            var tbody = table.getElementsByTagName('tbody')[0];

                            // insert questions into table for the student to view
                            for (var x in tojson){
                                var questionid = tojson[x]['NUMID'];
                                var question = tojson[x]['VCHQUESTION'];

                                var row = tbody.insertRow(0);
                                var questionCol = row.insertCell(0);
                                questionCol.className = "u-full-width question"+questionid;

                                var textbox = document.createElement('textarea');
                                //textbox.className = "u-full-width";
                                textbox.id = questionid;

                                // insert question
                                var pbody = document.createElement('label');
                                var textNode = document.createTextNode(question);
                                //pbody.id = questionid;
                                pbody.appendChild(textNode);
                                questionCol.appendChild(pbody);

                                //insert quesition worth
                                getQuestionTotal(questionid);

                                // insert text field
                                questionCol.appendChild(textbox);
                                // convert text field to codeMirror editor
                                CodeMirror.fromTextArea(document.getElementById(textbox.id), {
                                  lineNumbers: true,
                                  matchBrackets: true,
                                  mode: "text/x-java"
                                });
                            }
                            // show submit button
                            document.getElementById('submitDiv').removeAttribute("hidden");
                        }
                    }
                }
            }


            function submitStudentAnswers() {

				document.getElementById('submitButton').value = "Submitting Answers...";
				document.getElementById('submitButton').disable = "disble";

                var table = document.getElementById('tableForm');
                var tbody = table.getElementsByTagName('tbody')[0];
                var rows = tbody.getElementsByTagName('tr');
                var student = document.getElementById("user").innerHTML;
                var testname = document.getElementById('testDropDown').value;

                var studentAns = {};
                var answersArr = [];

                for (var i = 0; i < rows.length; i++) {
                  // for each row add the questions id and source code to an array and submit an array of arrays
                  var temp = {};
                  var cell = rows[i].cells[0];
                  var questionid = cell.children[1].id;
                  var answer = cell.getElementsByClassName('CodeMirror')[0].CodeMirror.getValue(); // this gets all the value of the question editor

                  console.log(questionid);
                  console.log(answer);

                  temp['questionid'] = questionid;
                  temp['SourceCode'] = answer;
                  temp['username'] = student;
                  temp['testname'] = testname;

                  answersArr.push(temp);
                }

                studentAns['code'] = 11;
                studentAns['answers'] = answersArr;

                console.log(studentAns);

                var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.open("POST", url , true);
                xmlhttp.onreadystatechange = display_data;
                xmlhttp.send(JSON.stringify(studentAns));

                function display_data() {
                    if(xmlhttp.readyState == 4) {
                        if(xmlhttp.status == 200) {
                            var response = xmlhttp.responseText;
                            window.location = 'https://web.njit.edu/~sv389/student/home.php';
                            console.log(response);
                        }
                    }
                }
            }

            function getQuestionTotal(questionid){
              var payload = { 'code' : 'getQuestionTotal', 'questionid' : questionid };
              var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
              var xmlhttp = new XMLHttpRequest();

              xmlhttp.open("POST", url , true);
              xmlhttp.onreadystatechange = display_data;
              xmlhttp.send(JSON.stringify(payload));

              function display_data() {
                  if(xmlhttp.readyState == 4) {
                      if(xmlhttp.status == 200) {
                          var response = xmlhttp.responseText;
                          var tojson = JSON.parse(response);

                          var td = document.getElementsByClassName("question"+questionid)[0];
                          var div = document.createElement('div');
                          var bold = document.createElement('b');
                          bold.appendChild(document.createTextNode("Question Worth: "));

                          div.appendChild(bold);
                          div.appendChild(document.createTextNode(tojson[0]['QUESTIONTOTAL']));
                          td.appendChild(div);




                      } else {
                              alert("Data lost");
                      }
                  }
              }
            }

        </script>
    </body>
</html>
