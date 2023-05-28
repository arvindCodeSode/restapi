## API token for simple authentication, Use in header

- name::  x-api-key
- value::  5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE
- Example::  header( 'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE');

## Get ALL Subscribers
- Method:: GET
- Endpoint::  /api/user

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/api/user',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE',
    'Cookie: PHPSESSID=46d07afv33geucfm6em77po4vo'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

### Response 

{
    "status": 1,
    "data": [
        {
            "id": "1",
            "name": "User",
            "email": "user@gmail.com"
        },
        {
            "id": "2",
            "name": "John sina",
            "email": "johndoe@gmail.com"
        }
    ]
}

?>

## Get Single Subscriber
- Method:: GET
- EndPoint: /api/user/2 
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/api/user/2',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE',
    'Cookie: PHPSESSID=40qng6pnqjivfmqph2m6o1tbd3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

### Response 

{
    "status": 1,
    "data": [
        {
            "id": "2",
            "name": "User",
            "email": "user@gmail.com"
        },
    ]
}


## Add Subscriber
- Method:: POST
- Endpoint: /api/user/

form_data in array
$arr=['name'=>'Arvind Parkash','email'=>'arvind@gmail.com']

Example

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/api/user',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name' => 'Peter Parker','email' => 'peterparker@gmail.com'),
  CURLOPT_HTTPHEADER => array(
    'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE',
    'Cookie: PHPSESSID=40qng6pnqjivfmqph2m6o1tbd3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

### Response

{
    "status": 1,
    "msg": "Subscriber added successfully",
    "data": {
        "id": "6",
        "name": "Peter Parker",
        "email": "peterparker@gmail.com"
    }
}


## update Subscriber
- Method:: POST
- _method::  PUT :: use PUT method as the form data to update the subscriber data
- Endpoint: /api/user/1
- form_data in array
- $arr=['name'=>'Arvind Parkash','email'=>'arvind@gmail.com','_method'=>'PUT']

### Example

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/restapi/api/user/4',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name' => 'User','email' => 'user1@gmail.com','_method' => 'PUT'),
  CURLOPT_HTTPHEADER => array(
    'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE',
    'Cookie: PHPSESSID=40qng6pnqjivfmqph2m6o1tbd3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

### Response
{"status":1,"msg":"Subscriber updated Successfully"}


## DELETE Subscriber

- Method:: POST
- _method::  DELETE -> use DELETE method as the form data paramter to delete the records
- Endpoint: /api/user/1

form_data in array
$arr=['_method'=>'DELETE']

Example

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/restapi/api/user/1',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('_method' => 'DELETE'),
  CURLOPT_HTTPHEADER => array(
    'x-api-key: 5bCbNTZtmyB8pSPrDSc6Wu2nN25WSXaWQlZ7KuGCgE',
    'Cookie: PHPSESSID=40qng6pnqjivfmqph2m6o1tbd3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

### Response
{"status":1,"msg":"Subscriber deleted Successfully"}