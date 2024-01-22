<?php
include_once("koneksi.php");

// Initialize message variables
$successMessage = "";
$emptyDataMessage = "";

// Delete all data when the "Reset" button is clicked
if (isset($_POST['DeleteAll'])) {
    $deleteAll = mysqli_query($mysqli, "DELETE FROM absensi");
    $successMessage = "Data berhasil dihapus";
}

// Fetch all data from the database
$result = mysqli_query($mysqli, "SELECT * FROM absensi ORDER BY id DESC");

// Check if there is data in the result set
$dataExist = mysqli_num_rows($result) > 0;

if (isset($_POST['Submit'])) {
    // Validate input fields
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';

    // Check if input fields are empty
    if (empty($nama) || empty($jurusan)) {
        $emptyDataMessage = "Data masih kosong";
    } else {
        // Insert data into the database
        $add = mysqli_query($mysqli, "INSERT INTO absensi(nama, jurusan, waktu_kehadiran) VALUES('$nama', '$jurusan', NOW())");

        // Redirect to avoid resubmitting the form on page refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40;
            color: white;
        }

        h1 {
            color: #343a40;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        table {
            margin-top: 20px;
        }

        .alert {
            display: none; /* Initially hide alerts */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">ABSENSI</span>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">DAFTAR HADIR MAHASISWA</h1>
        <form action="" method="post" name="form_absen">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama">
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" class="form-control" name="jurusan" placeholder="Masukkan Jurusan">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger" name="DeleteAll">Reset</button>
                <button type="submit" class="btn btn-primary" name="Submit">Hadir</button>
            </div>
        </form>

        <!-- Display success message if data is deleted successfully -->
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success mt-3">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Waktu Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($r = mysqli_fetch_array($result)) {
                    ?>
                    <tr class="table-primary">
                        <td><?php echo $r['nama']; ?></td>
                        <td><?php echo $r['jurusan']; ?></td>
                        <td><?php echo $r['waktu_kehadiran']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Display message if data is empty -->
        <?php if (!$dataExist && !empty($emptyDataMessage)) : ?>
            <div class="alert alert-info mt-3">
                <?php echo $emptyDataMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if there is data in the result set
            var dataExist = <?php echo $dataExist ? 'true' : 'false'; ?>;

            if (dataExist) {
                // Show success message
                document.querySelector('.alert-success').style.display = 'block';
            } else {
                // Show empty data message
                document.querySelector('.alert-info').style.display = 'block';
            }
        });
    </script>
</body>

</html>
