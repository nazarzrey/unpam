<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table { border-collapse: collapse; width: 100%; }
        body { font-family: Verdana, sans-serif; margin: 0; }
        th, td { font-size: 12px; padding: 5px; text-align: center; }
        th { font-size: 14px; }
        .tdb { background: #f1f1f1; }
        .kurang { background: #f3e29f; }
        .kurang2 { background: #f8ff47;border:solid 2px #ff0000 !important }
        .popup {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            font-size: 14px;
            max-width: 400px;
        }
        .tdc:hover { background: tomato; }
        .ce { text-align: center !important; }
        .cl { text-align: left; }
        .cr { text-align: right; }
        .tr { text-align: right; }
        .pert { background: #b1ffcf; }
        .judul { padding: 10px; font-size: 18px; }
        .perj { background: #8ae2be; font-size: 14px; font-weight: normal; }
        .sync { width: 70px; font-size: 10px; }
        th { text-align: center; }
        .nav-buttons { margin: 10px 0; text-align: right; margin-right: 70px; }
        .hidden { display: none; }
        .mobile { display: none; }
        .desktop { display: revert; }
        @media only screen and (max-width: 800px) {
            .sync { width: 40px; font-size: 10px; }
            .mobile { display: revert; }
            .desktop { display: none; }
            .tdc, .tdb { width: 45px; }
        }
        .double{
            border:double 2px blue;
        }
    </style>
</head>
<body>
    <?php 
    // dbg($this->session->userdata);
        if($this->session->userdata("tipe")=="admin"){
            require_once(APPPATH.'views/menu_adm.php');
        }
    ?>
    <?php
    $totalWeeks = $lweek - $fweek + 1;
    $columnsToShowDesktop = 10;
    $columnsToShowMobile = 3;
    $initialStartDesktop = $totalWeeks - $columnsToShowDesktop + 1;
    $initialStartMobile = $totalWeeks - $columnsToShowMobile + 1;

    echo "<div class='judul text-center'>$siswa : $nim - PERTEMUAN SEMESTER 1 - Minggu ke $totalWeeks</div>";
    echo "<div class='nav-buttons'>
            <button id='prev-btn' class='btn btn-primary'>&lt;</button>
            <button id='next-btn' class='btn btn-primary'>&gt;</button>
          </div>";
    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr><th rowspan='2'>DOSEN</th><th rowspan='2'><span class='desktop'>MATKUL</span><span class='mobile'>MAT KUL</span></th><th class='desktop' rowspan='2'>SKS</th><th rowspan='2'><span class='desktop ce'>MIN ABSEN</span><span class='mobile'>MIN ABS</span></th>";
    
    for ($z = $fweek; $z <= $lweek; $z++) {
        $frw = $z == $fweek ? "id='first-week'" : "";
        echo "<th class='perj week-$z' $frw><span class='desktop'>" . getLastDateOfCurrentWeek($z, 1, 6)["date"] . "</span><span class='mobile'>" . str_replace("-", " ", getLastDateOfCurrentWeek($z, 1, 6)["date"]) . "</span></th>";
    }
    echo "<th rowspan='2' style='width:20px'>LAST SYNC</th>";
    echo "</tr><tr>";
    for ($z = $fweek; $z <= $lweek; $z++) {
        echo "<th class='pert week-$z'>" . ($z - ($fweek - 1)) . "</th>";
    }
    echo "</tr></thead><tbody>";

    foreach ($result as $key => $hasil) {
       $qry_mhs = "SELECT a.url_matkul,
                    b.`matkul_fordis`,
                    b.`matkul_fordis_title`,
                    WEEK(MIN(a.absen_time)) AS minggu,
                    COUNT(CASE WHEN a.nim LIKE '$nim%' THEN 1 ELSE NULL END) AS absen,
                    IFNULL(b.matkul_min_absen, IFNULL(c.min_absen, 2)) AS min_absen
                    FROM unpam_absensi a
                    LEFT JOIN unpam_dosen_matkul b ON a.url_matkul = b.matkul_url AND a.nim != 'dosen'
                    LEFT JOIN unpam_matkul c ON b.matkul_dosen = c.dosen
                    WHERE b.matkul_dosen = '$hasil->dosen'
                    GROUP BY a.url_matkul
                    ORDER BY WEEK(MIN(a.absen_time))";
       $qry_dosen = "SELECT GROUP_CONCAT(DISTINCT url_matkul SEPARATOR ',') AS url_matkul,
                        GROUP_CONCAT(DISTINCT CONCAT(matkul_fordis_title,' : (',absen,')') SEPARATOR '#') AS double_title, 
                        GROUP_CONCAT(minggu, '-', absen) AS absen_dtl,
                        CASE WHEN COUNT(minggu) > 1 THEN COUNT(minggu) ELSE 1 END AS double_tugas,
                        minggu,SUM(absen) AS absen,min_absen
                    FROM ($qry_mhs) abcd
                    GROUP BY minggu;";
// echo "<br/>";
        $rsl_dosen = each_query($this->db->query($qry_dosen));
        
        // dbg($rsl_dosen);
        $result_array = [];
        foreach ($rsl_dosen as $row) {
            $newObject = new stdClass();
            $newObject->minggu = $row->minggu;
            $newObject->absen = $row->absen;
            // $newObject->total = $row->total;
            $newObject->double_tugas = $row->double_tugas;
            $newObject->double_title = $row->double_title;
            $newObject->absen_dtl = $row->absen_dtl;
            $newObject->min_absen = $row->min_absen;
            $newObject->url_matkul = $row->url_matkul;
            $result_array[$row->minggu] = $newObject;
        }

        echo "<tr>";
        echo "<td class='cl'>" . Uw($hasil->dosen) . "</td>";
        echo "<td class=''><span>" . substr($hasil->matkul_singkat, 0, 3) . "</span></td>";
        echo "<td class='ce desktop'>" . $hasil->sks . "</td>";
        echo "<td class='ce'>" . $hasil->min_absen . "</td>";
        for ($z = $fweek; $z <= $lweek; $z++) {
            $dbl = "";
            if (isset($result_array[$z])) {
                if($result_array[$z]->double_tugas>1 ){
                    $dbl = "double";
                    $cls = $result_array[$z]->absen < ($result_array[$z]->min_absen*$result_array[$z]->double_tugas) ? "kurang2" : "";
                }else{
                    $cls = $result_array[$z]->absen < $result_array[$z]->min_absen ? "kurang" : "";
                }
                echo "<td class='tdc $cls week-$z $dbl' alt='" . $result_array[$z]->double_title . "' uri='" . $result_array[$z]->url_matkul . "'>" . $result_array[$z]->absen . "</td>";
            } else {
                echo "<td class='tdb week-$z'></td>";
            }
        }

        echo "<td class='ce sync'><span class='desktop'>" . $hasil->sync . "</span><span class='mobile'>" . str_replace("-", "", $hasil->sync) . "</span></td>";
        echo "</tr>";
    }
    echo "<tr><td class='kurang tr'>Nilai < dari minimal Absen</td><td rowspan='4' colspan='".($tweek+4)."' class='tr' id='target_link'></td></tr>";
    echo "<tr><td class='pert tr'>Pertemuan Minggu ke </td></tr>";
    echo "<tr><td class='pert tr'>last sync  ".($sync)."</td></tr>";
    echo "<tr><td class='tr kurang2'>nilai < dari dobel tugas</td></tr>";
    echo "</tbody></table>";
    echo "<div class='m-2 mt-3'>
            <a href='" . base_url('login/logout') . "' class='btn btn-sm btn-danger w-100'>Logout</a>
          </div>";
    ?>

    <script>
        const wScreen = screen.width;
        const totalWeeks = <?= $totalWeeks + ($fweek - 1) ?>;
        const columnsToShowDesktop = 10;
        const columnsToShowMobile = 3;
        const columnsToShow = wScreen >= 800 ? columnsToShowDesktop : columnsToShowMobile;
        let currentStart = totalWeeks - columnsToShow + 1;
        console.log(currentStart);

        function updateVisibility() {
            for (let i = 1; i <= totalWeeks; i++) {
                const elements = document.querySelectorAll(`.week-${i}`);
                elements.forEach(el => {
                    if (i >= currentStart && i < currentStart + columnsToShow) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
            }

            // Update the state of the Previous and Next buttons
            document.getElementById('prev-btn').disabled = currentStart <= ((wScreen>=800?columnsToShow-2:columnsToShowDesktop-2))
            document.getElementById('next-btn').disabled = currentStart >= totalWeeks - columnsToShow + 1;
        }

        document.getElementById('prev-btn').addEventListener('click', () => {
            if (currentStart > 1) {
                currentStart--;
                updateVisibility();
            }
        });
        document.getElementById('next-btn').addEventListener('click', () => {
            if (currentStart < totalWeeks - columnsToShow + 1) {
                currentStart++;
                updateVisibility();
            }
        });

        updateVisibility();

        const tableCells = document.querySelectorAll('td[alt], td[uri]');
        tableCells.forEach(cell => {
            let popup;

            cell.addEventListener('mouseover', (event) => {
                popup = document.createElement('div');
                popup.classList.add('popup');
                const altContent = cell.getAttribute('alt');
                const uriContent = cell.getAttribute('uri');
                const target = document.getElementById('target_link');
                if (uriContent) {
                    target.innerHTML = uriContent + "<br/>Klik 2x di kotaknya untuk langsung membuka halaman e-learning";
                }
                if (altContent) {
                    const formattedContent = altContent.split('#').map(pair => {
                        const [meeting] = pair.split('#');
                        return `${meeting} \n`;
                    }).join('\n');

                    popup.textContent = formattedContent;
                    document.body.appendChild(popup);
                    popup.style.display = 'block';
                    const cellRect = cell.getBoundingClientRect();
                    const popupWidth = popup.offsetWidth;
                    const leftEdgePosition = event.clientX - popupWidth / 2;
                    const rightEdgePosition = event.clientX + popupWidth / 2;
                    const popWidth = 160;
                    if (leftEdgePosition < 0) {
                        popup.style.left = '0px';
                    } else if (rightEdgePosition + popWidth > window.innerWidth) {
                        popup.style.left = (window.innerWidth - (popWidth * 1.5)) + 'px';
                    } else {
                        const maxLeftPosition = event.clientX - popupWidth / 2;
                        popup.style.left = Math.max(maxLeftPosition, 0) + 'px';
                    }
                    popup.style.top = event.clientY + 10 + 'px';
                }
            });

            cell.addEventListener('mouseout', () => {
                const target = document.getElementById('target_link');
                if (popup) {
                    popup.style.display = 'none';
                    popup.remove();
                    popup = null;
                    target.innerHTML = "";
                }
            });

            // cell.addEventListener('dblclick', () => {
            //     const uri = cell.getAttribute('uri');
            //     if (uri) {
            //         window.open(uri, '_blank');
            //     }
            // });

            cell.addEventListener('dblclick', () => {
                const uri = cell.getAttribute('uri');
                if (uri) {
                    const urls = uri.split(','); // Split the URLs by comma
                    urls.forEach(url => {
                        const trimmedUrl = url.trim(); // Trim any extra whitespace
                        if (trimmedUrl) {
                            window.open(trimmedUrl, '_blank'); // Open each URL in a new tab                            
                        }
                    });
                }
            });


            cell.addEventListener('click', () => {
                const uri = cell.getAttribute('uri');
                const target = document.getElementById('target_link');
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(uri)
                        .then(() => {
                            console.log('URI copied to clipboard successfully!');
                            target.innerHTML = 'URI copied to clipboard successfully!';
                        })
                        .catch(err => {
                            console.error('Failed to copy URI to clipboard:', err);
                        });
                } else {
                    const textArea = document.createElement('textarea');
                    textArea.value = uri;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    textArea.remove();
                    console.log('URI copied to clipboard (fallback method).');
                }
            });
        });
    </script>
</body>
</html>

