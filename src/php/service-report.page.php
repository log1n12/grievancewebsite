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
                    <li class="breadcrumb-item active" aria-current="page">Report</li>
                </ol>
            </nav>
            <h1>Report</h1>

            <form method="post">
                <input type="text" class="form-control" name="complainantValidId" placeholder="Valid ID" required>

                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Do you know info about kaaway mo?</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yesOrNo" id="gridRadios3" value="yes"
                                    onchange="displayQuestion(this.value)" checked>
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
                                        value="yes" checked onchange="displayQuestion1(this.value)">
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

                    <div id="yesQuestion1">
                        <input type="text" class="form-control" name="complainantValidId" placeholder="Valid ID">

                        <button type="submit" class="btn btn-primary" name="submitComplaint">Submit</button>
                    </div>
                    <div id="noQuestion1" style="display: none;">
                        You should go to your barangay
                    </div>
                </div>


                <div id="yesQuestion">
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="suspectPosition" id="gridRadios1"
                                        value="resident" checked>
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
                        placeholder="Who who you complaint complaint huh?" required>
                    <input type="text" class="form-control" name="complainantComplaint"
                        placeholder="What you complaint complaint about?" required>
                    <input type="text" class="form-control" name="suspectAddress"
                        placeholder="Address of you complaint complaint huh?" required>
                    <button type="submit" class="btn btn-primary" name="submitComplaint1">Submit</button>
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