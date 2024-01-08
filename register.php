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
    <?php 
        //menyertakan file program koneksi.php
        require('koneksi.php');
        //inisialisasi session
        session_start();

        $error = '';
        $validate = '';
        if(isset($_SESSION['user'])) header('Location: index.php');
        //mengecek apakah data username yang diinputkan 
        if(isset($_POST['submit'])){
            //menghilangkan backslashes
            $username = stripslashes($_POST['username']);
            //cara sederhana mengamankan dari sql injection
            $username = mysqli_real_escape_string($con, $username);
            $name = stripslashes($_POST['nama']);
            $name = mysqli_real_escape_string($con, $name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $password = stripslashes($_POST['pass']);
            $password = mysqli_real_escape_string($con, $password);
            $repassword = stripslashes($_POST['repassword']);
            $repassword = mysqli_real_escape_string($con, $repassword);
            //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
            if(!empty(trim($name)) && !empty(trim($username))&& !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repassword))){
                //mengecek apakah password yang diinputkan sama dengan repassword
                if($password == $repassword){
                    //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar
                    if(cek_nama($name, $con) == 0){
                        //hashing password sebelum disimpan di database
                        $pass = password_hash($password, PASSWORD_DEFAULT);
                        //insert data ke database
                        $query = "INSERT INTO admins (name, username, email, pass) VALUES ('$username','$name', '$pass', '$email')";
                        $result = mysqli_query($con, $query);
                        //jika insert data berhasil maka akan di redirect ke halaman index.php serta menyimpan data username ke session
                        if($result){
                            $_SESSION['username'] = $username;
                            header('location: index.php');
                        }else{
                            $error = 'Register User Gagal';
                        }
                    }else{
                        $error = 'Username sudah terdaftar';
                    }
                }else{
                    $validate = 'Password tidak boleh kosong';
                }
            }else{
                $error = 'Data tidak boleh kosong';
            }
        }

        //fungsi untuk mengecek username apakah sudah terdaftar atau belum
        function cek_nama($username, $con){
            $nama = mysqli_real_escape_string($con, $username);
            $query = "SELECT * FROM admins WHERE username = '$nama'";
            if($result = mysqli_query($con, $query)) return mysqli_num_rows($result);
        }
    ?> 

        <section class="container-fluid mb-4">
            <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
            <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
                <form class="form-container" action="register.php" method="POST">
                    <h4 class="text-center font-weight-bold">SIGN UP</h4>
                    <?php if($error != ''){
                        ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div><?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp" placeholder="Masukkan email Anda">
                    </div>
                    <div>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda">
                    </div>
                    <div>
                        <label for="inputPassword">Password</label>
                        <input type="password"class="form-control" id="inputPassword" name="pass"placeholder="Masukkan password Anda">
                        <?php if($validate != ''){?>
                        <p class="text-danger"><?= $validate; ?></p>
                    <?php }?>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Repassword</label>
                        <input type="password"class="form-control" id="inputRepassword" name="repassword" placeholder="Re- password">
                        <?php if($validate !=''){?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                    <div class="form-footer mt-2">
                        <p>Sudah punya account? <a href="login.php">Login</a></p>
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