$(document).ready(function(){
    $('#izinForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                alert(response); // Tampilkan pesan sukses atau error
                $('#izinForm')[0].reset(); // Reset form setelah pengiriman berhasil
            }
        });
    });
});
