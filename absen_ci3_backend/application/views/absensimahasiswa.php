            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Dashboard</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>

            <style>
                table{border-collapse:collapse}body{font-family:verdana;margin:0}td{font-size:12px;padding:5px 2px;cursor:pointer}th{font-size:14px;padding:5px 0}.tdc{text-align:center}.tdb{background:#f1f1f1}
                .kurang{background:#f3e29f}
                .popup {
                    position: absolute; /* Make it absolute for positioning */
                    background-color: #fff; /* Set background color */
                    border: 1px solid #ccc; /* Add a border */
                    padding: 10px; /* Add padding for content */
                    display: none; /* Initially hide the popup */
                    font-size:14px;
                    width:150px
                }
                .tdc:hover{background:tomato}
                .ce{text-align:center}
                .tdc,.tdb{
                    <?= $lweek <= 20 ? "width:50px" :"width:40px"; ?>;
                    height:20px !important;
                }
                .tr{text-align:right}
                .pert{background:#b1ffcf}
                .judul{padding:10px;font-size:20px}
                .perj{background:#8ae2be;font-size:14px;font-weight:normal}
                .sync{width: 70px;font-size:10px}
                th{text-align:center}
            </style>
            <?php
            echo "<table border='1' width='100%'>";
            echo "<thead>";
            echo "<th class='judul text-center' colspan='".($tweek+5)."'>$siswa : $nim - PERTEMUAN SEMESTER 1</th>";
            echo "<tr><th width='250px' rowspan='2'>DOSEN</th><th width='80px'  rowspan='2'>MATKUL</th><th width='80px'  rowspan='2'>SKS</th><th width='80px'  rowspan='2'>MIN ABSEN</th>";
            // echo "<th width='250px'>Dosen</th><th  width='80px'>Matkul</th>";            
            for($z=$fweek;$z<=$lweek;$z++){
                echo "<th class='perj'>".getLastDateOfCurrentWeek($z,1,6)["date"]."</th>";
            }
            echo "<th class='perj'>Last</th>";
            echo "</tr>";
            for($z=$fweek;$z<=$lweek;$z++){
                echo "<th class='pert'>".($z-($fweek-1))."</th>";
            }
            echo "<th class='pert'>Sync</th>";
            echo "</thead>";
            // dbg(getLastDateOfCurrentWeek(0,1,6));
            foreach($result as $key =>$hasil){
                $qry_mhs = "SELECT a.url_matkul,
                            WEEK(MIN(a.absen_time)) AS minggu,
                            COUNT(CASE WHEN a.nim LIKE '$nim%' THEN 1 ELSE NULL END) AS absen,
                            IFNULL(b.matkul_min_absen, IFNULL(c.min_absen, 2)) AS min_absen
                            FROM unpam_absensi a
                            LEFT JOIN unpam_dosen_matkul b ON a.url_matkul = b.matkul_url AND a.nim != 'dosen'
                            LEFT JOIN unpam_matkul c ON b.matkul_dosen = c.dosen
                            WHERE b.matkul_dosen = '$hasil->dosen'
                            GROUP BY a.url_matkul
                            ORDER BY WEEK(MIN(a.absen_time))";
                $qry_dosen = "select url_matkul,minggu,absen as absen,sum(absen) as total,
                            group_concat(minggu,'-',absen) as absen_dtl,min_absen
                            from (
                            $qry_mhs
                            ) ab
                            GROUP BY url_matkul
                            ORDER BY minggu";                            

                $rsl_dosen = each_query($this->db->query($qry_dosen));

                $result_array = [];
                foreach ($rsl_dosen as $key => $row) {
                    $newObject = new stdClass();
                    $newObject->minggu = $row->minggu;
                    $newObject->absen = $row->absen;
                    $newObject->total = $row->total;
                    $newObject->absen_dtl = $row->absen_dtl;
                    $newObject->min_absen = $row->min_absen;
                    $newObject->url_matkul = $row->url_matkul;
                    $result_array[$row->minggu] = $newObject; 
                }
                echo "<tr>";
                echo "<td>".Uw($hasil->dosen)."</td>";
                echo "<td>".$hasil->matkul_singkat."</td>";     
                echo "<td class='ce'>".$hasil->sks."</td>";     
                echo "<td class='ce'>".$hasil->min_absen."</td>";     
                for($z=$fweek;$z<=$lweek;$z++){
                    // dbg($result_array[$z]->absen);
                    if(isset($result_array[$z])){
                        $ttl_absen = $result_array[$z]->total;
                        $min_absen = $result_array[$z]->min_absen;
                        $absen = $result_array[$z]->absen;
                        // echo $ttl_absen . ($tsiswa*$min_absen);
                        // echo "</br>";
                        if($absen<$min_absen){
                            $cls = "kurang";
                        }else{                            
                            $cls = "";
                        }
                        echo "<td  class='tdc $cls' alt='".$result_array[$z]->absen_dtl."' uri='".$result_array[$z]->url_matkul."'>".$absen."</td>";
                    }else{
                        echo "<td  class='tdb'></td>";
                    };
                }
                echo "<td  class='ce sync'>".$hasil->sync."</td>";
                echo "</tr>";
            }
            echo "<tr><td class='kurang tr'>Nilai < dari minimal Absen</td><td rowspan='3' colspan='".($tweek+4)."' class='tr' id='target_link'></td></tr>";
            echo "<tr><td class='pert tr'>Pertemuan Minggu ke </td></tr>";
            echo "<tr><td class='pert tr'>last sync  ".($sync)."</td></tr>";
            echo "</table>";
            ?>
            <div class="m-2 mt-3">
                <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-sm btn-danger w-100">Logout</a>
            </div>
            <script>
               const tableCells = document.querySelectorAll('td[alt], td[uri]'); 
                tableCells.forEach(cell => {
                    let popup;

                    cell.addEventListener('mouseover', (event) => {
                        popup = document.createElement('div');
                        popup.classList.add('popup'); 
                        const altContent = cell.getAttribute('alt');
                        const uriContent = cell.getAttribute('uri');
                        const target =  document.getElementById('target_link');
                        if(uriContent){
                            target.innerHTML = uriContent+"<br/>Klik 2x di kotaknya untuk langsung membuka halaman elerning";
                        }
                        if (altContent) {
                            const formattedContent = altContent.split(',').map(pair => {
                                const [meeting, attendance] = pair.split('-');
                                return `Pertemuan ${meeting} = ${attendance}\n`; 
                            }).join('\n');
                            
                            popup.textContent = formattedContent;
                            const cellRect = cell.getBoundingClientRect();
                            const popupWidth = popup.offsetWidth;
                            const leftEdgePosition = event.clientX - popupWidth / 2;
                            const rightEdgePosition = event.clientX + popupWidth / 2;
                            const popWidth = 160;
                            if (leftEdgePosition < 0) {
                                popup.style.left = '0px';
                            } else if (rightEdgePosition + popWidth > window.innerWidth) {
                                console.log(popupWidth);
                                popup.style.left = (window.innerWidth - (popWidth*1.5)) + 'px';
                            } else {
                                const maxLeftPosition = event.clientX - popupWidth / 2;
                                popup.style.left = Math.max(maxLeftPosition, 0) + 'px';
                            }
                            popup.style.top = event.clientY + 10 + 'px';
                            document.body.appendChild(popup);
                            popup.style.display = 'block';
                        }
                    });

                    cell.addEventListener('mouseout', () => {
                        const target2 =  document.getElementById('target_link');
                        if (popup) {
                            popup.style.display = 'none';
                            popup.remove();
                            popup = null;
                            target2.innerHTML = "";
                        }
                    });

                    cell.addEventListener('dblclick', () => {
                        const uri = cell.getAttribute('uri');
                        if (uri) {
                            window.open(uri, '_blank');
                        }
                    });
                    cell.addEventListener('click', () => {
                        const uri = cell.getAttribute('uri');
                        // Modern approach (navigator.clipboard.writeText) - preferred
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(uri)
                            .then(() => {
                            console.log('URI copied to clipboard successfully!');
                            })
                            .catch(err => {
                            console.error('Failed to copy URI to clipboard:', err);
                            });
                        } else {
                        // Fallback for older browsers (create a temporary element)
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