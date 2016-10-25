<?php

function post_to_url($url, $data) {
   
   $post = curl_init();

   curl_setopt($post, CURLOPT_URL, $url);
   curl_setopt($post, CURLOPT_POST, 1 );
   curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
   curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

   $result = curl_exec($post);
   curl_close($post);
   
   return $result;
}

function verifyNJITLogin($responseHTML) {
    $flag = strrpos($responseHTML, 'loginok.html');
   
    if($flag == 97)
        return true;
        
    return false;
}

// begin computation
$backendURL = 'https://web.njit.edu/~jt275/database.php';
$njitURL = 'https://cp4.njit.edu/cp/home/login';

$payloadBackend = array(
        'code' => 1,
        'username' => $_POST['username'],
        'password' => $_POST['password']
    );

$payloadNJIT = array(
        user => $username,
        pass => $password,
        uuid => '0xACA021'
    );
    
// still have to call functions

$backendResponse = post_to_url($backendURL, $payloadBackend);
printf($backendResponse);

?>