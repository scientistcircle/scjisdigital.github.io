<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

// Menangani error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Membaca file CSV
$csvFile = 'uploads/petugas.csv';
$petugas = [];
if (file_exists($csvFile)) {
    $petugas = array_map('str_getcsv', file($csvFile));
}

// Waktu saat ini
$currentHour = date('H');
$currentMinute = date('i');
$currentDate = date('Y-m-d');

// Logo dan background dari upload
$logoPath = 'uploads/logo.png';
$backgroundPath = 'uploads/background.jpg';

// Running text
$runningTextPath = 'uploads/running_text.txt';
$runningText = file_exists($runningTextPath) ? file_get_contents($runningTextPath) : 'Selamat datang di Yayasan XYZ';

// Mengecek apakah sudah jam 10.00 dan sebelum jam 13.00
if (!empty($petugas)) {
    if (!isset($_SESSION['last_date']) || $_SESSION['last_date'] !== $currentDate) {
        // Pilih secara acak petugas Qabliyah
        $_SESSION['qabliyah'] = $petugas[array_rand($petugas)][0];
        // Pilih secara acak petugas Ba'diyah
        $_SESSION['ba_diyah'] = $petugas[array_rand($petugas)][1];
        $_SESSION['last_date'] = $currentDate;
    }
    $namaQabliyah = $_SESSION['qabliyah'];
    $namaBa_diyah = $_SESSION['ba_diyah'];
} else {
    $namaQabliyah = "";
    $namaBa_diyah = "";
}

// Format tanggal lengkap
$hari = date('l');
$tanggal = date('d');
$bulan = date('F');
$tahun = date('Y');

$bulan = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
][$bulan];

$hari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
][$hari];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Imam</title>
    <style>
        body {
            background: url('<?php echo $backgroundPath; ?>') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        #logo {
            text-align: center;
            margin: 40px auto 0px;
        }

        #logo img {
            width: 190px;
        }

        #imamSection h2 {
            margin-top: 10px;
            font-size: 170px;
            text-shadow: 4px 4px 20px rgba(0.5, 0.5, 0.5, 0.5);
            color: white;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        #runningText {
            background-color: #000;
            color: #fff;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }

        #runningText span {
            display: inline-block;
            padding-left: 100%;
            animation: scrollText linear infinite;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        #timeDisplay {
            font-size: 280px;
            text-shadow: 4px 4px 20px rgba(0.5, 0.5, 0.5, 0.5);
            color: white;
            font-weight: bold;
            text-align: center;
            margin: 0px 0;
            margin-bottom: 1px;
        }

        #dateDisplay {
            font-size: 110px;
            text-shadow: 4px 4px 15px rgba(0.5, 0.5, 0.5, 0.5);
            color: white;
            text-align: center;
            font-weight: bold;
            margin-top: 0px;
        }

    </style>
</head>
<body>
    <div id="logo">
        <img src="<?php echo $logoPath; ?>" alt="Logo Yayasan">
    </div>

    <div id="imamSection">
        <?php if ($currentHour >= 10 && $currentHour < 13 && !empty($petugas)): ?>
            <h2>Qabliyah: <?php echo htmlspecialchars($namaQabliyah); ?></h2>
            <h2>Ba'diyah: <?php echo htmlspecialchars($namaBa_diyah ?? 'Tidak ada'); ?></h2>
        <?php else: ?>
            <div id="timeDisplay"></div>
            <div id="dateDisplay"><?php echo "$hari, $tanggal $bulan $tahun"; ?></div>
        <?php endif; ?>
    </div>

    <div id="runningText">
        <span><?php echo htmlspecialchars($runningText); ?></span>
    </div>

    <audio id="beepSound" src="sounds/beep.mp3"></audio>

    <script>
        function updateTime() {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('timeDisplay').innerHTML = hours + ':' + minutes + ':' + seconds;

            // Cek untuk beep pada jam 11:45
            if (hours === '11' && minutes === '45') {
                beepSound.play();
                beepSound.play();
                beepSound.play();
            }
        }

        setInterval(function() {
            updateTime(); // Update waktu setiap detik
            checkRefreshTime(); // Cek waktu untuk refresh
        }, 1000);

        function checkRefreshTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();

            // Refresh pada jam 09.00 dan 13.00
            if ((hours === 10 && minutes === 0) || (hours === 13 && minutes === 0)) {
                console.log("Refreshing the page..."); // Debugging
                location.reload(); // Reload halaman
            }
        }

        updateTime(); // Initial call to display time immediately

        // Ambil elemen runningText
        const runningTextSpan = document.querySelector('#runningText span');

        // Dapatkan lebar elemen teks dan elemen running text
        const runningTextWidth = document.getElementById('runningText').offsetWidth;
        const textWidth = runningTextSpan.offsetWidth;

        // Hitung durasi animasi berdasarkan panjang teks
        const duration = textWidth / runningTextWidth * 10; // 30 detik adalah durasi default

        // Terapkan durasi animasi
        runningTextSpan.style.animationDuration = `${duration}s`;
    </script>
    
</body>
</html>
