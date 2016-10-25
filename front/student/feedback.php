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
        <p id="username" hidden><?php echo $_SESSION['user']?></p>
        <div class="navigation">
            <div class="container">
                <div class="row">
                    <!-- <a href="home.php" class="header-link">Home</a> -->
                    <a href="../logout.php" class="header-link u-pull-right">Log Out</a>
                    <a href="home.php" class="header-link u-pull-right">Back</a>
                </div>
            </div>
        </div>

        <div class="section-upper animated fadeIn">
            <div class="container">
                <div class="row">
                    <h1 class="splash-head">View Results</h1>
                </div>
                <div class="row">
                    <div class="offset-by-four four columns">
                        <select id="testDropDown" class="u-full-width" onchange="getFeedBackTable()">
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
            </div>
        </div>

        <script type="text/javascript" src="../js/main.js"></script>

        <script type="text/javascript">

        document.addEventListener( 'DOMContentLoaded', function () {
          getTestList();
        }, false );

        function getFeedBackTable(){
            var payload = {};
            payload['code'] = 19;
            payload['student'] = document.getElementById('username').innerHTML;
            payload['testname'] = document.getElementById('testDropDown').value;

            // reset results
            document.getElementsByTagName('tbody')[0].innerHTML = "";

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

                        var table = document.getElementById('feedbackTable');
                        var tbody = table.getElementsByTagName('tbody')[0];

                        for(var i = 0; i < tojson.length; i++) {
                            var questionid = tojson[i]['VCHQUESTIONID']; // question id
                            var points = tojson[i]['VCHPOINTS'];
                            var score = tojson[i]['NUMSCORE'];
                            var studentAnswer = tojson[i]['VCHSTUDENTANSWER'];
                            var instructorFeedback = tojson[i]['VCHFEEDBACK'];

                            if(instructorFeedback == null) {
              								return 1;
              							}

                            var row = tbody.insertRow(0);
                            var questionInfo = row.insertCell(0);

                            questionInfo.className='full column';

                            var qlabel = document.createElement('h6');
                            qlabel.id = questionid;

                            // student answers
                            var studentAnswerLabel = document.createElement('label');
                            studentAnswerLabel.appendChild(document.createTextNode('Student Answer:'));
                            var pbodyStudentAnswer = document.createElement('p');
                            var textNodeStudentAnswer = document.createTextNode(studentAnswer);

                            //instructor feedback
                            var feedbackdiv = document.createElement('div');
                            feedbackdiv.className = "u-full-width";
                            var instructorLabel = document.createElement('label');
                            var instructorp = document.createElement('p');
                            instructorp.innerHTML = instructorFeedback;
                            instructorLabel.appendChild(document.createTextNode("Instructor Feedback:"));

                            feedbackdiv.appendChild(instructorLabel);
                            feedbackdiv.appendChild(instructorp);


                            // pbodyStudentAnswer.appendChild(textNodeStudentAnswer);
                            // // conditions, input and output
                            // var pbodyPointsLabel = document.createElement('label');
                            // var textNodePoints = document.createTextNode("Input/Output & Conditions");
                            // pbodyPointsLabel.appendChild(textNodePoints);
                            // var pbodyPoints = document.createElement('ol');
                            // var pointArr = points.split('|');
                            // //console.log(pointArr);
                            // for(var x in pointArr){
                            //   var list = document.createElement('li');
                            //   list.appendChild(document.createTextNode(pointArr[x]));
                            //   pbodyPoints.appendChild(list);
                            // }

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


                            // question total
                            var pbodyTotal = document.createElement('div');
                            pbodyTotal.className = 'questionTotal total'+ questionid;
                            var pbodyTitle = document.createElement('b');
                            pbodyTitle.appendChild(document.createTextNode('Question Total: '));
                            pbodyTotal.appendChild(pbodyTitle);

                            //var textbox = document.createElement('textarea');
                            //textbox.id = questionid;
                            //textbox.className='u-full-width';

                            questionInfo.appendChild(qlabel);
                            questionInfo.appendChild(studentAnswerLabel);
                            questionInfo.appendChild(pbodyStudentAnswer);
                            questionInfo.appendChild(breakdown);
                            questionInfo.appendChild(pbodyTotal);
                            questionInfo.appendChild(feedbackdiv);

                            //questionInfo.appendChild(textbox);

                            getQuestion(questionid);
                            getQuestionTotal(questionid, score);
                            getInputOutput(questionid);

                        }
                    } else {
                            alert("Data lost");
                    }
                }
            }
        }

        function getQuestion(questionid){
          //console.log('get question called');
          var payload = {};
          payload['code'] = 4;
          payload['questionid'] = questionid;

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

        // get list of tests that are associated to the user for selection
        function getTestList(){
          var payload = {'code' : 17, 'username' : document.getElementById('username').innerHTML};
          console.log(payload);
          var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php";
          var xmlhttp = new XMLHttpRequest();
          var testDropDown = document.getElementById('testDropDown');

          xmlhttp.open("POST", url , true);
          xmlhttp.onreadystatechange = test_data;
          xmlhttp.send(JSON.stringify(payload));

          function test_data() {
              if(xmlhttp.readyState == 4) {
                  if(xmlhttp.status == 200) {
                      var response = xmlhttp.responseText;
                      var tojson = JSON.parse(response);
                      console.log(tojson);
                      for(var i=0; i < tojson.length; i++){
                        var testname = tojson[i]['VCHTEST'];
                        console.log(testname);
                        var testDropDownOption = document.createElement('option');
                        testDropDownOption.value = testname;
                        testDropDownOption.appendChild(document.createTextNode(testname));
                        testDropDown.appendChild(testDropDownOption);
                      }
                  } else {
                          alert("Data lost");
                  }
              }
          }
        }

        function getQuestionTotal(questionid, score){
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
                      pelement.appendChild(document.createTextNode(score +" / "+ tojson[0]['QUESTIONTOTAL']));
                      pbody.appendChild(pelement);
                  } else {
                          alert("Data lost");
                  }
              }
          }
        }
        </script>
    </body>
</html>
