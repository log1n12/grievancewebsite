<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Settings";
$message = "";

if (isset($_GET['message'])) {
    $message = $_GET['message'];
} else {
    $message = "";
}
function updateAccount($password, $oldInfo, $info, $whatUpdate, $isPass)
{
    global $message;
    global $con;
    global $userPassword;
    global $id;
    if ($isPass == "yes") {
        if ($password == $userPassword) {
            if ($info != $oldInfo) {
                $unreadsql = "UPDATE account SET $whatUpdate = :info WHERE id = :id";
                $unreadstmt = $con->prepare($unreadsql);
                if ($unreadstmt->execute([
                    ':info' => $info,
                    ':id' => $id

                ])) {
                    header("location:dilg-profile.page.php?message=password successfully updated");
                } else {
                    $message = "Not updated";
                }
            } else {
                $message = "Same Information";
            }
        } else {
            $message = "Enter wrong old password";
        }
    } else {
        if ($password == $userPassword) {
            if ($info != $oldInfo) {
                $unreadsql = "UPDATE account SET $whatUpdate = :info WHERE id = :id";
                $unreadstmt = $con->prepare($unreadsql);
                if ($unreadstmt->execute([
                    ':info' => $info,
                    ':id' => $id

                ])) {
                    header("location:dilg-profile.page.php?message=$oldInfo successfully update to $info");
                } else {
                    $message = "Not updated";
                }
            } else {
                $message = "Same Information";
            }
        } else {
            $message = "Password doesn't match";
        }
    }


    return $message;
}
//update address
if (isset($_POST['updateBrgyBtn'])) {
    $password = $_POST['user_pass'];
    $oldInfo = $brgyAddress;
    $info = $_POST['brgy_info'];
    $whatUpdate = "brgy_address";
    updateAccount($password, $oldInfo, $info, $whatUpdate, "no");
}

//update barangay captain
elseif (isset($_POST['updateBrgyBtn1'])) {
    $password = $_POST['user_pass1'];
    $oldInfo = $brgyCaptain;
    $info = $_POST['brgy_info1'];
    $whatUpdate = "brgy_captain";
    updateAccount($password, $oldInfo, $info, $whatUpdate, "no");
}

//update barangay secretary
elseif (isset($_POST['updateBrgyBtn2'])) {
    $password = $_POST['user_pass2'];
    $info1 = $_POST['brgy_info2'];
    $info2 = $_POST['brgy_info22'];
    $info3 = $_POST['brgy_info222'];
    $whatUpdate = "sec_name";


    if ($password == $userPassword) {
        $unreadsql = "UPDATE account SET sec_fname = :info1, sec_mname = :info2, sec_lname = :info3 WHERE id = :id";
        $unreadstmt = $con->prepare($unreadsql);
        if ($unreadstmt->execute([
            ':info1' => $info1,
            ':info2' => $info2,
            ':info3' => $info3,
            ':id' => $id

        ])) {
            header("location:dilg-profile.page.php?message=name successfully updated");
        } else {
            $message = "Not updated";
        }
    } else {
        $message = "Password doesn't match";
    }
}

//update barangay username
elseif (isset($_POST['updateBrgyBtn3'])) {
    $password = $_POST['user_pass3'];
    $oldInfo = $userName;
    $info = $_POST['brgy_info3'];
    $whatUpdate = "username";
    updateAccount($password, $oldInfo, $info, $whatUpdate, "no");
}

