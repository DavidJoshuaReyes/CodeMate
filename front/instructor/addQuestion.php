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
                    <h1 class="splash-head">Add A Question</h1>
                </div>

                <input type="text" class="half" id="returnType" placeholder="Return Type"/>

                <select id="filter1">
          					<option value="Difficulty: Simple">Difficulty: Simple</option>
          					<option value="Difficulty: Medium">Difficulty: Medium</option>
          					<option value="Difficulty: Hard">Difficulty: Hard</option>
                </select>

                <select id="filter2">
          					<option value="Type: Loops">Type: Loops</option>
          					<option value="Type: Recursion">Type: Recursion</option>
          					<option value="Type: Conditions">Type: Conditions</option>
                    <option value="Type: Standard">Type: Standard</option>
                </select>

				<input type="number" id="typePoints" placeholder="points"/>

                <form>

                    <div class="row">
                        <label for="question" class="u-pull-left">Question</label>
                        <input type="text" class="u-full-width" id="question" placeholder="Type your question here"/>
                    </div>

                    <div class="row">
                        <div class="four columns">
                            <label for="condition" class="u-pull-left">Expected Parameter Name</label>
                            <input type="text" class="u-full-width" id="condition" placeholder="Condition"/>
                        </div>
                        <div class="four columns">
                            <label for="name" class="u-pull-left">Expected Paramater Type</label>
                            <input type="text" class="u-full-width" id="name" placeholder="Expected Value"/>
                        </div>
                        <div class="two columns">
                            <label for="points" class="u-pull-left"># of Points</label>
                            <input type="number" class="u-full-width" id="points"/>
                        </div>
                        <div class="one column">
                            <input type="button" class="button-primary u-full width addButton"  value="Add" onclick="addToTable('conditionsTable')"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="four columns">
                            <label for="name" class="u-pull-left">Expected Function Name</label>
                            <input type="text" class="u-full-width" id="condname" placeholder="Expected Value"/>
                        </div>
                        <div class="two columns">
                            <label for="points" class="u-pull-left"># of Points</label>
                            <input type="number" class="u-full-width" id="condpoints"/>
                        </div>
                        <div class="four columns" hidden>
                            <label for="condition" class="u-pull-left"></label>
                            <input type="text" class="u-full-width" id="cond" placeholder="Condition" value="functionName"/>
                        </div>
                        <div class="one column">
                            <input type="button" class="button-primary u-full width addButton"  value="Add" onclick="addFunctionName()"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="four columns">
                            <label for="testInput" class="u-pull-left">Test Input</label>
                            <input type="text" class="u-full-width" id="testInput" placeholder="Test Values"/>
                        </div>
                        <div class="four columns">
                            <label for="testOutput" class="u-pull-left">Expected Output</label>
                            <input type="text" class="u-full-width" id="testOutput" placeholder="Expected Output"/>
                        </div>
                        <div class="two columns">
                            <label for="points" class="u-pull-left"># of Points</label>
                            <input type="number" class="u-full-width" id="testPoints"/>
                        </div>
                        <div class="one column">
                            <input type="button" class="button-primary u-full width addButton"  value="Add" onclick="addToTable('inputOutputTable')"/>
                        </div>
                    </div>

                    <div class="row">
                        <!-- input / output -->
                         <table class="one-half column" id="inputOutputTable">
                            <thead>
                                <tr>
                                    <th>Input</th>
                                    <th>Expected Output</th>
                                    <th># Points</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                        <!-- conditions -->
                        <table class="one-half column" id="conditionsTable">
                          <thead>
                            <tr>
                              <th>Condition</th>
                              <th>Expected Value</th>
                              <th># Points</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>

                    </div>

                </form>

            </div>
        </div>
        <div class="row section-lower">
          <div class="offset-by-four four columns">
            <input id='submitButton' type="button" class="u-full-width" name="postQuestion" onclick="infoToJSONArray();" value="Submit Question"/>
          </div>
        </div>


        <script type="text/javascript" src="../js/main.js"></script>

        <script type="text/javascript">

            function addToTable(tableName){

                var tableRef = document.getElementById(tableName).getElementsByTagName('tbody')[0];
                var newRow = tableRef.insertRow(0);

                var conditionCell = newRow.insertCell(0);
                var nameCell = newRow.insertCell(1);
                var pointCell = newRow.insertCell(2);
                var deleteCell = newRow.insertCell(3);

                if(tableName==="conditionsTable"){
                    conditionCell.innerHTML = document.getElementById('condition').value;
                    nameCell.innerHTML = document.getElementById('name').value;
                    pointCell.innerHTML = document.getElementById('points').value;
                } else {
                    conditionCell.innerHTML = document.getElementById('testInput').value;
                    nameCell.innerHTML = document.getElementById('testOutput').value;
                    pointCell.innerHTML = document.getElementById('testPoints').value;
                }

                deleteCell.innerHTML = "<i class='fa fa-times' aria-hidden='true' onclick='deleteRow(this);'></i>";

            }

            function addFunctionName(){
              var tableRef = document.getElementById('conditionsTable').getElementsByTagName('tbody')[0];
              var newRow = tableRef.insertRow(0);

              var conditionCell = newRow.insertCell(0);
              var nameCell = newRow.insertCell(1);
              var pointCell = newRow.insertCell(2);
              var deleteCell = newRow.insertCell(3);

              conditionCell.innerHTML = document.getElementById('cond').value;
              nameCell.innerHTML = document.getElementById('condname').value;
              pointCell.innerHTML = document.getElementById('condpoints').value;

              deleteCell.innerHTML = "<i class='fa fa-times' aria-hidden='true' onclick='deleteRow(this);'></i>";
            }

            function deleteRow(row) {
                var tbody=row.parentNode.parentNode.parentNode;
                var i=row.parentNode.parentNode.parentNode.rowIndex;
                tbody.deleteRow(i);
            }


            // need to create JSON Object to pass to controller
            function infoToJSONArray(){
                var data = {};

                document.getElementById('submitButton').setAttribute("hidden", true);
                var conditionsRows = document.getElementById('conditionsTable').getElementsByTagName('tbody')[0].rows;
                var inputOutputRows = document.getElementById('inputOutputTable').getElementsByTagName('tbody')[0].rows;

                var conditions = [];
                var inout = [];

                for(var row = 0; row < conditionsRows.length; row++){
                    var condCells = conditionsRows[row].cells;
                    var temp = {};

                    temp['condition'] = condCells[0].innerHTML;
                    temp['value'] = condCells[1].innerHTML;
                    temp['points'] = condCells[2].innerHTML;

                    conditions.push(temp);
                }

                for(var row = 0; row < inputOutputRows.length; row++){
                    var Cells = inputOutputRows[row].cells;
                    var temp = {};

                    temp['input'] = Cells[0].innerHTML;
                    temp['output'] = Cells[1].innerHTML;
                    temp['points'] = Cells[2].innerHTML;

                    inout.push(temp);
                }
                
                var type = {};
                type['condition'] = "ConditionType";
                type['value'] = document.getElementById('filter2').value;
                type['points'] = document.getElementById('typePoints').value;
				conditions.push(type);

                // add all data to arr
                data["code"] = "5";
                data["question"] = document.getElementById("question").value;
                data["returnType"] = document.getElementById('returnType').value;
                data["filter1"] = document.getElementById('filter1').value;
                data["filter2"] = document.getElementById('filter2').value;

                if(conditions.length > 0)
                    data["conditions"] = conditions;

                if(inout.length > 0)
                    data["inout"] = inout;

                curlToInstructor(JSON.stringify(data));

                var elements = document.getElementsByTagName("input");
                for (var ii=0; ii < elements.length; ii++) {
                  if (elements[ii].type == "text") {
                    elements[ii].value = "";
                  }
                }

            }



        </script>
    </body>
</html>
