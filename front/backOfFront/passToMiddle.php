<?php

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

session_start();

// get json contents and check what the code is
$str_json = file_get_contents('php://input');
$content = json_decode($str_json);

// middle URL
$middle = 'https://web.njit.edu/~dmr37/controller.php';

// get result
$result = post_to_url($middle, $content);
printf($result);

?>
