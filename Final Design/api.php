<?php
$uid = '999999999';
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://enka.network/api/uid/$uid?info",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HEADER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "User-Agent: YourCustomUserAgent", // reminder to make a variable and track something about what browser somebody uses (idk why the whole code breaks when I remove this line)
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

curl_close($curl);

$data = json_decode($body, true);
$formattedData = print_r($data, true);
echo "<pre>$formattedData</pre>";