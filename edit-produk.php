<?php
include '../database/db.php';

$produk = mysqli_query($conn, "SELECT * FROM barang WHERE id = '" . $_GET['id'] . "' ");
if (mysqli_num_rows($produk) == 0) {
    echo '<script>window.location="data-produk.php"</script>';
}
$p = mysqli_fetch_object($produk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Web</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
</head>

<body>
    <div class="section">
        <div class="container">
            <h3>Edit Barang</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama" class="input" placeholder="Nama Produk"
                        value="<?php echo $p->nama ?>" required>
                    <select class="input" name="kategori" required>
                        <option value="">--Pilih--</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['id'] ?>" <?php echo ($r['id'] == $p->id_kategori) ? 'selected' : ''; ?>><?php echo $r['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="harga_beli" class="input" placeholder="Harga Beli"
                        value="<?php echo $p->harga_beli ?>" required>
                    <input type="text" name="harga_jual" class="input" placeholder="Harga Jual"
                        value="<?php echo $p->harga_jual ?>" required>

                    <input type="hidden" name="gambar_lama" value="<?php echo $p->gambar ?>">
                    <input type="file" name="gambar" class="input">

                    <input type="submit" name="submit" value="Submit" class="btn1">
                </form>
                <?php
                if (isset($_POST['submit'])) {

                    // Data inputan dari form
                    $kategori = $_POST['kategori'];
                    $nama = $_POST['nama'];
                    $harga_beli = $_POST['harga_beli'];
                    $harga_jual = $_POST['harga_jual'];
                    $gambar_lama = $_POST['gambar_lama'];

                    // Data gambar yang baru
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    if ($filename != '') {
                        // Jika admin mengganti gambar
                        $type1 = explode('.', $filename);
                        $type2 = strtolower(end($type1));

                        $newname = 'produk' . time() . '.' . $type2;

                        // Menampung data format file yang diizinkan
                        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                        // Validasi format file
                        if (!in_array($type2, $tipe_diizinkan)) {
                            echo '<script>alert("Format file tidak diizinkan")</script>';
                        } else {
                            // Hapus gambar lama jika ada
                            if (file_exists('../upload/' . $gambar_lama)) {
                                unlink('../upload/' . $gambar_lama);
                            }

                            // Upload gambar baru
                            move_uploaded_file($tmp_name, '../upload/' . $newname);
                            $namagambar = $newname;
                        }
                    } else {
                        // Jika admin tidak mengganti gambar
                        $namagambar = $gambar_lama;
                    }

                    // Query update data produk
                    $update = mysqli_query($conn, "UPDATE barang SET 
                                            id_kategori = '" . $kategori . "',
                                            nama = '" . $nama . "',
                                            harga_beli = '" . $harga_beli . "',
                                            harga_jual = '" . $harga_jual . "',
                                            gambar = '" . $namagambar . "' 
                                            WHERE id = '" . $p->id . "' ");
                    if ($update) {
                        echo '<script>alert("Ubah data berhasil")</script>';
                        echo '<script>window.location="data-produk.php"</script>';
                    } else {
                        echo 'Gagal: ' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>