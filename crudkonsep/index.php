<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>CRUD System with Pagination</title>
    <style>
        .pagination {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-top: 20px;
}
.pagination a {
    color: #333;
    padding: 8px 12px;
    text-decoration: none;
    border: 1px solid #ddd;
    margin: 0 4px;
    font-size: 14px;
    border-radius: 4px;
    transition: background-color 0.3s;
}
.pagination a.active {
    background-color: #D1B280;
    color: white;
    border-color: black;
}
.pagination a:hover {
    background-color: #E1C699;
    color: #333;
}
</style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>
        <a href="create.php" class="btn">Tambah Pengguna Baru</a>
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Cari berdasarkan nama" required>
            <button type="submit" class="btn-search">Cari</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Tentukan jumlah data per halaman
                    $dataPerPage = 5;

                    // Dapatkan halaman saat ini
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $dataPerPage;

                    // Hitung total data
                    $totalDataQuery = "SELECT COUNT(*) AS total FROM pendaftar";
                    $totalDataResult = $conn->query($totalDataQuery);
                    $totalData = $totalDataResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalData / $dataPerPage);

                    // Mengambil data dengan limit dan offset
                    $sql = "SELECT * FROM pendaftar LIMIT $start, $dataPerPage";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["name"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["phone"] . "</td>
                                    <td>
                                        <a href='update.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                        <a href='delete.php?id=" . $row["id"] . "' class='btn-delete'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
