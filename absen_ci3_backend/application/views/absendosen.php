
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
            </style>
            <?php
            
            $qry_smt = "SELECT IFNULL((SELECT konten FROM unpam_setting WHERE jenis='semester'),1) semester";            
            $rsl_smt = single_query($this->db->query($qry_smt));
            for($smt = 1;$smt<=$rsl_smt->semester;$smt++){
                echo "<table border='1' width='100%'>";
                echo "<thead><tr><th width='250px' rowspan='2'>DOSEN</th><th width='80px'  rowspan='2'>MATKUL</th><th width='80px'  rowspan='2'>SKS</th><th colspan='$tweek'>PERTEMUAN SEMESTER $smt</th></tr>";
                // echo "<th width='250px'>Dosen</th><th  width='80px'>Matkul</th>";            
                for($z=$fweek;$z<=$lweek;$z++){
                    echo "<th>".$z."</th>";
                }
                echo "</thead>";
                foreach($result as $key =>$hasil){
                    $qry_dosen = "select minggu,absen as absen,sum(absen) as total,
                                group_concat(minggu,'-',absen) as absen_dtl,min_absen
                                from (
                                SELECT url_matkul,WEEK(min(absen_time)) as minggu,COUNT(WEEK(absen_time)) AS absen,ifnull(ifnull(b.`matkul_min_absen`,c.min_absen),2) as min_absen
                                FROM unpam_absensi a LEFT JOIN unpam_dosen_matkul b
                                ON a.`url_matkul`=b.`matkul_url` AND nim !='dosen'
                                left join unpam_matkul c
                                on b.`matkul_dosen`=c.`dosen`
                                WHERE matkul_dosen='$hasil->dosen'
                                and semester='$smt'
                                GROUP BY a.url_matkul,WEEK(absen_time)
                                ORDER BY minggu) ab
                                GROUP BY url_matkul
                                ORDER BY minggu";
                    $rsl_dosen = each_query($this->db->query($qry_dosen));
                    
                    $result_array = [];
                    if(!$rsl_dosen){
                        continue;
                    }
                    foreach ($rsl_dosen as $key => $row) {
                        $newObject = new stdClass();
                        $newObject->minggu = $row->minggu;
                        $newObject->absen = $row->absen;
                        $newObject->total = $row->total;
                        $newObject->absen_dtl = $row->absen_dtl;
                        $newObject->min_absen = $row->min_absen;
                        $result_array[$row->minggu] = $newObject; 
                    }
                    echo "<tr>";
                    echo "<td>".Uw($hasil->dosen)."</td>";
                    echo "<td>".$hasil->matkul_singkat."</td>";     
                    echo "<td class='ce'>".$hasil->sks."</td>";     
                    for($z=$fweek;$z<=$lweek;$z++){
                        // dbg($result_array[$z]->absen);
                        if(isset($result_array[$z])){
                            $ttl_absen = $result_array[$z]->total;
                            $min_absen = $result_array[$z]->min_absen;
                            // echo $ttl_absen . ($tsiswa*$min_absen);
                            // echo "</br>";
                            if($ttl_absen<($tsiswa*$min_absen)){
                                $cls = "kurang";
                            }else{                            
                                $cls = "";
                            }
                            echo "<td  class='tdc $cls' alt='".$result_array[$z]->absen_dtl."'>".$result_array[$z]->total."</td>";
                        }else{
                            echo "<td  class='tdb'></td>";
                        };
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
            <script>
                const tableCells = document.querySelectorAll('td[alt]'); // Get all table cells with alt attribute

                tableCells.forEach(cell => {
                let popup; // Declare popup variable outside of event listeners

                cell.addEventListener('mouseover', (event) => {
                    popup = document.createElement('div');
                    popup.classList.add('popup'); 
                    const altContent = cell.getAttribute('alt');
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
                });

                cell.addEventListener('mouseout', () => {
                    if (popup) {
                    popup.style.display = 'none';
                    popup.remove();
                    popup = null;
                    }
                });
                });


            </script>