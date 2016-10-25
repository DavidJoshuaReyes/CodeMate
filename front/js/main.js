 // temporary function -- will end up redirecting to two different pages if it works else it just shows an error
    function addResult(res) {
        var header = document.getElementById('resultDiv');

        if(res.length > 4) {
            header.className = 'success';
            header.innerHTML = 'Login Sucessful';
            document.getElementById('logInForm').className += 'hidden';
            document.getElementById('submitBtn').className += 'hidden';
        } else {
            header.className = 'error';
            header.innerHTML = 'Invalid Username & Password';
        }
    }

    function curlToInstructor(payload) {
        var url = "https://web.njit.edu/~sv389/backOfFront/passToMiddle.php"; // url to curl to backend
        //var url = "https://web.njit.edu/~sv389/frontend.php";
        var xmlhttp = new XMLHttpRequest();
        console.log(payload);
        xmlhttp.open("POST", url , true);
        xmlhttp.onreadystatechange = display_data;
        //xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(payload);

        function display_data() {
            if(xmlhttp.readyState == 4) {
                if(xmlhttp.status == 200) {
                      console.log("Data transfer to " + url + " completed"); //check if the data was revived successfully.
                      var response = xmlhttp.responseText;
                      console.log(response);
                      window.location = 'https://web.njit.edu/~sv389/instructor/home.php';
                }
            }
        }
    }

/********************************* UNUSED METHODS ********************************************/

    // function sendPHPpost()  {
    //
    //     var username= document.getElementById("username").value;
    //     var password= document.getElementById("password").value;
    //     var data = "username="+username+"&password="+password;
    //     var url = "https://cs490-somsai002.c9users.io/php/front/frontend.php";
    //     //var url = "https://web.njit.edu/~sv389/frontend.php";
    //     var xmlhttp = new XMLHttpRequest();
    //
    //     xmlhttp.open("POST", url , true);
    //     xmlhttp.onreadystatechange = display_data;
    //     xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //
    //     if(username != "" && password != "")
    //         xmlhttp.send(data);
    //     else
    //         addResult(false);
    //
    //     function display_data() {
    //         if(xmlhttp.readyState == 1 ) {
    //                 console.log("OPENED");//check if the data was revived successfully.
    //         }
    //         if(xmlhttp.readyState == 2 ) {
    //                 console.log("Headers Received");//check if the data was revived successfully.
    //         }
    //         if(xmlhttp.readyState == 3 ) {
    //                 console.log("Loading response entity body");//check if the data was revived successfully.
    //         }
    //         if(xmlhttp.readyState == 4) {
    //             if(xmlhttp.status == 200) {
    //                     console.log("Data transfer to " + url + " completed"); //check if the data was revived successfully.
    //                     var response = xmlhttp.responseText;
    //                     console.log(response);
    //             } else {
    //                     alert("Data lost");
    //             }
    //
    //         }
    //     }
    // }


    // function curlToStudent(payload) {
    //     var url = "https://cs490-somsai002.c9users.io/php/front/student.php";
    //     //var url = "https://web.njit.edu/~sv389/frontend.php";
    //     var xmlhttp = new XMLHttpRequest();
    //
    //     xmlhttp.open("POST", url , true);
    //     xmlhttp.onreadystatechange = display_data;
    //     //xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //     xmlhttp.send(payload);
    //
    //     function display_data() {
    //         if(xmlhttp.readyState == 4) {
    //             if(xmlhttp.status == 200) {
    //                     console.log("Data transfer to " + url + " completed"); //check if the data was revived successfully.
    //                     var response = xmlhttp.responseText;
    //                     console.log(response);
    //             } else {
    //                     alert("Data lost");
    //             }
    //
    //         }
    //     }
    // }
