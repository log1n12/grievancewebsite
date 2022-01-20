<nav class="navbar navbar-expand topnav pr-5 mt-0 pt-3 pb-2 mb-4">
    <!-- Toggle button -->

    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm mr-4" data-toggle="tooltip" data-placement="top" title="Toggle Navbar"><i class="fa fa-bars"></i></button>
    <h1 class="page-title align-self-center p-0 m-0" style="height: 100%;"><?php echo $titleHeader ?></h1>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="ml-auto" id="navbarNav">
        <ul class="nav navbar-nav">
            <li class=" align-self-center removeSm">
                <div style="position: relative;width: 2rem;height: 2rem;overflow: hidden;border-radius: 50%;">
                    <img src="../assets/account_pic/<?php echo $secPicture ?>" style="width: 100%;height: 100%;object-fit: cover;">
                </div>

            </li>
            <li class=" align-self-center removeSm">

                <p class="nav-link name-link mb-0">Welcome Back, <span id="name" class="text-capitalize"><?php echo $fullname ?></span> </p>
            </li>
            <li class="notifff align-self-center">
                <a class="nav-link notifBell" href="dilg-notification.page.php">
                    <span><i class="fas fa-bell" <?php
                                                    if ($titleHeader == "Notification") {
                                                        echo "style='color: #FE882B;'";
                                                    }
                                                    ?>></i></span>
                </a>
            </li>
            <li class=" dropdown notifications-nav  align-self-center" id="dropdown1234">
                <a class="nav-link notifBell" id="navbarDropdownMenuLink151" data-toggle="dropdown" aria-haspopup="true" title="notification" aria-expanded="true">
                    <span><i class="fas fa-bell"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0 overflow-auto" aria-labelledby="navbarDropdownMenuLink151" id="notificationPanel">
                    <h6 class="dropdown-header text-center mt-0 py-4">Notification</h6>
                    <?php
                    $getNotif = "SELECT * FROM notification WHERE d_to = '$barangayName' ORDER BY id DESC";
                    $getNotifQ = $con->query($getNotif);
                    foreach ($getNotifQ as $row) {
                        $nTitle = $row['d_title'];
                        $nMessage = $row['d_message'];
                        $nDate = $row['d_datesubmit'];
                        $nFrom = $row['d_from'];
                        $nCategory = $row['d_category'];

                        if ($nFrom === "0") {
                            $notifSubtitle = "Resident of Magdalena";
                            $notifPicture = "resident.png";
                        } elseif ($nFrom === "00") {
                            $notifSubtitle = "Not Resident of Magdalena";
                            $notifPicture = "outsider.png";
                        } else {
                            $getAccountInfo = "SELECT * FROM account WHERE id = '$nFrom'";
                            $getAccountInfoQ = $con->query($getAccountInfo);
                            foreach ($getAccountInfoQ as $row1) {
                                $notifBarangay = $row1['barangay'];
                                $notifPosition = $row1['user_type'];
                                $notifPosition1 = "";
                                $notifPicture = $row1['sec_picture'];

                                if ($notifPosition == "barangay_captain") {
                                    $notifPosition1 = "Barangay Captain";
                                } elseif ($notifPosition == "barangay_admin") {
                                    $notifPosition1 = "Barangay Secretary";
                                }

                                $notifSubtitle = $notifBarangay . " " . $notifPosition1;
                            }
                        }
                    ?>
                        <a class="dropdown-item py-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3 align-self-center">
                                        <img src="../assets/account_pic/<?php echo $notifPicture ?>" height="75" alt="" loading="lazy" />
                                    </div>
                                    <div class="col-md-9">
                                        <h4 class="mb-0"><?php echo $nTitle ?></h4>
                                        <p class="mt-0 mb-1 text-muted notifAuthor"><?php echo $notifSubtitle ?></p>
                                        <p class="mt-0 notifMesg"><?php echo $nMessage ?></p>
                                        <small><?php echo $nDate ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>


                </div>
            </li>
            <li class="align-self-center">
                <a class="nav-link" href="dilg-profile.page.php"><i class="fas fa-cog" <?php
                                                                                        if ($titleHeader == "Settings") {
                                                                                            echo "style='color: #FE882B;'";
                                                                                        }
                                                                                        ?>></i></a>
            </li>
            <li class="align-self-center">
                <a class="nav-link" href="logout.php" onclick="return confirm('Do you want to logout?')"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>

    </div>
</nav>