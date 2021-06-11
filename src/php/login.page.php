<?php
session_start();
require_once 'database/config.php';
$message = "";

if (isset($_POST['loginButton'])) {
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
        }
    } else {
        $message = "Your username and password doesn't match! Please try again.";
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

    <link rel="stylesheet" type="text/css" href="../css/main.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/main.navbar.php'; ?>
    <section>
        <div class="container">
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <input type="submit" name="loginButton" value="Login" />
            </form>
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
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>