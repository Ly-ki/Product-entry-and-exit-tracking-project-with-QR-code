<?php

session_start();

include_once "./response.php";

if ($_SESSION["status"] !== "2") {

    header("Location: https://dijitalari.com/qr/login.php");

}

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);

    $types = mysqli_real_escape_string($conn, $_POST['types']);

    $pass =mysqli_real_escape_string($conn, md5($_POST['pass']));



    if (!empty($name) && !empty($nickname) && !empty($pass) && !empty($types)) {

        $data = "SELECT * FROM user WHERE nickname = '$nickname'";

        if ($res = mysqli_query($conn, $data)) {

            if (mysqli_num_rows($res) > 0) {

                echo "

                <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                <script>

                       setTimeout(function () {

                        swal('Hata!!!', Kayıtlı Kullanıcı Bulunmaktadır!', 'warning');    

                 },500);

               </script>   

                ";

            } else {

                $sql = "INSERT INTO user (names,nickname,pass,u_status) VALUES ('{$name}','{$nickname}','{$pass}','{$types}')";

                if (mysqli_query($conn, $sql)) {

                    echo "

               <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

               <script>

                      setTimeout(function () {

                       swal('Başarılı', 'Başarılı Bir Şekilde Kayıt Olundu', 'success');    

                },500);                          

                </script>   

               ";

                } else {

                    echo "

                 <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                 <script>

                        setTimeout(function () {

                         swal('Hata!!!', Kayıt Olunamadı!', 'warning');    

                  },500);

                </script>   

                 ";

                }

            }

        }

    }

}

include_once "header.php";

?>





<div class="container-fluid">

    <div class="row">

        <div class="col-12 col-md-3 col-lg-4 col-xxl-3 leftSidebar" style="padding: 0 !important; height: 100vh;">

            <div class="leftLogo">

                <a href="./"> <img src="./assets/img/logo-atlantic.png" class="img-fluid" alt=""></a>

            </div>

            <div class="leftTopBar d-flex">

                <div class="ikon">

                    <i class="fa fa-cart-shopping"></i>

                </div>

                <div class="leftText">Alınan Ürünler</div>

            </div>

            <div class="leftProducts">

                <?php

                $u_id = $_SESSION["u_id"];

                $data = "SELECT * FROM products WHERE u_id = '$u_id' and stat= 1 ORDER BY completion_date DESC";

                if ($res = mysqli_query($conn, $data)) {

                    if (mysqli_num_rows($res) > 0) {

                        echo "<table id='myTable' class='display'>";

                        echo "<thead>";

                        echo "<tr>";

                        echo "<th scope='col'>Ürün Adı</th>";

                        echo "<th scope='col'>Alındığı Tarih</th>";

                        echo "<th scope='col'>İade</th>";

                        echo "</tr>";

                        echo "</thead>";

                        echo "<tbody>";

                        while ($row = mysqli_fetch_array($res)) {

                            echo "<tr>";

                            echo "<td>" . $row['product'] . "</td>";

                            echo "<td>" . $row['completion_date'] . "</td>";

                            echo "<td><a href='./?product_delete=" . $row['id'] . "'><button class='bttnClick' id='bttnW'>İade Et</button></a></td>";

                            echo "</tr>";

                        }

                        echo "</tbody>";

                        echo "</table>";

                    } else {

                        echo  "<h4 class='noProduct'>

                     <i class='fa-solid fa-ban'></i>

                     Ürün Bulunamadı

                  </h4>";

                    }

                }

                ?>

            </div>

        </div>

        <div class="col-12 col-md-9 col-lg-8 col-xxl-9 bg-dark" style="padding: 0 !important; height: 100vh;">

            <div class="rightTopBar">

                <h5>Hoşgeldin, <span><?php echo $_SESSION["sname"]; ?></span></h5>

                <div class="rs">

                    <?php if ($_SESSION["status"] == "2") {

                        echo "<a href='productadd' title='Ürün Ekle'>  <i class='fa-solid fa-cart-plus'></i></a>";

                    }

                    ?>

                    <i title="Çıkış Yap" class="fa-regular fa-user users"></i>

                    <div class="logout">

                        <?php if ($_SESSION["status"] == "2") {

                            echo "<a href='users' title='Kullanıcılar'> Kullanıcılar</a><br>";

                            echo "<a href='user-products' title='Alınan Ürünler'> Alınan Ürünler</a><br>";

                            echo "<a href='products' title='Tüm Ürünler'> Tüm Ürünler</a>";

                        }

                        ?>

                        <a href="logout">

                            <p>Çıkış Yap</p>

                        </a>

                    </div>

                </div>

            </div>

            <div class="rightTable">

                <div class="formReg">

                    <div class="loginTopBar">

                        <img src="./assets/img/logo-atlantic.png" alt="">

                    </div>



                    <div class="regMid">

                        <form action="" method="post">

                            <div class="formS">

                                <input class="regInput" type="text" name="name" placeholder="Ad & Soyad" required>

                                <input class="regInput" type="text" name="nickname" placeholder="Kullanıcı Adı: baris.simsek" required>

                            </div>

                            <div class="formS">

                                <input class="regInput" type="password" name="pass" placeholder="Şifre" required>

                                <select class="form-select regInput" name="types" aria-label="Default select example" required>

                                    <option selected value="1">Personel</option>

                                    <option value="2">Yönetici</option>

                                </select>

                            </div>

                            <button id="bttnW" class="mt-4" type="submit" name="send"><i class="fa-solid fa-user-plus" style="padding-right: 10px;"></i>Kullanıcı Ekle</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" charset="utf8" src="./assets/js/datatable.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script charset="windows-1254" type="text/javascript" src="./assets/js/app.js"></script>

</body>



</html>