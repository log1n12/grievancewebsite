<?php
session_start();
require_once 'database/config.php';
$confirm = "";
$message = "";

if (isset($_POST['addRBI'])) {
    $compFname = strtoupper($_POST["compFname"]);
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
    $compNumber = $_POST["compNumber"];
    $validImageName = time() . "_" . $_FILES['validImage']['name'];
    $target1 = '../assets/' . $validImageName;

    //CHECK IF USER IS EXISTING
    $checkCompQuery = "SELECT * FROM rbi WHERE full_name = :fname AND house_no = :houseno AND brgy = :brgy AND purok = :purok AND birth_date = :bday";
    $checkCompStmt = $con->prepare($checkCompQuery);
    $checkCompStmt->execute([
        'fname' => $compFname,
        'houseno' => $compHouseNo,
        'brgy' => $compBrgy,
        'purok' => $compPurok,
        'bday' => $compBday
    ]);
    $countComp = $checkCompStmt->rowCount();
    if ($countComp == 0) {
        if (move_uploaded_file($_FILES['validImage']['tmp_name'], $target1)) {
            $addToRBI = "INSERT INTO rbi (full_name,  brgy, purok, house_no, comp_address, birth_date, birth_place, gender, civil_status, citizenship, occupation, relationship, contact_no, valid_id, is_existing) VALUES ('$compFname','$compBrgy','$compPurok','$compHouseNo','$compAddress','$compBday','$compBplace','$compGender','$compCivStatus','$compCitizenship','$compOccup','$compRelToHead','$compNumber','$validImageName','pending')";
            $con->exec($addToRBI);
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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/main-services.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="topBanner">
        <div class="container banner">
            <div class="row main-content">
                <div class="col-md-12 align-self-center text-center">
                    <h2 class="st section-title-heading text-uppercase">Services</h2>
                    <h1 class="text-uppercase">Get to <span class="accent">know</span> us </h1>
                    <p class="text-uppercase">Don't waste your time. Be sure where you will go.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="servContent">
        <div class="container">
            <div class="sec-title text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">RBI</li>
                    </ol>
                </nav>
                <h1 class="text-uppercase mt-3">barangay Inhabitants form</h1>

                <p class="mt-3"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cumque id quod harum dicta laboriosam illum quo odit veniam dolorum fugit temporibus at earum nostrum, assumenda quia reiciendis corrupti libero! </p>
            </div>
            <div class="form-section mt-5">
                <form method="post" enctype="multipart/form-data">
                    <div class="personalInfo cC">
                        <h4 class="titleComplaint">Personal Information</h4>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="fnameId">Full Name</label>
                                <input type="text" class="form-control" id="fnameId" name="compFname" placeholder="Full Name" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="houseNumId">House Number</label>
                                <input type="text" class="form-control" id="houseNumId" name="compHouseNo" placeholder="House Number" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="barangaySelect">Barangay</label>
                                <select name="compBrgy" class="form-control" id="barangaySelect">
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
                                <select name="compPurok" class="form-control" id="compPurokSelect">
                                    <?php
                                    $barangayQuery = "SELECT name FROM purok WHERE alipit = '1'";
                                    $barangayStmt = $con->query($barangayQuery);
                                    foreach ($barangayStmt as $row) {
                                        $barangayRow = $row['name'];

                                    ?>


                            </div>
                            <option value="<?php echo $barangayRow ?>"><?php echo $barangayRow ?></option>
                        <?php
                                    }
                        ?>
                        </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="relToId">Relationship to the Head</label>
                            <input type="text" class="form-control" id="relToId" name="compRelToHead" placeholder="e.g Brother, Husband ..." required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="compAddress" placeholder="Address" required />
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <legend class="col-form-label pt-0">Radios</legend>
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
                            <input class="form-control" id="civId" type="text" name="compCivStatus" placeholder="Civil Status" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="citId">Citizenship</label>
                            <input class="form-control" id="citId" type="text" name="compCitizenship" placeholder="Citizenship" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="occupId">Occupation</label>
                            <input class="form-control" id="occupId" type="text" name="compOccup" placeholder="Occupation" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conId">Contact Number</label>
                            <input class="form-control" id="conId" type="text" name="compNumber" placeholder="Contact Number" required />
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

    <footer class="page-footer font-small blue footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <h6 class="text-uppercase"><span id="year">
                            <script>
                                document.getElementById('year').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-4 align-self-center">
                    <h1>Fourth</h1>
                </div>
                <div class="col-md-4 align-self-center">
                    <i class="fab fa-facebook fa-2x"></i>
                    <i class="fab fa-twitter fa-2x"></i>
                    <i class="fab fa-instagram fa-2x"></i>
                </div>
            </div>
        </div>
    </footer>
    <footer class="page-footer font-small text-center footer1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase"><span id="year1">
                            Copyrights
                            <script>
                                document.getElementById('year1').appendChild(document.createTextNode(new Date().getFullYear()))
                            </script>
                        </span>BestGroup</h6>
                </div>
                <div class="col-md-6 align-self-center">
                    <h6 class="text-uppercase">Philippine Time: 16:00:01 am 2021 June 16</h6>
                </div>
            </div>
        </div>

    </footer>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
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
    </script>
    <script type="text/javascript">
        $(window).scroll(function() {
            $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 600);
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
    </script>
</body>

</html>