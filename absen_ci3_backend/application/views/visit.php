<?php
// header('Content-Type: application/json; charset=utf-8');
if (!isset($sesi)) {
    echo json_encode(array("message", "not allowed"));
    return true;
}
?>
<script>
    function log_visit() {
        const getUA = () => {
            let device = "Unknown";
            const ua = {
                "Generic Linux": /Linux/i,
                "Android": /Android/i,
                "BlackBerry": /BlackBerry/i,
                "Bluebird": /EF500/i,
                "Chrome OS": /CrOS/i,
                "Datalogic": /DL-AXIS/i,
                "Honeywell": /CT50/i,
                "iPad": /iPad/i,
                "iPhone": /iPhone/i,
                "iPod": /iPod/i,
                "macOS": /Macintosh/i,
                "Windows": /IEMobile|Windows/i,
                "Zebra": /TC70|TC55/i,
            }
            Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
            return device;
        }
        return getUA()
    }
    var data = {
        id: '<?= $lnk_id ?>',
        ip: '<?= $ip ?>',
        browser: '<?= $bname ?>',
        vbrowser: '<?= $bversi ?>',
        os: '<?= $os ?>',
        device: log_visit(),
        screen: screen.width + "x" + screen.height,
		target: '<?= $target ?>'
    };
    var xmlhttp = new XMLHttpRequest();
    var url = "<?= base_url("log") ?>";
    xmlhttp.open("post", url, true);
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.replace(xmlhttp.responseText);
        }
    };
    xmlhttp.setRequestHeader("Content-type", "application/json") // or "text/plain"
    xmlhttp.send(JSON.stringify(data));
</script>