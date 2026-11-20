
<?php
include_once("auth.php");
include_once("config.php");

$error = "";

if (isset($_POST['Submit'])) {

    $nama_alat = trim($_POST['nama_alat']);
    $tahun = trim($_POST['tahun']);
    $merek = trim($_POST['merek']);
    $lokasi = trim($_POST['lokasi']);
    $kondisi = trim($_POST['kondisi']);

    if (
        $nama_alat == "" ||
        $tahun == "" ||
        $merek == "" ||
        $lokasi == "" ||
        $kondisi == ""
    ) {
        $error = "Semua data harus diisi!";
    } elseif (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2100) {
        $error = "Tahun tidak valid!";
    } else {

        $stmt = mysqli_prepare(
            $mysqli,
            "INSERT INTO alat (nama_alat, tahun, merek, lokasi, kondisi)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $nama_alat,
            $tahun,
            $merek,
            $lokasi,
            $kondisi
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal menambahkan data: " . mysqli_error($mysqli);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Alat SIMRS</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f1f5f9;
    color: #1e293b;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #142d4e;
    color: white;
    position: fixed;
    padding: 25px 15px;
}

.logo {
    text-align: center;
    padding: 15px;
    margin-bottom: 30px;
    border-bottom: 1px solid #35506e;
}

.logo h2 {
    font-size: 25px;
}

.logo p {
    font-size: 12px;
    color: #b9c9dc;
    margin-top: 7px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 14px;
    margin-bottom: 8px;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #254b75;
    transform: translateX(5px);
}

.sidebar a.active {
    background: #2563eb;
}

.sidebar .logout {
    margin-top: 30px;
    background: #9f3030;
}

.sidebar .logout:hover {
    background: #c0392b;
}

/* KONTEN */
.main {
    margin-left: 240px;
    padding: 30px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.header {
    margin-bottom: 25px;
}

.header h1 {
    font-size: 28px;
    margin-bottom: 8px;
}

.header p {
    color: #64748b;
}

/* FORM */
.form-box {
    background: white;
    max-width: 750px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-box h2 {
    margin-bottom: 25px;
    color: #142d4e;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    outline: none;
    transition: 0.3s;
    background: white;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

/* BUTTON */
.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn-simpan {
    background: #2563eb;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 7px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-simpan:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

.btn-kembali {
    background: #64748b;
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 7px;
    transition: 0.3s;
}

.btn-kembali:hover {
    background: #475569;
}

/* ERROR */
.error {
    background: #fee2e2;
    color: #991b1b;
    padding: 12px;
    border-radius: 7px;
    margin-bottom: 20px;
}

/* FOOTER */
.footer {
    margin-top: 25px;
    text-align: center;
    color: #64748b;
    font-size: 13px;
}

/* RESPONSIVE */
@media(max-width:650px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .main {
        margin-left: 0;
        padding: 15px;
    }

    .form-box {
        padding: 20px;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        <h2>SIMRS</h2>
        <p>Alat Elektromedis</p>
    </div>

    <a href="index.php">🏠 Dashboard</a>

    <a href="index.php">📋 Data Alat</a>

    <a href="add.php" class="active">➕ Tambah Alat</a>

    <a href="logout.php" class="logout"
       onclick="return confirm('Yakin ingin logout?')">
        🚪 Logout
    </a>

</div>

<!-- KONTEN -->
<div class="main">

    <div class="header">
        <h1>Tambah Alat Elektromedis</h1>
        <p>Masukkan data alat elektromedis ke dalam sistem SIMRS</p>
    </div>

    <div class="form-box">

        <h2>Form Data Alat</h2>

        <?php if ($error != "") { ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <form action="add.php" method="post">

            <!-- NAMA ALAT -->
            <div class="form-group">
                <label>Nama Alat</label>

                <input type="text"
                       name="nama_alat"
                       placeholder="Contoh: Monitor Pasien"
                       value="<?php echo htmlspecialchars($_POST['nama_alat'] ?? ''); ?>"
                       required>
            </div>

            <!-- TAHUN -->
            <div class="form-group">
                <label>Tahun Pengadaan</label>

                <input type="number"
                       name="tahun"
                       min="1900"
                       max="2100"
                       placeholder="Contoh: 2023"
                       value="<?php echo htmlspecialchars($_POST['tahun'] ?? ''); ?>"
                       required>
            </div>

            <!-- MEREK -->
            <div class="form-group">
                <label>Merek</label>

                <input type="text"
                       name="merek"
                       placeholder="Contoh: Mindray"
                       value="<?php echo htmlspecialchars($_POST['merek'] ?? ''); ?>"
                       required>
            </div>

            <!-- RUANGAN -->
            <div class="form-group">
                <label>Ruangan</label>

                <input type="text"
                       name="lokasi"
                       placeholder="Contoh: ICU, IGD, NICU, OK"
                       value="<?php echo htmlspecialchars($_POST['lokasi'] ?? ''); ?>"
                       required>
            </div>

            <!-- KEADAAN ALAT -->
            <div class="form-group">
                <label>Keadaan Alat</label>

                <select name="kondisi" required>

                    <option value="">-- Pilih Keadaan Alat --</option>

                    <option value="Baik"
                        <?php if(($_POST['kondisi'] ?? '') == 'Baik') echo 'selected'; ?>>
                        Baik
                    </option>

                    <option value="Tidak Baik"
                        <?php if(($_POST['kondisi'] ?? '') == 'Tidak Baik') echo 'selected'; ?>>
                        Tidak Baik
                    </option>

                    <option value="Dalam Perbaikan"
                        <?php if(($_POST['kondisi'] ?? '') == 'Dalam Perbaikan') echo 'selected'; ?>>
                        Dalam Perbaikan
                    </option>

                    <option value="Tidak Layak Pakai"
                        <?php if(($_POST['kondisi'] ?? '') == 'Tidak Layak Pakai') echo 'selected'; ?>>
                        Tidak Layak Pakai
                    </option>

                </select>
            </div>

            <!-- BUTTON -->
            <div class="btn-group">

                <button type="submit"
                        name="Submit"
                        class="btn-simpan">
                    💾 Simpan Data
                </button>

                <a href="index.php" class="btn-kembali">
                    Kembali
                </a>

            </div>

        </form>

    </div>

    <div class="footer">
        SIMRS - Sistem Informasi Manajemen Alat Elektromedis
    </div>

</div>

</body>
</html>
