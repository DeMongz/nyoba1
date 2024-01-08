<?php
require('koneksi.php');
session_start();

$error = '';
$validate = '';

// Mengecek apakah session username tersedia atau tidak, jika tersedia maka akan di redirect ke halaman index
if (isset($_SESSION['username'])) {
    header('Location:index.php');
}

// Mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, stripslashes($_POST['username']));
    $password = mysqli_real_escape_string($con, stripslashes($_POST['pass']));
    $userCaptcha = strtoupper($_POST['kodecaptcha']); // Mengubah captcha yang dimasukkan oleh pengguna menjadi huruf besar

        // Melakukan validasi username dan password
        if (!empty(trim($username)) && !empty(trim($password))) {
            $query = "SELECT * FROM admins WHERE username = '$username'";
            $result = mysqli_query($con, $query);

            if ($result) {
                $rows = mysqli_num_rows($result);

                if ($rows != 0) {
                    $hash = mysqli_fetch_assoc($result);
                    if ($_SESSION['username'] = $username && $_SESSION['pass'] = $password) {
                        header('Location:index.php');
                    } else {
                        $error = 'Gagal Login' . mysqli_error($con);
                    }
                } else {
                    $error = 'Username tidak ditemukan';
                }
            } else {
                $error = 'Error executing the query: ' . mysqli_error($con);
            }
        } else {
            $error = 'Data tidak boleh kosong';
        }
    }

?>

<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity= "sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<section class="container-fluid mb-4">
            <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
            <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
                <form class="form-container" action="" method="POST">
                    <h4 class="text-center font-weight-bold">SIGN UP</h4>
                    <?php if($error != ''){
                        ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div><?php
                    }
                    ?>
                    <div>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"placeholder="Masukkan username Anda">
                    </div>
                    <div>
                        <label for="inputPassword">Password</label>
                        <input type="password"class="form-control" id="inputPassword" name="pass"placeholder="Masukkan password Anda">
                        <?php if($validate != ''){?>
                        <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                    </div>
                    <div>
                        <label for="captcha">Captcha</label>
                        <img src="captcha.php" alt="gambar"/>
                        <input name="kodecaptcha" value="" maxlength="5"/>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                    <div class="form-footer mt-2">
                        <p>Belum punya account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </section>
            </section>
        </section>
        <!-- bootstrap requirement jquery pada posisi pertama, kemudian popper.js, dan yang terakhir bootstrap.js -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ60W/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>