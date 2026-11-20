
<?php
include_once("auth.php");
include_once("config.php");

// PENCARIAN DAN FILTER
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_lokasi = isset($_GET['lokasi']) ? trim($_GET['lokasi']) : '';
$filter_kondisi = isset($_GET['kondisi']) ? trim($_GET['kondisi']) : '';

$cari_sql = mysqli_real_escape_string($mysqli, $cari);
$lokasi_sql = mysqli_real_escape_string($mysqli, $filter_lokasi);
$kondisi_sql = mysqli_real_escape_string($mysqli, $filter_kondisi);

// QUERY DATA
$query = "SELECT * FROM alat WHERE 1=1";

if ($cari != '') {
    $query .= " AND (
        nama_alat LIKE '%$cari_sql%'
        OR merek LIKE '%$cari_sql%'
        OR lokasi LIKE '%$cari_sql%'
    )";
}

if ($filter_lokasi != '') {
    $query .= " AND lokasi = '$lokasi_sql'";
}

if ($filter_kondisi != '') {
    $query .= " AND kondisi = '$kondisi_sql'";
}

$query .= " ORDER BY lokasi ASC, nama_alat ASC";

$result = mysqli_query($mysqli, $query);

// DAFTAR RUANGAN
$daftar_lokasi = mysqli_query(
    $mysqli,
    "SELECT DISTINCT lokasi FROM alat ORDER BY lokasi ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Alat Elektromedis</title>

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

/* KONTEN */
.main {
    margin-left: 240px;
    padding: 30px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 30px;
}

.header h1 {
    margin-bottom: 8px;
    font-size: 28px;
}

.header p {
    color: #64748b;
}

.user {
    background: white;
    padding: 12px 18px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* TABEL */
.table-box {
    background: white;
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow-x: auto;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.table-header h2 {
    font-size: 20px;
}

.btn-tambah {
    display: inline-block;
    background: #2563eb;
    color: white;
    text-decoration: none;
    padding: 11px 16px;
    border-radius: 7px;
}

.btn-tambah:hover {
    background: #1d4ed8;
}

/* PENCARIAN DAN FILTER */
.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.filter-form input,
.filter-form select {
    padding: 11px;
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    outline: none;
    background: white;
}

.filter-form input {
    flex: 1;
    min-width: 180px;
}

.filter-form input:focus,
.filter-form select:focus {
    border-color: #2563eb;
}

.btn-filter {
    background: #2563eb;
    color: white;
    border: none;
    padding: 11px 16px;
    border-radius: 7px;
    cursor: pointer;
}

.btn-reset {
    background: #64748b;
    color: white;
    text-decoration: none;
    padding: 11px 16px;
    border-radius: 7px;
}

/* TABEL DATA */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

th {
    background: #142d4e;
    color: white;
    padding: 13px;
    text-align: left;
}

td {
    padding: 13px;
    border-bottom: 1px solid #e2e8f0;
}

tbody tr:hover {
    background: #eaf2ff;
}

/* PENGELOMPOKAN RUANGAN */
.room-header td {
    background: #e8eef8;
    color: #142d4e;
    font-weight: bold;
    padding: 14px;
    border-top: 2px solid #cbd5e1;
}

/* BADGE KONDISI */
.badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.badge-baik {
    background: #dcfce7;
    color: #166534;
}

.badge-rusak {
    background: #fee2e2;
    color: #991b1b;
}

.badge-perbaikan {
    background: #fef3c7;
    color: #92400e;
}

.badge-tidaklayak {
    background: #e2e8f0;
    color: #334155;
}

/* TOMBOL AKSI */
.edit {
    color: #2563eb;
    text-decoration: none;
    font-weight: bold;
}

.hapus {
    color: #dc2626;
    text-decoration: none;
    font-weight: bold;
}

.edit:hover,
.hapus:hover {
    opacity: 0.7;
    text-decoration: underline;
}

.footer {
    margin-top: 25px;
    color: #64748b;
    text-align: center;
    font-size: 13px;
}

/* RESPONSIVE */
@media(max-width: 650px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .main {
        margin-left: 0;
        padding: 15px;
    }

    .header {
        align-items: flex-start;
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
    <a href="data_alat.php" class="active">📋 Data Alat</a>
    <a href="add.php">➕ Tambah Alat</a>

    <a href="logout.php" class="logout"
       onclick="return confirm('Yakin ingin logout?')">
       🚪 Logout
    </a>

</div>

<!-- KONTEN -->
<div class="main">

    <div class="header">
        <div>
            <h1>Data Alat Elektromedis</h1>
            <p>Sistem Informasi Manajemen Alat Elektromedis</p>
        </div>

        <div class="user">
            👤 <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="table-box">

        <div class="table-header">
            <h2>Data Alat Elektromedis</h2>

            <a href="add.php" class="btn-tambah">
                + Tambah Alat
            </a>
        </div>

        <!-- PENCARIAN DAN FILTER -->
        <form method="GET" class="filter-form">

            <input type="text"
                   name="cari"
                   placeholder="🔍 Cari nama alat, merek, ruangan..."
                   value="<?php echo htmlspecialchars($cari); ?>">

            <select name="lokasi">
                <option value="">Semua Ruangan</option>

                <?php while ($l = mysqli_fetch_assoc($daftar_lokasi)) { ?>
                    <option value="<?php echo htmlspecialchars($l['lokasi']); ?>"
                        <?php if ($filter_lokasi == $l['lokasi']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($l['lokasi']); ?>
                    </option>
                <?php } ?>
            </select>

            <select name="kondisi">
                <option value="">Semua Kondisi</option>

                <option value="Baik"
                    <?php if ($filter_kondisi == 'Baik') echo 'selected'; ?>>
                    Baik
                </option>

                <option value="Tidak Baik"
                    <?php if ($filter_kondisi == 'Tidak Baik') echo 'selected'; ?>>
                    Tidak Baik
                </option>

                <option value="Dalam Perbaikan"
                    <?php if ($filter_kondisi == 'Dalam Perbaikan') echo 'selected'; ?>>
                    Dalam Perbaikan
                </option>

                <option value="Tidak Layak Pakai"
                    <?php if ($filter_kondisi == 'Tidak Layak Pakai') echo 'selected'; ?>>
                    Tidak Layak Pakai
                </option>
            </select>

            <button type="submit" class="btn-filter">
                Cari / Filter
            </button>

            <a href="data_alat.php" class="btn-reset">
                Reset
            </a>

        </form>

        <!-- TABEL -->
        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Tahun</th>
                    <th>Merek</th>
                    <th>Ruangan</th>
                    <th>Keadaan Alat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = 1;
            $ruangan_sebelumnya = '';

            if ($result && mysqli_num_rows($result) > 0) {

                while ($data = mysqli_fetch_assoc($result)) {

                    $ruangan = $data['lokasi'];
                    $kondisi = $data['kondisi'] ?? 'Baik';

                    // HEADER RUANGAN
                    if ($ruangan != $ruangan_sebelumnya) {
            ?>

                <tr class="room-header">
                    <td colspan="7">
                        📍 RUANG <?php echo htmlspecialchars($ruangan); ?>
                    </td>
                </tr>

            <?php
                        $ruangan_sebelumnya = $ruangan;
                    }

                    // WARNA KONDISI
                    if ($kondisi == 'Baik') {
                        $badge = 'badge-baik';
                    } elseif ($kondisi == 'Tidak Baik') {
                        $badge = 'badge-rusak';
                    } elseif ($kondisi == 'Dalam Perbaikan') {
                        $badge = 'badge-perbaikan';
                    } else {
                        $badge = 'badge-tidaklayak';
                    }
            ?>

                <tr>
                    <td><?php echo $no++; ?></td>

                    <td>
                        <?php echo htmlspecialchars($data['nama_alat']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($data['tahun']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($data['merek']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($data['lokasi']); ?>
                    </td>

                    <td>
                        <span class="badge <?php echo $badge; ?>">
                            <?php echo htmlspecialchars($kondisi); ?>
                        </span>
                    </td>

                    <td>
                        <a class="edit"
                           href="edit.php?id=<?php echo $data['id']; ?>">
                           Edit
                        </a>

                        |

                        <a class="hapus"
                           href="delete.php?id=<?php echo $data['id']; ?>"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                           Delete
                        </a>
                    </td>
                </tr>

            <?php
                }

            } else {
            ?>

                <tr>
                    <td colspan="7" style="text-align:center;">
                        Data alat tidak ditemukan.
                    </td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>

    <div class="footer">
        SIMRS - Sistem Informasi Manajemen Alat Elektromedis
    </div>

</div>

</body>
</html>