//update barangay password
elseif (isset($_POST['updateBrgyBtn4'])) {
    $password = $_POST['user_pass4'];
    $oldInfo = $userPassword;
    $info = $_POST['brgy_info4'];
    $info2 = $_POST['brgy_info44'];
    $whatUpdate = "user_password";

    if ($info == $info2) {
        updateAccount($password, $oldInfo, $info2, $whatUpdate, "yes");
    } else {
        $message = "Your new password and confirm password doesn't match";
    }
}
//update barangay email
elseif (isset($_POST['updateBrgyBtn5'])) {
    $password = $_POST['user_pass5'];
    $oldInfo = $secEmail;
    $info = $_POST['brgy_info5'];
    $whatUpdate = "sec_email";
    updateAccount($password, $oldInfo, $info, $whatUpdate, "no");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/dilg.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/dilg.navbar-top.php' ?>
        <div class="transition px-5">
            <?php
            //SHOW ALERT MESSAGE 
            if ($message != "") {
                echo '<div class="alert alert-dismissible fade show" role="alert">
				<strong>Hey! </strong>' . $message .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';
            }
            ?>

            <section id="table-section" class="pb-3">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-4">Account Information</h1>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <table class="table mt-4 table-striped" id="myTable" style="width: 100%">

                                <tbody>
                                    <tr>
                                        <th>Barangay</th>
                                        <td><?php echo $barangayName ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Barangay Address</th>
                                        <td>Magdalena, Laguna</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>DILG name</th>
                                        <td><?php echo $fullname ?></td>
                                        <td><a href="#" type="button" data-toggle="modal" data-target="#brgySec">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td><?php echo $userName ?></td>
                                        <td><a href="#" type="button" data-toggle="modal" data-target="#accountUsername">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>••••••••••••••</td>
                                        <td><a href="#" type="button" data-toggle="modal" data-target="#accountPassword">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td><?php echo $secEmail ?></td>
                                        <td><a href="#" type="button" data-toggle="modal" data-target="#accountEmail">Edit</a></td>
                                    </tr>

                                </tbody>


                            </table>
                        </div>
                    </div>

                </div>
            </section>



            <!-- MODAL FOR BARANGAY SECRETARY -->
            <div class="modal fixed-left fade" id="brgySec" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Change Barangay Secretary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="dilg-profile.page.php">
                                <div class="container">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control transparent text-muted" name="account_id2" value="<?php echo $id ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="br2">First Name</label>
                                        <input type="text" class="form-control transparent editable" name="brgy_info2" id="br2" value="<?php echo $fname ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="br22">Middle Name</label>
                                        <input type="text" class="form-control transparent editable" name="brgy_info22" id="br22" value="<?php echo $mname ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="br222">Last Name</label>
                                        <input type="text" class="form-control transparent editable" name="brgy_info222" id="br222" value="<?php echo $lname ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brr2">Enter Your Password</label>
                                        <input type="password" class="form-control transparent editable" name="user_pass2" id="brr2" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark btnsave" name="updateBrgyBtn2">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF MODAL  -->

            <!-- MODAL FOR ACCOUNT USERNAME -->
            <div class="modal fixed-left fade" id="accountUsername" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Change Username</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="dilg-profile.page.php">
                                <div class="container">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control transparent text-muted" name="account_id3" value="<?php echo $id ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="br3">Secretary Username</label>
                                        <input type="text" class="form-control transparent editable" name="brgy_info3" id="br3" value="<?php echo $userName ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brr3">Enter Your Password</label>
                                        <input type="password" class="form-control transparent editable" name="user_pass3" id="brr3" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark btnsave" name="updateBrgyBtn3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF MODAL  -->

            <!-- MODAL FOR ACCOUNT PASSWORD -->
            <div class="modal fixed-left fade" id="accountPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="dilg-profile.page.php">
                                <div class="container">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control transparent text-muted" name="account_id4" value="<?php echo $id ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="br4">Password</label>
                                        <input type="password" class="form-control transparent editable" name="brgy_info4" id="br4" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brr4">Confirm Password</label>
                                        <input type="password" class="form-control transparent editable" name="brgy_info44" id="brr4" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brrr4">Enter Your Old Password</label>
                                        <input type="password" class="form-control transparent editable" name="user_pass4" id="brrr4" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark btnsave" name="updateBrgyBtn4">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF MODAL  -->

            <!-- MODAL FOR ACCOUNT EMAIL -->
            <div class="modal fixed-left fade" id="accountEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Change E-Mail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="dilg-profile.page.php">
                                <div class="container">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control transparent text-muted" name="account_id5" value="<?php echo $id ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="br5">Secretary Email</label>
                                        <input type="text" class="form-control transparent editable" name="brgy_info5" id="br5" value="<?php echo $secEmail ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brr5">Enter Your Password</label>
                                        <input type="password" class="form-control transparent editable" name="user_pass5" id="brr5" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark btnsave" name="updateBrgyBtn5">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF MODAL  -->


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>

    <script>
        function myFunction(x) {
            var notifIcon = document.getElementById("navbarDropdownMenuLink151");
            if (x.matches) { // If media query matches
                $("#sidebar").addClass("active");
                $("#content").addClass("active");

                $('#sidebarCollapse').on('click', function() {
                    if (x.matches) {
                        $('#sidebar, #content').addClass('activity');
                    }

                });

                $('#sidebarClose').on('click', function() {
                    $("#sidebar").addClass("active");
                    $("#content").addClass("active");
                    $("#content").removeClass("activity");
                });



            } else {
                $("#sidebar").removeClass("active");
                $("#content").removeClass("active");
                $("#content").removeClass("activity");
            }
        }

        var x = window.matchMedia("(max-width: 500px)")

        x.addListener(myFunction) // Attach listener function on state changes
        myFunction(x) // Call listener function at run time
    </script>
</body>

</html>