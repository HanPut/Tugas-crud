<?php
include '../database/db.php';
if (isset($_GET['id'])) {
    $produk = mysqli_query($conn, "SELECT gambar FROM barang WHERE id = '" . $_GET['id'] . "' ");
    $p = mysqli_fetch_object($produk);

    unlink('../upload/' . $p->gambar);

    $delete = mysqli_query($conn, "DELETE FROM barang WHERE id = '" . $_GET['id'] . "'");
    echo '<script>window.location="data-produk.php"</script>';
}
?>