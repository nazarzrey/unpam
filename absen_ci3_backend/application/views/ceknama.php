<form name="cekdosen" action="" method="POST">
    Input namanya
</br>
    <input type="text" name="ceknama">
    <input type="submit" value="test">
</form>
<?php
    if(isseT($_POST["ceknama"])){
        $nm = $_POST["ceknama"];
        dbg(getNamaTanpaDosen($nm));
    }
    
?>