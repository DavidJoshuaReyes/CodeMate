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
                    <h1 class="splash-head">Provide Feedback</h1>
                </div>

                <div class="row">
                  <div class="offset-by-four four columns">
                    <select id="studentDropDown" class="u-full-width" onchange="getStudentTests()">
                        <option value="">Select Student...</option>
                    </select>
                    <select id="testDropDown" class="u-full-width animated fadeIn" onchange="getFeedBackTable()" hidden>
                        <option value="">Select Test...</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                    <table class="full column" id="feedbackTable">
                      <tbody>

                      </tbody>
                    </table>
                </div>
                <div id="submitDiv" class="row animated fadeIn" hidden>
                  <button class="button button-primary" name="button" onclick="submitFeedback();">Submit Feedback</button>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="../js/main.js"></script>

        <script type="text/javascript">

        document.addEventListener( 'DOMContentLoaded', function () {
            var payload = {};
            payload['code'] = 3;

            var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
            //var url = "https://web.njit.edu/~sv389/frontend.php";
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", url , true);
            xmlhttp.onreadystatechange = function() {

                       if(xmlhttp.readyState == 4) {
                           if(xmlhttp.status == 200) {
                               var response = xmlhttp.responseText;
                               var tojson = JSON.parse(response);
                               console.log(tojson);
                               for(var i = 0; i < tojson.length; i++) {
                                   addStudentToDropDown(tojson[i]['VCHUSERNAME']);
                               }

                           } else {
                                   alert("Data lost");
                           }
                       }
            };
            xmlhttp.send(JSON.stringify(payload));
        }, false );

        function addStudentToDropDown(student) {
            var x = document.getElementById("studentDropDown");
            var option = document.createElement("option");
            option.text = student;
            x.appendChild(option);
        }

        function addTestToDropDown(testname) {
            var x = document.getElementById("testDropDown");
            var option = document.createElement("option");
            option.text = testname;
            x.appendChild(option);
        }

        function getStudentTests(){
          var student = document.getElementById('studentDropDown').value;
          var payload = {'code' : 17, 'username' : student};
          var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("POST", url , true);
          xmlhttp.onreadystatechange = function() {
                     if(xmlhttp.readyState == 4) {
                         if(xmlhttp.status == 200) {
                             var response = xmlhttp.responseText;
                             var tojson = JSON.parse(response);
                             console.log(tojson);
                             document.getElementById('testDropDown').removeAttribute('hidden');
                             for(var i = 0; i < tojson.length; i++) {
                                 addTestToDropDown(tojson[i]['VCHTEST']);
                             }
                         } else {
                                 alert("Data lost");
                         }
                     }
          };
          xmlhttp.send(JSON.stringify(payload));
        }

        function getFeedBackTable(){
            var payload = {};
            payload['code'] = 19;
            payload['testname'] = document.getElementById('testDropDown').value;
            payload['student'] = document.getElementById('studentDropDown').value;

            var select = document.getElementsByTagName('select');
            for(var i = 0; i < select.length; i++){ select[i].setAttribute('hidden', true); }

            var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", url , true);
            xmlhttp.onreadystatechange = display_data;
            xmlhttp.send(JSON.stringify(payload));

            function display_data() {
                if(xmlhttp.readyState == 4) {
                    if(xmlhttp.status == 200) {
                        var response = xmlhttp.responseText;
                        if(response.length > 3){
                          var tojson = JSON.parse(response);
                          console.log(tojson);

                          var table = document.getElementById('feedbackTable');
                          var tbody = table.getElementsByTagName('tbody')[0];

                          for(var i = 0; i < tojson.length; i++) {
                              var questionid = tojson[i]['VCHQUESTIONID']; // question id
                              var points = tojson[i]['VCHPOINTS'];
                              var score = tojson[i]['NUMSCORE'];
                              var studentAnswer = tojson[i]['VCHSTUDENTANSWER'];

                              // handle feedback informaton

                              var row = tbody.insertRow(0);
                              var questionInfo = row.insertCell(0);

                              questionInfo.className='full column';

                              // question header
                              var qlabel = document.createElement('h6');
                              qlabel.id = questionid;

                              /*****************************************************/
                              // student answers need to put in textbox code mirror and auto format it
                              var studentAnswerLabel = document.createElement('label');
                              studentAnswerLabel.appendChild(document.createTextNode('Student Answer:'));
                              var pbodyStudentAnswer = document.createElement('p');
                              var textNodeStudentAnswer = document.createTextNode(studentAnswer);
                              pbodyStudentAnswer.appendChild(textNodeStudentAnswer);

                              /*****************************************************/
                              // conditions, input and output
                              var breakdown = document.createElement('div');
                              breakdown.className = "u-full-width";
                              var breakdownLeft = document.createElement('table');
                              breakdownLeft.id = "left";
                              breakdownLeft.className = "one-half column u-pull-left";
                              var breakLeftRow = breakdownLeft.createTHead().insertRow(0);
                              breakLeftRow.insertCell(0).innerHTML = "<b>Expected Conditions</b>";
                              breakLeftRow.insertCell(1).innerHTML = "<b>User Return Value</b>";
                              var breakdownRight = document.createElement('table');
                              breakdownRight.id = "right"+questionid;
                              breakdownRight.className = "one-half column u-pull-right";
                              var breakRightRow = breakdownRight.createTHead().insertRow(0);
                              breakRightRow.insertCell(0).innerHTML = "<b>Expected Conditions</b>";
                              breakRightRow.insertCell(1).innerHTML = "<b>Expected Return Value</b>"
                              breakRightRow.insertCell(2).innerHTML = "<b>Worth</b>";

                              var pointArr = points.split('|');
                              //console.log(pointArr);
                              var counter = 1;
                              for(var x in pointArr){
                                var entry = pointArr[x].split("=");
                                var leftrow = breakdownLeft.insertRow(counter);
                                leftrow.insertCell(0).innerHTML = entry[0];
                                leftrow.insertCell(1).innerHTML = entry[1];
                                counter++;
                              }

                              breakdown.appendChild(breakdownLeft);
                              breakdown.appendChild(breakdownRight);

                              /*****************************************************/
                              // student points total
                              var pointsDiv = document.createElement('div');
                              var studentTotalSpan = document.createElement('span');
                              var questionTotalSpan = document.createElement('span');
                              // add to student total span
                              studentTotalSpan.className = "four columns u-pull-left";
                              var studentTotalLabel = document.createElement('label');
                              var studentTotalInput = document.createElement('input');
                              studentTotalLabel.appendChild(document.createTextNode('Student Question Total:'));
                              studentTotalInput.className = "studentTotal"+questionid;
                              studentTotalInput.type = "number";
                              studentTotalInput.value = score;
                              studentTotalSpan.appendChild(studentTotalLabel);
                              studentTotalSpan.appendChild(studentTotalInput);
                              pointsDiv.appendChild(studentTotalSpan);    // add to pointsDiv
                              // question total span to be update later using the getQuestionTotal function
                              questionTotalSpan.className = "offset-by-four four columns u-pull-right  total"+questionid;
                              questionTotalSpan.setAttribute("style", "text-align: right;")
                              var questionTotalLabel = document.createElement('b');
                              questionTotalLabel.appendChild(document.createTextNode('Question Actual Total:   '));
                              questionTotalSpan.appendChild(questionTotalLabel);
                              pointsDiv.appendChild(questionTotalSpan);

                              /*****************************************************/
                              // feedback textbox
                              var textbox = document.createElement('textarea');
                              textbox.id = questionid;
                              textbox.className='u-full-width';
                              textbox.setAttribute("placeholder", "Enter Instructor Feedback...");
                              textbox.value = "No Feedback";

                              questionInfo.appendChild(qlabel);
                              questionInfo.appendChild(studentAnswerLabel);
                              questionInfo.appendChild(pbodyStudentAnswer);
                              //questionInfo.appendChild(returnTable);
                              questionInfo.appendChild(breakdown);
                              questionInfo.appendChild(pointsDiv);
                              //questionInfo.appendChild(pbodyTotal);
                              questionInfo.appendChild(textbox);
                              questionInfo.appendChild(pointsDiv);


                              // get question value and total and set them accordingly
                              getQuestion(questionid); // populate question value
                              getQuestionTotal(questionid); // populate question total

                              // still have not been implemented
                              getInputOutput(questionid); // calls get condition as well
                              //getCondition(questionid);

                              document.getElementById('submitDiv').removeAttribute('hidden');
                          }
                        }
                    } else {
                            alert("Data lost");
                    }
                }
            }
        }

        function getQuestion(questionid){
          var payload = {};
          payload['code'] = 4;
          payload['questionid'] = questionid;

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
                      var questionElem = document.getElementById(questionid);
                      var questionTextNode = document.createTextNode(tojson[0]['VCHQUESTION']);
                      questionElem.appendChild(questionTextNode);
                  } else {
                          alert("Data lost");
                  }
              }
          }
        }

        function getInputOutput(questionid){
          // pass to 6 to get inputouput
          var payload = { 'code' : 'getInputOutput', 'questionid' : questionid };
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
                      console.log(tojson);
                      var expectedTable = document.getElementById("right"+questionid);
                      for(var i = 0; i < tojson.length; i++){
                        var row = expectedTable.insertRow();
                        row.insertCell(0).innerHTML = tojson[i]['VCHINPUT'];
                        row.insertCell(1).innerHTML = tojson[i]['VCHOUTPUT'];
                        row.insertCell(2).innerHTML = tojson[i]['NUMPOINTS'];
                      }
                      getCondition(questionid);
                  }
              }
          }
        }

        function getCondition(questionid){
          // pass to 8 to get condition
          var payload = { 'code' : 'getCondition', 'questionid' : questionid };
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
                      console.log(tojson);
                      var expectedTable = document.getElementById("right"+questionid);
                      for(var i = 0; i < tojson.length; i++){
                        var row = expectedTable.insertRow();
                        row.insertCell(0).innerHTML = tojson[i]['VCHCONDITION'];
                        row.insertCell(1).innerHTML = tojson[i]['VCHVALUE'];
                        row.insertCell(2).innerHTML = tojson[i]['NUMPOINTS'];
                      }
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
                      var pbody = document.getElementsByClassName("total"+questionid)[0];
                      var pelement = document.createElement('p');
                      pelement.className = "u_pull-right";
                      pelement.appendChild(document.createTextNode(tojson[0]['QUESTIONTOTAL']));
                      pbody.appendChild(pelement);

                  } else {
                          alert("Data lost");
                  }
              }
          }
        }

        function submitFeedback(){
          var payload = {};
          var feedbackArr = [];
          var test = document.getElementById('testDropDown').value;
          //var student = document.getElementById('studentDropDown').value
          var student = "jaga";
          var textfields = document.getElementsByTagName('textarea');
          for(var i = 0; i < textfields.length; i++){
            var data = {};
            var feedbackTotal = document.getElementsByClassName("studentTotal"+textfields[i].id)[0].value;
            data['questionid'] = textfields[i].id;
            data['questiontotal'] = feedbackTotal;
            data['feedback'] = textfields[i].value;
            data['testid'] = test;
            data['username'] = student;

            feedbackArr.push(data);
          }

          payload['code'] = 18;
          payload['teacherResponse'] = feedbackArr;
          console.log(payload);
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
                      console.log(response);
                      window.location = 'https://web.njit.edu/~sv389/instructor/home.php';
                  } else {
                          alert("Data lost");
                  }
              }
          }
        }


        </script>
    </body>
</html>
