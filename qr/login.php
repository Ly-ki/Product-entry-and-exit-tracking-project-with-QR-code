<?php

session_start();

include_once "response.php";

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);

    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));



    if (!empty($nickname) && !empty($pass)) {

        $data = "SELECT * FROM user WHERE nickname = '$nickname' and pass = '$pass' and u_status > 0";

        if ($res = mysqli_query($conn, $data)) {

            if (mysqli_num_rows($res) == 1) {

                $row = mysqli_fetch_array($res);

                $_SESSION["u_id"] = $row['id'];

                $_SESSION["sname"] = $row['names'];

                $_SESSION["k_adi"] = $row['nickname'];

                $_SESSION["status"] = $row['u_status'];

                echo "

                <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                <script>

                       setTimeout(function () {

                        swal('Başarılı',' Başarılı Bir Şekilde Giriş Yapıldı', 'success');    

                 },500);

                 setTimeout(function () {

                    window.location.href= 'https://dijitalari.com/qr';

                 },1000);

               </script>   

                ";

            } else {



                echo "

                 <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                 <script>

                        setTimeout(function () {

                         swal('Hata!!!',' Kullanıcı adı veya şifre yanlış', 'warning');    

                  },500);                  

                </script>   

                 ";

            }

        }

    }

}

include_once "header.php";

?>

<div class="container-fluid bg-dark regContent">

    <div class="formReg">

        <div class="loginTopBar">

            <img src="./assets/img/logo-atlantic.png" alt="">

        </div>



        <div class="regMid">

            <form action="" method="post">

                <input class="regInput" type="text" name="nickname" placeholder="Kullanıcı Adı">

                <input class="regInput" type="password" name="pass" placeholder="Şifre">

                <button class="regBtn" type="submit" name="send">Giriş Yap</button>

            </form>

        </div>

        <div class="regBottom">

            <a href="#!">

                <i class="fa-solid fa-lock"></i>

                <p>Şifremi Unuttum?</p>

            </a>

        </div>

    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</script>

</body>



</html>