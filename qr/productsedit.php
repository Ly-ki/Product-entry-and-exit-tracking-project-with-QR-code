<?php
session_start();

include_once "response.php";
if ($_SESSION["status"] !== "2") {
    header("Location: https://dijitalari.com/qr/login.php");
}
if (isset($_POST['send'])) {

    $editproduct = mysqli_real_escape_string($conn, $_POST["editproduct"]);



    $product_edit = $_GET["product_edit"];

    $ses_id = $_SESSION["u_id"];

    if ($product_edit and $_SESSION["status"] > 1) {

        $u_select = "SELECT * FROM products WHERE id = '$product_edit'";

        $res = mysqli_query($conn, $u_select);

        if (mysqli_num_rows($res) > 0) {

            $sql = "UPDATE products  SET product = '{$editproduct}' WHERE id='$product_edit'";

            if (mysqli_query($conn, $sql)) {

                echo "

         <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

         <script>

                setTimeout(function () {

                 swal('Başarılı', 'Kullanıcı Başarılı Bir Şekilde Güncellendi', 'success');    

          },500);          

          </script>   

         ";

            } else {

                echo "

           <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

           <script>

                  setTimeout(function () {

                   swal('Hata!!!',' Kullanıcı Düzenlerken Bir Hata Meydana Geldi!', 'warning');    

            },500);

          </script>   

           ";

            }

        }

    }

}

include_once "header.php";

?>





<div class="container-fluid">

    <div class="row">

        <div class="col-12 col-md-3 col-lg-4 col-xxl-3 leftSidebar" style="padding: 0 !important;">

            <div class="leftLogo">

                <a href="./"> <img src="./assets/img/logo-atlantic.png" class="img-fluid" alt=""></a>

            </div>

            <div class="leftTopBar mobNon">

                <div class="ikon">

                    <i class="fa fa-cart-shopping"></i>

                </div>

                <div class="leftText">Alınan Ürünler</div>

            </div>

            <div class="leftProducts mobNon">

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
                            echo "<a href='products' title='Alınan Ürünler'> Alınan Ürünler</a>";
                            echo "<a href='products' title='Tum Ürünler'> Tüm Ürünler</a>";
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

                        <form action="" method="post" enctype="multipart/form-data">

                            <?php

                            $product_edit = $_GET["product_edit"];

                            $ses_id = $_SESSION["u_id"];

                            $us_select = "SELECT * FROM products WHERE id = '$product_edit'";

                            $res = mysqli_query($conn, $us_select);

                            if (mysqli_num_rows($res) > 0) {

                                echo '<div class="formS">';

                                while ($row = mysqli_fetch_array($res)) {

                                    echo "<input class='regInput' type='text' name='editproduct' value='" . $row['product'] . "' placeholder=" . $row['product'] . ">";
                                    echo '</div>';
                                }
                            }
                            ?>
                            <button id="bttnW" class="mt-4" type="submit" name="send"><i class="fa-solid fa-rotate" style="padding-right: 10px;"></i>Güncelle</button>
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
<script charset="windows-1254" type="text/javascript" src="./assets/js/app.js">
</script>
</body>
</html>