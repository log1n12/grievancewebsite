<?php
session_start();
require_once 'database/config.php';
$message = "";

if (isset($_POST['loginButton'])) :
    $uname = $_POST["username"];
    $upass = $_POST["password"];
    //CHECK IF THE USERNAME AND PASSWORD IS EXISTING
    $loginquery = "SELECT * FROM account WHERE username = :uname AND user_password= :upass";
    $loginstmt = $con->prepare($loginquery);
    $loginstmt->execute([
        'uname' => $uname,
        'upass' => $upass
    ]);

    $count = $loginstmt->rowCount();
    if ($count > 0) {
        $loginquery1 = "SELECT * FROM account where username = '$uname'";
        $loginstmt1 = $con->query($loginquery1);
        foreach ($loginstmt1 as $row) {
            $admintype = $row["user_type"];
            $id = $row["id"];
        }
        if ($admintype == "barangay_admin") {
            setcookie('id', $id, time() + (60 * 60 * 24 * 365), '/');
            header("location:barangay-dashboard.page.php");
        } elseif ($admintype == "dilg_admin") {
            setcookie('id', $id, time() + (60 * 60 * 24 * 365), '/');
            header("location:dilg-dashboard.page.php");
        }
    } else {
        $message = "Your username and password doesn't match! Please try again.";
    }
endif;

//GETTING INFORMATION BASED ON USERNAME TO ACCOUNTS
if (isset($_COOKIE['id'])) {
    $cookieId = $_COOKIE["id"];
    $getInfoque = "SELECT * FROM account WHERE id = '$cookieId'";
    $data = $con->query($getInfoque);
    foreach ($data as $row) {
        $id = $row['id'];
        $barangayName = $row['barangay'];
        $userName = $row['username'];
        $userPassword = $row['user_password'];
        $userType = $row['user_type'];
        //CHECKING IF THE ACC IS HOSPITAL ADMIN
        if ($userType == "barangay_admin") {
            header("location:barangay-dashboard.page.php");
        } elseif ($userType == "dilg_admin") {
            header("location:dilg-dashboard.page.php");
        }
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

    <link rel="stylesheet" type="text/css" href="../css/login.style.css">

    <title>Document</title>
</head>

<body>
    <nav id="topNav" class="navbar fixed-top navbar-toggleable-sm navbar-inverse bg-inverse transparent">
        <a class="navbar-brand mx-auto" href="home.page.php">Fourth</a>
    </nav>
    <section id="login">
        <div class="container-fluid banner">
            <div class="row">
                <div class="col-md-12 loginform d-flex align-items-center justify-content-center text-center form">
                    <div class="title">
                        <div class="my-5">
                            <h1>FOURTH</h1>
                            <p>FOURTH IS A WEBSITE AFFLIATED WITH HOSPITALS IN 4TH DISTRICT OF LAGUNA</p>
                        </div>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <?php
                                    //SHOW ALERT MESSAGE 
                                    if ($message != "") {
                                        echo '<div class="alert alert-dismissible fade show" role="alert">
										<strong>Oops! </strong>' . $message .
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
										</div>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control transparent input" name="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control transparent input" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="loginButton" class="btn btn-primary form-control submit">Submit <span class="rArrow ml-2"> <i class="fas fa-angle-right"></i> </span></button>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--
    <section>
        <div class="container">
            <h1>Login</h1>
            <h1>Login</h1>
            <h1>Login</h1>
            <h1>Login</h1>
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <input type="submit" name="loginButton" value="Login" />
            </form>
            ?>
        </div>
    </section> -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>