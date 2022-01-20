<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Gallery";
$message = "";
$confirm = "no";

date_default_timezone_set("Asia/Manila");

if (isset($_POST['toGallery'])) {
    $title = $_POST['imgTitle'];
    $dmessage = $_POST['imgMessage'];
    $validImageName = time() . "_" . $_FILES['imgPic']['name'];
    $target1 = '../assets/gallery/' . $validImageName;
    $dateToday = date("F j, Y, g:i a");

    if (move_uploaded_file($_FILES['imgPic']['tmp_name'], $target1)) {
        $addToGallery = "INSERT INTO gallery (img_file, img_title, img_descri, img_status, img_date) VALUES ('$validImageName','$title','$dmessage','yes','$dateToday')";
        if ($con->exec($addToGallery)) {
            $confirm = "yes";
            $message = "Picture is added to the gallery.";
        } else {
            $message = "Not added";
        }
    }
}

if (isset($_POST['removePic'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE gallery SET img_status = :img_s WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':img_s' => "no",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You remove a picture";
    }
}

if (isset($_POST['retrievePic'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE gallery SET img_status = :img_s WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':img_s' => "yes",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You retrieve a picture";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" integrity="sha512-csw0Ma4oXCAgd/d4nTcpoEoz4nYvvnk21a8VA2h2dzhPAvjbUIK6V3si7/g/HehwdunqqW18RwCJKpD7rL67Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/dilg-admin.style.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <title>Document</title>
</head>

<body>
    <?php include './navbar/dilg.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/dilg.navbar-top.php' ?>
        <div class="transition px-4">

            <section id="table-section" class="mt-3">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-3">List of Pictures</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button type="button" class="add1 btn text-capitalize mx-4 mt-3 hvr-icon-spin" data-toggle="modal" data-target="#announcementModal"><i class="fas fa-plus hvr-icon mr-2"></i>Add Pictures</button>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-comp-tab" data-toggle="tab" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="true"><span class="sortTitle">Gallery</span></a>
                                    <a class="nav-item btnSort nav-link px-4 mr-1" id="nav-repo-tab" data-toggle="tab" href="#nav-repo" role="tab" aria-controls="nav-repo" aria-selected="false"><span class="sortTitle">Removed</span></a>

                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Modal for accept (PENDING TABLE) -->
                <div class="modal fade " id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content px-4 py-4">
                            <div class="modal-header">
                                <div>
                                    <h4 class="modal-title" id="myModalLabel">Add Picture</h4>
                                    <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                                </div>


                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                <div class="modal-body mx-5">
                                    <div class="form-group">
                                        <label for="imgTitle">Title</label>
                                        <input type="text" class="form-control" id="imgTitle" name="imgTitle" placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="imgMessage">Message</label>
                                        <textarea class="form-control" id="imgMessage" placeholder="Title" name="imgMessage" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="imgPic">Include Picture</label>
                                        <input type="file" class="form-control-file" id="imgPic" name="imgPic" required>
                                    </div>
                                </div>
                                <div class="modal-footer flex-center">
                                    <button type="submit" class="btn btnAccept text-capitalize" name="toGallery">Add</button>

                                    <button type="button" class="btn btn-danger text-capitalize" data-dismiss="modal">Close</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END OF MODAL -->

                <div id="tableContent" class="px-4 mb-4 py-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <div class="tab-content" id="nav-tabContent">

                                <!-- TABLE ALL -->
                                <div class="tab-pane fade show active" id="nav-comp" role="tabpanel" aria-labelledby="nav-comp-tab">

                                    <div class="row">
                                        <div class="col-md-12 startContent mt-3 gallery-block cards-gallery">
                                            <div class="card-columns">
                                                <?php
                                                $getPic = "SELECT * FROM gallery where img_status = 'yes' ORDER BY id DESC";
                                                $getPicQue = $con->query($getPic);
                                                foreach ($getPicQue as $row) {
                                                    $aId = $row['id'];
                                                    $imgFile = $row['img_file'];
                                                    $imgTitle = $row['img_title'];
                                                    $imgDescrip = $row['img_descri'];
                                                    $imgDate = $row['img_date'];
                                                ?>
                                                    <div class="card border-0 transform-on-hover mt-2">
                                                        <a class="lightbox" href="../assets/gallery/<?php echo $imgFile ?>">
                                                            <img src="../assets/gallery/<?php echo $imgFile ?>" alt="Card Image" class="card-img-top">
                                                        </a>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-9 col-sm-12 align-self-center">
                                                                    <h6 class="mb-0 text-capitalize"><a href="#"><?php echo strtolower($imgTitle); ?></a></h6>
                                                                    <small class="text-muted mt-0"><?php echo $imgDate ?></small>
                                                                    <p class="text-muted card-text text-capitalize"><?php echo strtolower($imgDescrip); ?></p>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12 align-self-center text-center">
                                                                    <form method="post">
                                                                        <div class="d-flex justify-content-center">

                                                                            <input type="hidden" name="id" value="<?php echo $aId ?>" />
                                                                            <button class="add btn hvr-pulse-grow btn-danger" type="submit" name="removePic"><i class="fas fa-trash"></i></button>

                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TABLE REPORT -->
                                <div class="tab-pane fade" id="nav-repo" role="tabpanel" aria-labelledby="nav-repo-tab">
                                    <div class="row">
                                        <div class="col-md-12 startContent mt-3 gallery-block cards-gallery">
                                            <div class="card-columns">
                                                <?php
                                                $getPic = "SELECT * FROM gallery where img_status = 'no' ORDER BY id DESC";
                                                $getPicQue = $con->query($getPic);
                                                foreach ($getPicQue as $row) {
                                                    $aId = $row['id'];
                                                    $imgFile = $row['img_file'];
                                                    $imgTitle = $row['img_title'];
                                                    $imgDescrip = $row['img_descri'];
                                                    $imgDate = $row['img_date'];
                                                ?>
                                                    <div class="card border-0 transform-on-hover mt-2">
                                                        <a class="lightbox" href="../assets/gallery/<?php echo $imgFile ?>">
                                                            <img src="../assets/gallery/<?php echo $imgFile ?>" alt="Card Image" class="card-img-top">
                                                        </a>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-9 col-sm-12 align-self-center">
                                                                    <h6 class="mb-0 text-capitalize"><a href="#"><?php echo strtolower($imgTitle); ?></a></h6>
                                                                    <small class="text-muted mt-0"><?php echo $imgDate ?></small>
                                                                    <p class="text-muted card-text text-capitalize"><?php echo strtolower($imgDescrip); ?></p>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12 align-self-center text-center">
                                                                    <form method="post">
                                                                        <div class="d-flex justify-content-center">

                                                                            <input type="hidden" name="id" value="<?php echo $aId ?>" />
                                                                            <button class="add btn hvr-pulse-grow" type="submit" name="retrievePic"><i class="fas fa-check"></i></button>

                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.cards-gallery', {
            animation: 'slideIn'
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
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


            $('table.table1').DataTable({
                "scrollX": true,
                "order": [
                    [0, "desc"]
                ]
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });


        });
        $(function() {
            // Sidebar toggle behavior
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });

        $(function() {
            // Enables popover
            $("[data-toggle=popover]").popover();
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