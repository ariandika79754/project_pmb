<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 2mm;
            size: 74mm 105mm;
            /* A7 size */
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 65mm;
            height: 90mm;
            background: white;
        }

        .card {
            border: 3px solid #1e3a8a;
            border-radius: 15px;
            padding: 12px;
            width: 95%;
            height: 100%;
            box-sizing: border-box;
            text-align: center;
            background: #f0f9ff;
            /* Solid background instead of gradient */
            position: relative;
            overflow: hidden;
        }

        .header {
            margin-bottom: 6px;
            padding-bottom: 6px;
            border-bottom: 2px solid #3b82f6;
            position: relative;
            z-index: 10;
        }

        .logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
            margin: 0 auto 4px auto;
            display: block;
            background: white;
            border-radius: 50%;
            padding: 3px;
            border: 1px solid #e2e8f0;
        }

        .institusi {
            font-weight: bold;
            font-size: 9px;
            color: #1e3a8a;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .foto-container {
            margin: 4px auto 8px auto;
            position: relative;
            z-index: 10;
        }

        .foto {
            border-radius: 10px;
            width: 70px;
            height: 85px;
            object-fit: cover;
            border: 3px solid #3b82f6;
            display: block;
            margin: 0 auto;
        }

        .foto-placeholder {
            width: 70px;
            height: 85px;
            background: #e2e8f0;
            border: 3px solid #94a3b8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            margin: 0 auto;
        }

        .nama {
            font-size: 13px;
            font-weight: 900;
            margin: 6px 0 8px 0;
            color: #1e3a8a;
            text-transform: uppercase;
            line-height: 1.1;
            letter-spacing: 0.4px;
            max-height: 28px;
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        .qr-section {
            margin: 8px 0;
            position: relative;
            z-index: 10;
        }

        .qr-container {
            background: white;
            padding: 6px;
            border-radius: 10px;
            display: inline-block;
            border: 2px solid #e2e8f0;
        }

        .qr {
            width: 70px;
            height: 70px;
            display: block;
        }

        .kode-peserta {
            font-size: 12px;
            font-weight: bold;
            color: white;
            margin: 6px 0 2px 0;
            background: #3b82f6;
            /* Solid color instead of gradient */
            padding: 4px 12px;
            border-radius: 20px;
            border: none;
            display: inline-block;
            letter-spacing: 1.2px;
            position: relative;
            z-index: 10;
        }

        .footer-text {
            font-size: 10px;
            color: #ffffffff;
            margin-top: 2px;
            font-style: italic;
            position: relative;
            z-index: 10;
        }

        /* Simplified decorative elements for PDF compatibility */
        .square {
            position: absolute;
            background: #93c5fd;
            border-radius: 3px;
        }

        .square-1 {
            width: 12px;
            height: 12px;
            top: 25%;
            right: 15px;
        }

        .square-2 {
            width: 8px;
            height: 8px;
            top: 35%;
            left: 12px;
        }

        .square-3 {
            width: 10px;
            height: 10px;
            top: 55%;
            right: 20px;
        }

        .square-4 {
            width: 6px;
            height: 6px;
            top: 45%;
            left: 18px;
        }

        .square-5 {
            width: 14px;
            height: 14px;
            top: 65%;
            right: 12px;
        }

        .square-6 {
            width: 9px;
            height: 9px;
            top: 70%;
            left: 15px;
        }

        /* Simplified wave decoration */
        .wave-decoration {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background: #60a5fa;
            border-radius: 0 0 12px 12px;
            z-index: 5;
        }

        .wave-decoration::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 20px;
            background: #93c5fd;
            border-radius: 50px 50px 0 0;
        }

        /* Top border */
        .top-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: #3b82f6;
            border-radius: 12px 12px 0 0;
            z-index: 10;
        }

        /* Alternative logo placeholder for better PDF compatibility */
        .logo-placeholder {
            width: 30px;
            height: 30px;
            background: #3b82f6;
            border-radius: 50%;
            margin: 0 auto 4px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 10px;
            border: 2px solid white;
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- Top border -->
        <div class="top-border"></div>

        <!-- Decorative squares background -->
        <div class="square square-1"></div>
        <div class="square square-2"></div>
        <div class="square square-3"></div>
        <div class="square square-4"></div>
        <div class="square square-5"></div>
        <div class="square square-6"></div>

        <!-- Wave decoration at bottom -->
        <div class="wave-decoration"></div>

        <!-- Header dengan Logo dan Nama Institusi -->
        <div class="header">
            <?php if (!empty($logoBase64)): ?>
                <img class="logo" src="<?= $logoBase64 ?>" alt="Logo Politeknik">
            <?php else: ?>
                <div class="logo-placeholder">P</div>
            <?php endif; ?>
            <div class="institusi">Politeknik Negeri Lampung</div>
        </div>

        <!-- Foto Mahasiswa -->
        <div class="foto-container">
            <?php if (!empty($fotoBase64)): ?>
                <img class="foto" src="<?= $fotoBase64 ?>" alt="Foto Mahasiswa">
            <?php else: ?>
                <div class="foto-placeholder">
                    FOTO<br>BELUM<br>TERSEDIA
                </div>
            <?php endif; ?>
        </div>

        <!-- Nama Mahasiswa -->
        <div class="nama"><?= strtoupper(esc($mahasiswa['nama'] ?? '-')) ?></div>

        <!-- QR Code Section -->
        <div class="qr-section">
            <div class="qr-container">
                <?php if (!empty($qrBase64)): ?>
                    <img class="qr" src="<?= $qrBase64 ?>" alt="QR Code Verifikasi">
                <?php else: ?>
                    <div style="width: 70px; height: 70px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 8px; color: #6b7280; border: 1px solid #d1d5db;">QR CODE</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kode Peserta -->
        <div class="kode-peserta"><?= esc($mahasiswa['kode_peserta'] ?? '-') ?></div>
        <div class="footer-text">Scan untuk verifikasi identitas</div>
    </div>
</body>

</html>