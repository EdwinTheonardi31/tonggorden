<?php
include "../config/connection.php";

$idproduk = mysqli_real_escape_string($conn, $_POST['idproduk']);
$kode = mysqli_real_escape_string($conn, $_POST['kode']);
$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
$warna = mysqli_real_escape_string($conn, $_POST['idwarna']);
$motif = mysqli_real_escape_string($conn, $_POST['idmotif']);

//update data teks
$sql = "UPDATE produk SET kode='$kode', 
				     	  kategori='$kategori',
				     	  idwarna='$warna',
				     	  idmotif='$motif'
				     	  WHERE idproduk='$idproduk' ";
mysqli_query($conn, $sql);

$foto_cek = $_FILES['foto']['name'];
if($foto_cek != "")
{
	$folder   = "../images/produk";
	$foto_tmp = $_FILES['foto']['tmp_name'];
	$foto_name= md5(date("YmdHis"));
	$foto_split=explode(".", $foto_cek); //memecahkan string berdasarkan titik
	$ext = end($foto_split); //hasil array terakhir adalah ekstensi file
	$foto = $foto_name.".".$ext;
	move_uploaded_file($foto_tmp, "$folder/$foto");

	//hapus foto lama
	$qry = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk' ");
	$row = mysqli_fetch_array($qry);
	if(!empty($row['foto']))
	{
		unlink("../images/produk/$row[foto]"); //hapus foto produk
	}

	//update foto baru
	$sql = "UPDATE produk SET foto = '$foto' WHERE idproduk='$idproduk' ";
	mysqli_query($conn, $sql);
} 
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Dashboard</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <!-- Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="../assets/css/adminstyle.css">

        <!-- JS -->
        <script src="../assets/js/script.js"></script>
        
        <!-- Custom styles for this page -->
        <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    </head>
    <body>

	<!-- Produk Save Modal -->
	<div class="modal fade" id="produkEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Berhasil diubah!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Tekan "OK" untuk kembali ke daftar produk.</div>
                    <div class="modal-footer">
                        <a class="btn btn-primary" href="dashboard.php?menu=produk">OK</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Font Awesome Kit -->
        <script src="https://kit.fontawesome.com/178b5bff75.js" crossorigin="anonymous"></script>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        
        <!-- Bootstrap core JavaScript-->
        <script src="../assets/vendor/jquery/jquery.min.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../assets/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../assets/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../assets/js/demo/chart-area-demo.js"></script>
        <script src="../assets/js/demo/chart-pie-demo.js"></script>

        <!-- Page level plugins -->
        <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../assets/js/demo/datatables-demo.js"></script>

		<script>
			$(document).ready(function() {
				// Show the modal when the page is fully loaded
				$("#produkEditModal").modal("show");
			});
		</script>
    </body>

</html>