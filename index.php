<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Web</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/global.css">
    <style>
        .table tr td a {
            display: inline-block;
            padding: 5px 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .table tr td a[href^="edit"] {
            background-color: #007bff;
        }

        .table tr td a[href^="proses-hapus"] {
            background-color: #dc3545;
        }

        .table tr a[href^="edit"]:hover {
            background-color: #0056b3;
        }

        .table tr a[href^="proses-hapus"]:hover {
            background-color: #dc3549;
        }
    </style>
</head>

<body>
    <div class="section">
        <div class="container">
            <h3>Daftar Barang</h3>
            <div class="box">
                <p><a href="tambah-produk.php" class="sdsdf12dxsf">Tambah</a></p>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr style="background-color: #0056b3; color: white">
                            <th style="padding: 10px;">Photo</th>
                            <th style="padding: 30px;">Nama Barang</th>
                            <th style="padding: 30px;">Kategori</th>
                            <th style="padding: 30px;">Harga Jual</th>
                            <th style="padding: 30px;">Harga Beli</th>
                            <th style="padding: 30px;" width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php
                        $no = 1;
                        $produk = mysqli_query($conn, "SELECT b.id, b.nama as nama_barang, b.harga_beli, b.harga_jual, b.gambar, k.nama as nama_kategori FROM barang as b JOIN kategori as k ON k.id = b.id_kategori");
                        if (mysqli_num_rows($produk) > 0) {
                            while ($row = mysqli_fetch_array($produk)) {
                                ?>
                                <tr>
                                    <td><a href="../upload/<?php echo $row['gambar'] ?>" target="_blank"> <img
                                                src="../upload/<?php echo $row['gambar'] ?>" width="100px"> </a>
                                    </td>
                                    <td>
                                        <?= $row['nama_barang'] ?>
                                    </td>
                                    <td>
                                        <?= $row['nama_kategori'] ?>
                                    </td>
                                    <td>
                                        <?= $row['harga_jual'] ?>
                                    </td>
                                    <td>
                                        <?= $row['harga_beli'] ?>
                                    </td>
                                    <td>
                                        <a href="edit-produk.php?id=<?php echo $row['id'] ?>">Edit</a>
                                        <a href="proses-hapus.php?id=<?php echo $row['id'] ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">X</a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>