<?php
session_start();
require_once 'database/config.php';

if (isset($_POST['submitComplaint'])) {
    $complainantFirstName = $_POST['complainantFirstName'];
    $complainantLastName = $_POST['complainantLastName'];
    $complainantMiddleName = $_POST['complainantMiddleName'];
    $complainantFullName = $complainantFirstName . " " . $complainantMiddleName . " " . $complainantLastName;

    $complainantAge = $_POST['complainantAge'];
    $complainantAddress = $_POST['complainantAddress'];
    $complainantBarangay = $_POST['complainantBarangay'];
    $complainantConNumber = $_POST['complainantConNumber'];
    $complainantValidId = $_POST['complainantValidId'];

    $suspectPosition = $_POST['suspectPosition'];
    $suspectName = $_POST['suspectName'];
    $complainantComplaint = $_POST['complainantComplaint'];
    $suspectAddress = $_POST['suspectAddress'];

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/main.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section id="banner-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./service.page.php">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Complaint</li>
                </ol>
            </nav>
            <h1>Complaint</h1>
        </div>
    </section>

    <section id="form-section">
        <div class="container">
            <form method="post">
                <input type="text" class="form-control" name="complainantFirstName" placeholder="First Name">
                <input type="text" class="form-control" name="complainantLastName" placeholder="Last Name">
                <input type="text" class="form-control" name="complainantMiddleName" placeholder="Middle Name">
                <input type="text" class="form-control" name="complainantAge" placeholder="Age">
                <input type="text" class="form-control" name="complainantAddress" placeholder="Address">
                <select class="form-control" name="complainantBarangay">
                    <option value="wow">Wow</option>
                    <option value="nyaw">Nyaw</option>
                    <option value="meow">Meow</option>
                </select>
                <input type="text" class="form-control" name="complainantConNumber" placeholder="Contact Number">
                <input type="text" class="form-control" name="complainantValidId" placeholder="Valid ID">

                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Do you know info about kaaway mo?</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yesOrNo" id="gridRadios3" value="yes"
                                    onchange="displayQuestion(this.value)">
                                <label class="form-check-label" for="gridRadios3">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yesOrNo" id="gridRadios4" value="no"
                                    onchange="displayQuestion(this.value)">
                                <label class="form-check-label" for="gridRadios4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div id="noQuestion" style="display:none;">
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Do you have picture of your kaaway mo?</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="yesOrNo1" id="gridRadios31"
                                        value="yes" onchange="displayQuestion1(this.value)">
                                    <label class="form-check-label" for="gridRadios31">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="yesOrNo1" id="gridRadios41"
                                        value="no" onchange="displayQuestion1(this.value)">
                                    <label class="form-check-label" for="gridRadios41">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div id="yesQuestion1" style="display: none;">
                        Enter picture
                        <button type="submit" class="btn btn-primary" name="submitComplaint">Submit</button>
                    </div>
                    <div id="noQuestion1" style="display: none;">
                        You should go to your barangay
                    </div>
                </div>


                <div id="yesQuestion" style="display:none;">
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="suspectPosition" id="gridRadios1"
                                        value="resident">
                                    <label class="form-check-label" for="gridRadios1">
                                        Resident
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="suspectPosition" id="gridRadios2"
                                        value="official">
                                    <label class="form-check-label" for="gridRadios2">
                                        Official
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <input type="text" class="form-control" name="suspectName"
                        placeholder="Who who you complaint complaint huh?">
                    <input type="text" class="form-control" name="complainantComplaint"
                        placeholder="What you complaint complaint about?">
                    <input type="text" class="form-control" name="suspectAddress"
                        placeholder="Address of you complaint complaint huh?">
                    <button type="submit" class="btn btn-primary" name="submitComplaint">Submit</button>
                </div>



            </form>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>

    <script>
        function displayQuestion(answer) {

            document.getElementById(answer + 'Question').style.display = "block";

            if (answer == "yes") { // hide the div that is not selected

                document.getElementById('noQuestion').style.display = "none";

            } else if (answer == "no") {

                document.getElementById('yesQuestion').style.display = "none";

            }

        }

        function displayQuestion1(answer) {

            document.getElementById(answer + 'Question1').style.display = "block";

            if (answer == "yes") { // hide the div that is not selected

                document.getElementById('noQuestion1').style.display = "none";

            } else if (answer == "no") {

                document.getElementById('yesQuestion1').style.display = "none";

            }

        }
    </script>
</body>

</html>