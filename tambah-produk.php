<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Pemrograman Web</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
    <div class="section">
        <div class="container">
            <h3>Tambah Barang</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama" class="input" placeholder="Nama Produk" required>
                    <select class="input" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['id'] ?>"><?php echo $r['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="harga_beli" class="input" placeholder="Harga Beli" required>
                    <input type="text" name="harga_jual" class="input" placeholder="Harga Jual" required>
                    <input type="file" name="gambar" class="input" required>
                    <input type="submit" name="submit" value="Submit" class="btn1">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $nama = $_POST['nama'];
                    $kategori = $_POST['kategori'];
                    $harga_beli = $_POST['harga_beli'];
                    $harga_jual = $_POST['harga_jual'];
                    $gambar = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name']; // Ambil lokasi sementara file yang diunggah

                    $type1 = explode('.', $gambar);
                    $type2 = strtolower(end($type1)); // Pastikan tipe file diubah ke huruf kecil

                    $newname = 'produk' . time() . '.' . $type2;
                
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    // Validasi format file
                    if (!in_array($type2, $tipe_diizinkan)) {
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    } else {
                        // Pindahkan file ke folder tujuan
                        if (move_uploaded_file($tmp_name, '../upload/' . $newname)) {
                            // Tambahkan data ke database
                            $insert = mysqli_query($conn, "INSERT INTO barang (nama, id_kategori, harga_beli, harga_jual, gambar) VALUES (
                                '" . $nama . "',
                                '" . $kategori . "',
                                '" . $harga_beli . "',
                                '" . $harga_jual . "',
                                '" . $newname . "'
                            )");

                            if ($insert) {
                                echo '<script>alert("Tambah data berhasil")</script>';
                                echo '<script>window.location="data-produk.php"</script>';
                            } else {
                                echo 'Gagal menyimpan ke database: ' . mysqli_error($conn);
                            }
                        } else {
                            echo '<script>alert("Gagal mengunggah gambar")</script>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>
