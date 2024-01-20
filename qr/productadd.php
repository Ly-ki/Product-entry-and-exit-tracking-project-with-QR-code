<?php

session_start();

include_once "./response.php";
error_reporting(1);

if ($_SESSION["status"] !== "2") {

    header("Location: https://dijitalari.com/qr/login.php");

}



$msg = "";

if (isset($_POST['send'])) {



    $filename = $_FILES["uploadfile"]["name"];

    $tempname = $_FILES["uploadfile"]["tmp_name"];

    $folder = "./assets/img/uploads/" . $filename;

    $input_text = mysqli_real_escape_string($conn, $_POST['input_text']);

    $stk = mysqli_real_escape_string($conn, $_POST['stk']);

    $poststk = $_POST['stk'];



    $sql = "INSERT INTO product_detail (names,stk,p_path) VALUES ('$input_text','$stk','$filename')";

    $sql2 = "SELECT count(id) AS num FROM product_detail WHERE stk = '$poststk'";

    $res = mysqli_query($conn, $sql2);

    $row = mysqli_fetch_array($res);

    if($row["num"] > 0){
        echo "

                Hata. Ürün eklenemedi.

            ";
    }else {

            if (mysqli_query($conn, $sql) and move_uploaded_file($tempname, $folder)) {

            echo "

                <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                <script>

                        setTimeout(function () {

                        swal('Başarılı', 'Ürün Başarılı Bir Şekilde Eklendi', 'success');    

                },500);                            

                </script>   

                ";

            }else{
                echo "

                <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

                <script>

                    setTimeout(function () {

                        swal('Hata!!!', Ürün Eklerken Hata Meydana Geldi!', 'warning');    

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

                <div class="formProduct">

                    <div class="loginTopBar">

                        <img src="./assets/img/logo-atlantic.png" alt="">

                    </div>

                    <div class="regMid">

                        <form action="" method="post" enctype="multipart/form-data">

                            <section class="user-input">

                                <input required type="text" placeholder="Ürün Adı" name="input_text" id="input_text" autocomplete="off">

                                <input required type="text" placeholder="Stok Kodu" name="stk" id="stk">

                                <button class="button" id="bttnW" type="button">Oluştur<i style="padding-left:7px;" class="fa-solid fa-rotate"></i></button>

                            </section>

                            <div class="qr-code-container">

                                <div class="qr-code" style></div>

                                <input type="file" class="btnFile" style="display:none;" placeholder="Stok Kodu" name="uploadfile" id="uploadfile" accept=".jpg, .jpeg, .png">

                                <button class="btnSubmit" id="bttnW" style="display:none;" name="send" type="submit">Gönder<i class="fa fa-paper-plane"></i></button>

                            </div>

                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    let btn = document.querySelector(".button");

    let qr_code_element = document.querySelector(".qr-code");



    btn.addEventListener("click", () => {

        let user_input = document.querySelector("#input_text");

        let stk = document.querySelector("#stk");

        if (user_input.value != "") {

            if (qr_code_element.childElementCount == 0) {

                generate(user_input);

            } else {

                qr_code_element.innerHTML = "";

                generate(user_input);

            }

        } else {

            console.log("not valid input");

            qr_code_element.style = "display: none";

        }

    });



    function generate(user_input) {

        qr_code_element.style = "";



        var qrcode = new QRCode(qr_code_element, {

            text: `${user_input.value}`,

            width: 180, //128

            height: 180,

            colorDark: "#000000",

            colorLight: "#ffffff",

            correctLevel: QRCode.CorrectLevel.H

        });



        let download = document.createElement("button");

        qr_code_element.appendChild(download);





        let btnFile = document.getElementsByClassName("btnFile");

        let btnSubmit = document.getElementsByClassName("btnSubmit");

        download.addEventListener("click", function() {

            btnFile[0].style.display = "block";

            btnSubmit[0].style.display = "block";

        });





        let download_link = document.createElement("a");

        download_link.setAttribute("download", `${stk.value}.png`);

        download_link.innerHTML = `İndir`;

        download.id = 'bttnW';

        download.classList.add("btnLeft");

        download.appendChild(download_link);



        let qr_code_img = document.querySelector(".qr-code img");

        let qr_code_canvas = document.querySelector("canvas");





        if (qr_code_img.getAttribute("src") == null) {

            setTimeout(() => {

                download_link.setAttribute("href", `${qr_code_canvas.toDataURL()}`);

            }, 300);

        } else {

            setTimeout(() => {



                download_link.setAttribute("href", `${qr_code_img.getAttribute("src")}`);

            }, 300);

        }

    }

</script>

<script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" charset="utf8" src="./assets/js/datatable.js"></script>

<link href="./assets/js/lightbox.js" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script charset="windows-1254" type="text/javascript" src="./assets/js/app.js"></script>

</body>



</html>