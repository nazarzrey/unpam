<?php
class PearsonAlgorithm {
    private $numProcesses;
    private $turn;
    private $wantsToEnter;

    public function __construct($numProcesses) {
        $this->numProcesses = $numProcesses;
        $this->turn = 0;
        $this->wantsToEnter = array_fill(0, $numProcesses, false);
    }

    public function enterCriticalSection($processId) {
        // Menandakan bahwa proses ingin masuk ke bagian kritis
        $this->wantsToEnter[$processId] = true;

        // Menunggu giliran
        while ($this->turn != $processId) {
            if (!$this->wantsToEnter[$this->turn]) {
                $this->turn = $processId;
            }
        }

        // Memasuki bagian kritis
        echo "Process $processId is in the critical section." . PHP_EOL;
        usleep(rand(100000, 500000)); // Simulasi kerja di bagian kritis (100ms - 500ms)

        // Menandakan bahwa proses telah keluar dari bagian kritis
        $this->wantsToEnter[$processId] = false;
        $this->turn = ($processId + 1) % $this->numProcesses;
    }

    public function process($processId) {
        while (true) {
            $this->enterCriticalSection($processId);
            echo "Process $processId is exiting the critical section." . PHP_EOL;
            usleep(rand(100000, 500000)); // Simulasi kerja di bagian non-kritis
        }
    }
}

// Jumlah proses yang akan disinkronisasi
$numProcesses = 3;
$pearsonAlgorithm = new PearsonAlgorithm($numProcesses);

// Simulasi proses
$processes = [];
for ($i = 0; $i < $numProcesses; $i++) {
    $processes[$i] = function () use ($pearsonAlgorithm, $i) {
        $pearsonAlgorithm->process($i);
    };
}

// Jalankan simulasi
foreach ($processes as $process) {
    // Karena PHP tidak mendukung multithreading bawaan, kita simulasi dengan pemanggilan loop manual
    $process();
}
