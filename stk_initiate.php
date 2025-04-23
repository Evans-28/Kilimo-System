<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    date_default_timezone_set('Africa/Nairobi');

    // Replace these with your actual credentials
    $consumerKey = '8aa561G2oho8ky2N5CzqlcndWnIuj1FYh32zUxaDM3BmTKKm';
    $consumerSecret = 'HcoLkgGgRXaSwK9SCdkYOoSEEISOZVcWjWvKx9qSFvNJNnGs4dFW1LZac8kN1W9a';
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    $PartyA = $_POST['phone']; // Customer's phone number
    $Amount = $_POST['amount'];
    $AccountReference = '2255'; // Your account reference
    $TransactionDesc = 'Test Payment'; // Description of the transaction

    $Timestamp = date('YmdHis');

    // Generate password using business shortcode, passkey, and timestamp
    $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

    // Request access token
    $headers = ['Content-Type:application/json; charset=utf8'];
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);

    // Additional curl options for debugging and SSL certificate verification
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification
    $caCertPath = 'C:\\wamp64\\www\\KilimoKe 3rd Trial\\m_pesa\\cacert-2024-07-02.pem';
    curl_setopt($curl, CURLOPT_CAINFO, $caCertPath); // Path to the cacert.pem file

    // Check if the CA certificate file is accessible
    if (!file_exists($caCertPath)) {
        die("Error: CA certificate file not found at $caCertPath");
    }

    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($curl); // Capture curl error message
    curl_close($curl);

    $result = json_decode($result);

    if ($status == 200 && isset($result->access_token)) {
        $access_token = $result->access_token;

        // Prepare headers for STK push request
        $stkheader = ['Content-Type:application/json', 'Authorization:Bearer '.$access_token];
        $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        // Prepare data for STK push
        $curl_post_data = [
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => 'https://mydomain.com/path', // Replace with your actual callback URL
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        ];

        $data_string = json_encode($curl_post_data);

        // Initiate the STK push request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $initiate_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        // Additional curl options for SSL certificate verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification
        curl_setopt($curl, CURLOPT_CAINFO, $caCertPath); // Path to the cacert.pem file

        $curl_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl); // Capture curl error message
        curl_close($curl);

        if ($status == 200) {
            // Redirect user with a pop-up message
            echo "<script>
                    alert('Please check your phone for completion of payment.');
                    window.location.href = 'C:\wamp64\www\KilimoKe 3rd Trial\Home.html';
                  </script>";
        } else {
            // Handle the error if STK push request fails
            echo "<script>
                    alert('Error: " . $curl_error . "');
                    window.location.href = 'C:\wamp64\www\KilimoKe 3rd Trial\Home.html';
                  </script>";
        }
    } else {
        // Handle the error if access token request fails
        echo "<script>
                alert('Error: Unable to connect to the API. Please try again later.');
                window.location.href = 'C:\wamp64\www\KilimoKe 3rd Trial\Home.html';
              </script>";
        // Log the error details
        error_log("API Request Error: Status = $status, cURL Error = $curl_error, Response = " . print_r($result, true));
    }
}
?>
