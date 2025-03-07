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

    <script>$(document).ready(function() {
    var baseUrl = window.location.pathname; // Simpan URL dasar

    reload();

    $("#btn").click(function(){
        reload();
        var randomNumber = generateRandomNumber();
        var newUrl = baseUrl + '/' + randomNumber; // Tambahkan angka acak ke URL dasar

        history.pushState({ path: newUrl }, '', newUrl);
    });

    function reload(){
        $.ajax({
            url: '<?php echo base_url('api/forum/reply/'.$suri); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    var data = response.data;
                    // ... (loop dan tampilkan data)
                } else {
                    console.error(response.message);
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