<!DOCTYPE html>
<html>
<head>
    <title>Forum View</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Halaman Forum</h1>
    <button id="btn">Refresh </button>
    <?php if(isset($uri)){
            $suri = $uri;
        }else{ 
            $suri = "";
        } ?>
    <p>Data JSON akan ditampilkan di konsol browser.</p>
    <?php
    $url_parts = $this->uri->segments;
        // Ambil 7 elemen pertama dari array
    $sliced_array = array_slice($url_parts, 1, 7);

    // Gabungkan elemen-elemen array menjadi string URL
    $base_url = 'http://' . implode('/', $sliced_array);

    // Tampilkan URL yang dihasilkan
    // echo $base_url;
    ?>
        <script>$(document).ready(function() {
    const baseUrl = "http://localhost/unpam/absen_ci3_backend/mentari.unpam.ac.id/u-courses/20242-03TPLE004-22TIF0152/forum/3b4ec307-c024-4d18-a8ce-84cbeb4da964/topics/02cc2b46-839a-4828-9fd0-18c01006f917";

    // alert(baseUrl);

    reload();

    $("#btn").click(function(){
        reload();
        var randomNumber = generateRandomNumber();
        var newUrl = baseUrl + '/' + randomNumber; // Tambahkan angka acak ke URL dasar
        history.pushState({ path: newUrl }, '', newUrl);
    });

    // http://localhost/unpam/absen_ci3_backend/api/forum/reply/9785
    // https://mentari.unpam.ac.id/api/quiz/peserta/6b470344-eb71-4753-9bd0-255f2af966f1
    function reload(){
        $.ajax({
            url: '<?php echo base_url('mentari.unpam.ac.id/api/forum/reply/'.$suri); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                if (response.status === 'success') {
                    var data = response.data;
                    // ... (loop dan tampilkan data)
                } else {
                    // console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function generateRandomNumber() {
        return Math.floor(Math.random() * 10000) + 1;
    }
});
    </script>

</body>
</html>