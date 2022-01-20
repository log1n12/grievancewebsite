<?php
session_start();
require_once 'database/config.php';
$confirm = "no";
$message = "";

if (isset($_POST['addRBI'])) {
    $compFname = strtoupper($_POST["compFname"]);
    $compLname = strtoupper($_POST["compLname"]);
    $compMname = strtoupper($_POST["compMname"]);
    $compBrgy = $_POST['compBrgy'];
    $compPurok = $_POST["compPurok"];
    $compHouseNo = $_POST["compHouseNo"];
    $compAddress = $_POST["compAddress"];
    $compBday = $_POST["compBday"];
    $compBplace = $_POST["compBplace"];
    $compGender = $_POST["compGender"];
    $compCivStatus = $_POST["compCivStatus"];
    $compCitizenship = $_POST["compCitizenship"];
    $compOccup = $_POST["compOccup"];
    $compRelToHead = $_POST["compRelToHead"];
    $compNumber = "+639" . $_POST["compNumber"];
    $validImageName = time() . "_" . $_FILES['validImage']['name'];
    $target1 = '../assets/' . $validImageName;

    //CHECK IF USER IS EXISTING
    $checkCompQuery = "SELECT * FROM rbi WHERE first_name = :fname AND last_name = :lname AND middle_name = :mname AND house_no = :houseno AND brgy = :brgy AND birth_date = :bday";
    $checkCompStmt = $con->prepare($checkCompQuery);
    $checkCompStmt->execute([
        'fname' => $compFname,
        'lname' => $compLname,
        'mname' => $compMname,
        'houseno' => $compHouseNo,
        'brgy' => $compBrgy,
        'bday' => $compBday
    ]);
    $countComp = $checkCompStmt->rowCount();
    if ($countComp == 0) {
        if (move_uploaded_file($_FILES['validImage']['tmp_name'], $target1)) {
            $addToRBI = "INSERT INTO rbi (first_name, last_name, middle_name, brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no, valid_id, is_existing) VALUES ('$compFname','$compLname','$compMname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber','$validImageName','pending')";
            $con->exec($addToRBI);

            $notifTitle = "Request for RBI";
            $notifMesg = "Request for RBI was added to the pending table of record of barangay inhabitant. The name is " . "$compFname $compMname $compLname";
            $notifTo = $compBrgy;
            $notifToType = "Barangay Secretary";
            $notifFrom = "00";

            require './get-notif.php';
            $confirm = "yes";
            $message = "Wait for the confirmation of your request.";
        }
    } else {
        $confirm = "no";
        $message = "Inhabitant already exists";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <title>Document</title>
    <style>
        label.error {
            color: red;
            font-size: 1rem;
            display: block;
            margin-top: 5px;
        }

        input.error {
            border: 1px solid red;
            font-weight: 300;
            color: red;
        }


        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="topBanner">
        <div class="container banner" data-aos-offset="400" data-aos="zoom-out" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h3 class="text-uppercase">Are you <span class="accent">living</span> here? </h3>
                    <p class="text-uppercase">Be part of our town. Register now.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center transparent">
                        <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">RBI</li>
                    </ol>
                </nav>
                <h3 class="text-uppercase mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">barangay Inhabitants form</h3>

                <p class="mt-3" data-aos-offset="200" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true"> Ang barangay inhabitants form na ito ay maaaring magamit ng mga residente ng Magdalena na hindi pa nakalista sa Registry of Barangay Inhabitants sa kanilang barangay. Kung ikaw ay nais magrequest na mapalista sa RBI, ibigay lamang mga impormasyon sa ibaba at isang valid ID na gagamitin upang ikompirma ang inyong request.</p>
            </div>
            <div class="form-section mt-5" data-aos-offset="350" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="ease-in-out" data-aos-once="true">
                <form method="post" enctype="multipart/form-data" id="rbiForm">
                    <div class="personalInfo cC p-5">
                        <h4 class="titleComplaint">Personal Information</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="fnameId">First Name</label>
                                <input type="text" class="form-control" id="fnameId" name="compFname" placeholder="First Name" required />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lnameId">Last Name</label>
                                <input type="text" class="form-control" id="lnameId" name="compLname" placeholder="Last Name" required />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mnameId">Middle Name</label>
                                <input type="text" class="form-control" id="mnameId" name="compMname" placeholder="Middle Name" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="houseNumId">House Number</label>
                                <input type="text" class="form-control" id="houseNumId" name="compHouseNo" placeholder="House Number" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="barangaySelect">Barangay</label>
                                <select name="compBrgy" class="form-select" id="barangaySelect">
                                    <?php
                                    $barangayQuery = "SELECT DISTINCT barangay FROM account WHERE barangay != 'DILG' ORDER BY barangay";
                                    $barangayStmt = $con->query($barangayQuery);
                                    foreach ($barangayStmt as $row) {
                                        $barangayRow = $row['barangay'];

                                    ?>
                                        <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="compPurokSelect">Purok</label>
                                <select name="compPurok" class="form-select" id="compPurokSelect">
                                    <?php
                                    $barangayQuery = "SELECT name FROM purok WHERE alipit = '1'";
                                    $barangayStmt = $con->query($barangayQuery);
                                    foreach ($barangayStmt as $row) {
                                        $barangayRow = $row['name'];

                                    ?>


                                        <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="relToId">Relationship to the Head of Family</label>
                                <input type="text" class="form-control" id="relToId" name="compRelToHead" placeholder="e.g Brother, Husband ..." required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" name="compAddress" placeholder="Address" required />
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <legend class="col-form-label pt-0">Gender</legend>
                                <label class="radio-inline">
                                    <input type="radio" name="compGender" value="Male" checked>Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="compGender" value="Female">Female
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bdayId">Birthday</label>
                                <input class="form-control" id="bdayId" type="date" name="compBday" placeholder="Birthdate" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bplaceId">Birthplace</label>
                                <input class="form-control" id="bplaceId" type="text" name="compBplace" placeholder="Place of Birth" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="civId">Civil Status</label>
                                <select name="compCivStatus" class="form-select" id="civId">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="citId">Citizenship</label>
                                <select name="compCitizenship" class="form-select" id="citId">
                                    <option value="Filipino">Filipino</option>
                                    <option value="Foreigner">Foreigner</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="occupId">Occupation</label>
                                <input class="form-control" id="occupId" type="text" name="compOccup" placeholder="Occupation" required />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conId">Contact Number</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+639</span>
                                    <input class="form-control" id="conId" type="number" name="compNumber" placeholder="Contact Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="9" maxlength="9" aria-describedby="basic-addon1" required />
                                </div>
                                <label for="conId" generated="false" class="error"></label>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="validImage">Valid ID</label>
                            <input type="file" name="validImage" id="validImage" class="form-control-file transparent text-center" onChange="displayImage1(this)" style="margin: auto;" required><br>
                            <img src="" style="max-width: 300px;" class="img-fluid transparent" id="validDisplay" onclick="triggerClick1()">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <button type="submit" name="addRBI" class="btn submit1">Request</button>
                                </div>
                            </div>

                        </div>

                    </div>

                </form>
            </div>

        </div>
    </section>

    <?php include './navbar/main.footer.php' ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#rbiForm").validate();

            // ALERT 
            <?php
            if ($message != "") {
                if ($confirm == "yes") {


            ?>
                    Swal.fire({

                            title: 'Success',
                            icon: 'success',
                            html: '<?php echo $message ?>'
                        }

                    )
                <?php
                } else {
                ?>
                    Swal.fire(
                        'Error',
                        '<?php echo $message; ?>',
                        'error'
                    )
            <?php
                }
            }
            ?>

            $("#barangaySelect").change(function() {
                var brgy = $("#barangaySelect").val().toLowerCase();
                $.ajax({
                    url: 'get-option.php',
                    method: 'post',
                    data: 'brgyPost=' + brgy
                }).done(function(purok) {
                    console.log(purok);
                    purok1 = JSON.parse(purok);
                    $('#compPurokSelect').empty();
                    purok1.forEach(function(puroks) {
                        $('#compPurokSelect').append('<option value="' + puroks.name + '">' + puroks.name + ' </option>')
                    })
                })
            })
        })

        function triggerClick1() {
            document.querySelector('#validImage').click();
        }

        //DISPLAYING IMAGE TO THE IMG TAG
        function displayImage1(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#validDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>
    <script type="text/javascript">
        $(window).scroll(function() {
            $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 50);
        });
        var lastScrollTop = 0;
        $(window).scroll(function() {
            var st = $(this).scrollTop();
            var banner = $('.navbar');
            setTimeout(function() {
                if (st > lastScrollTop) {
                    banner.addClass('hide');
                    banner.removeClass('transparent');
                } else {
                    banner.removeClass('hide');
                }
                lastScrollTop = st;
            }, 100);
        });

        //GETTING DATE
        $(window).on('load', function() {

            displayClock();
        });
        var span = document.getElementById('phTime');

        function displayClock() {
            var display = new Date().toLocaleTimeString();
            span.innerHTML = display;
            setTimeout(displayClock, 1000);
        }
    </script>
</body>

</html>