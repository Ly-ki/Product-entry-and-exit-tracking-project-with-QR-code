<?php

session_start();

include_once "./response.php";

date_default_timezone_set('Europe/Istanbul');

$date = date('d.m.Y H:i:s');

if ($_SESSION["status"] !== "2") {

    header("Location: https://dijitalari.com/qr/login.php");

}

$p_id = $_GET["product_delete"];

$ses_id = $_SESSION["u_id"];

if ($p_id and $_SESSION["status"] > "0") {

    $p_select = "SELECT * FROM products WHERE id = '$p_id' and u_id = '$ses_id'";

    $res = mysqli_query($conn, $p_select);

    if (mysqli_num_rows($res) > 0) {

        $sql = "UPDATE products  SET return_date = '{$date}', stat = '0' WHERE id='$p_id'";

        if (mysqli_query($conn, $sql)) {

            echo "

         <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

         <script>

                setTimeout(function () {

                 swal('Başarılı', 'Ürün Başarılı Bir Şekilde Silindi', 'success');    

          },500);

          setTimeout(function () {

            window.location.href= './';

         },800);             

          </script>   

         ";

        } else {

            echo "

           <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

           <script>

                  setTimeout(function () {

                   swal('Hata!!!',' Ürün Silinemedi!', 'warning');    

            },500);

          </script>   

           ";

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

        <div class="col-12 col-md-9 col-lg-8 col-xxl-9 bg-dark mobCols" style="padding: 0 !important; height: 100vh;">

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

                            echo "<a href='products' title='Alınan Ürünler'> Tüm Ürünler</a>";

                        }

                        ?>

                        <a href="logout">

                            <p>Çıkış Yap</p>

                        </a>

                    </div>

                </div>

            </div>

            <div class="rightTable">

                <?php

                echo "<a href='./productadd'><button class='bttnClick' id='bttnW'><i class='fa-solid fa-cart-plus'></i> Ürün Ekle</button></a>";





                $data = "SELECT * FROM product_detail ORDER BY id DESC";

                if ($res = mysqli_query($conn, $data)) {

                    if (mysqli_num_rows($res) > 0) {

                        echo "<table id='myTable_2' class='display'>";

                        echo "<thead>";

                        echo "<tr>";

                        echo "<th scope='col'>Kullanıcı</th>";

                        echo "<th scope='col'>Ürün</th>";

                        echo "<th scope='col'>Stok Kodu</th>";

                        echo "<th scope='col'>Ürün Barkod</th>";

                        echo "<th scope='col'>Düzenle / Sil</th>";

                        echo "</tr>";

                        echo "</thead>";

                        echo "<tbody>";

                        while ($row = mysqli_fetch_array($res)) {

                            echo "<tr>";

                            echo "<td>" . $row['names'] . "</td>";

                            echo "<td>" . $row['product'] . "</td>";

                            echo "<td>" . $row['stk'] . "</td>";

                            echo "<td><a href='./assets/img/uploads/" . $row['p_path'] . "' data-lightbox='r1' data-title='Başlığımız'><img width='45' src='./assets/img/uploads/" . $row['p_path'] . "''></a></td>";

                            echo "<td class='mobTable'>

                            <a href='./productsedit?product_edit=" . $row['id'] . "'><button class='bttnClick' id='bttnW'><i class='fa-solid fa-pencil'></i></button></a>

                            <a href='./products?product_delete=" . $row['id'] . "'><button class='bttnClick' id='bttnW'><i class='fa-solid fa-trash-can'></i></button></a>

                            </td>";

                            echo "</tr>";

                        }

                        echo "</tbody>";

                        echo "</table>";

                    } else {

                        echo  "<h4 class='noProduct' style='color:white !important;'>

                     <i class='fa-solid fa-ban'></i>

                     Ürün Bulunamadı

                  </h4>";

                    }

                }

                ?>

            </div>

        </div>

    </div>

</div>



<?php include_once "footer.php";?>