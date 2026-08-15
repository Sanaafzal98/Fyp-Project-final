<?php
if(isset($_FILES['image'])){
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_name = $_FILES['image']['name'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://127.0.0.1:8000/predict',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'file' => new CURLFile($file_tmp, $_FILES['image']['type'], $file_name)
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    echo "Prediction for " . $result['filename'] . ": " . $result['prediction'];
}
?>
