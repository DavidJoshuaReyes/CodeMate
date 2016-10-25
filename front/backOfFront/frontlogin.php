<?php

// javascript -> php array
// You could use JSON.stringify(array) to encode your array in JavaScript, and then use $array=json_decode($_POST['jsondata']); in your PHP script to retrieve it.
session_start();

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

$username = $_POST['username'];
$password = $_POST['password'];

$payload = array (
    code => 1,
    username => $username,
    password => $password
    );

$middleURL = 'https://web.njit.edu/~dmr37/middlelogin.php';

$resp = post_to_url($middleURL, $payload);

if(strpos($resp, 'Instructor') !== false){

    $_SESSION['loggedin'] = 'yes';
    $_SESSION['user'] = $username;
    header('Location: ../instructor/home.php');

} elseif (strpos($resp, 'Student') !== false){
    $_SESSION['loggedin'] = 'yes';
    $_SESSION['user'] = $username;
    header('Location: ../student/home.php');

}
else {
    $_SESSION['loggedin'] = 'no';
    $_SESSION['user'] = $username;
    $_SESSION['pass'] = $password;
    $_SESSION['response'] = $resp;
    header('Location: ../login.php');
}

?>
