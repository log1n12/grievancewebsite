<?php
session_start();
require_once './database/config.php';
require_once './database/dilg-admin.check.php';
$titleHeader = "Frequently Asked Questions";
$message = "";
$confirm = "no";

date_default_timezone_set("Asia/Manila");
if (isset($_POST['toArticle'])) {
    $title = $_POST['artTitle'];
    $dmessage = $_POST['artMessage'];
    $dateToday = date("F j, Y, g:i a");

    $addToNotif = "INSERT INTO faq (quest, answer, is_existing, date_created) VALUES ('$title','$dmessage','yes','$dateToday')";
    if ($con->exec($addToNotif)) {
        $confirm = "yes";
        $message = "FAQ is added.";
    } else {
        $message = "Not added";
    }
}

if (isset($_POST['removeArt'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE faq SET is_existing = :img_s WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':img_s' => "no",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You remove an article";
    }
}

if (isset($_POST['retrieveArt'])) {
    $id = $_POST['id'];
    $unreadsql = "UPDATE faq SET is_existing = :img_s WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        ':img_s' => "yes",
        ':id' => $id

    ])) {
        $confirm = "yes";
        $message = "You retrieve an article";
    }
}

if (isset($_POST['updateFaq'])) {
    $id = $_POST['resInfo'];
    $title  = $_POST['resInfo1'];
    $message = $_POST['resInfo2'];

    $unreadsql = "UPDATE faq SET quest = :dt, answer = :dm WHERE id = :id";
    $unreadstmt = $con->prepare($unreadsql);
    if ($unreadstmt->execute([
        'dt' => $title,
        'dm' => $message,
        'id' => $id

    ])) {
        $confirm = "yes";
        $message = "You Successfully Updated a Question.";
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
                            <h1 class="mx-4 mt-3">List of FAQ</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button type="button" class="add1 btn text-capitalize mx-4 mt-3 hvr-icon-spin" data-toggle="modal" data-target="#announcementModal"><i class="fas fa-plus hvr-icon mr-2"></i>Add FAQ</button>
                        </div>
                    </div>
                    <div class="row mt-3 ml-4">
                        <div class="com-md-12">
                            <nav id="navSort">
                                <div class="nav sort" id="nav-tab" role="tablist">
                                    <a class="nav-item btnSort nav-link active px-4 mr-1" id="nav-comp-tab" data-toggle="tab" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="true"><span class="sortTitle">FAQ</span></a>
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
                                    <h4 class="modal-title" id="myModalLabel">Add FAQ</h4>
                                    <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                                </div>


                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                <div class="modal-body mx-5">
                                    <div class="form-group">
                                        <label for="artTitle">Question</label>
                                        <input type="text" class="form-control" id="artTitle" name="artTitle" placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="artMessage">Answer</label>
                                        <textarea class="form-control" id="artMessage" placeholder="Title" name="artMessage" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer flex-center">
                                    <button type="submit" class="btn btnAccept text-capitalize" name="toArticle">Add</button>

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
                                    <table class="table table1 table-hover table-striped text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Question</th>
                                                <th scope="col">Answer</th>
                                                <th scope="col">Date Created</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAnnouncementSql = "SELECT * FROM faq WHERE is_existing = 'yes'";
                                            $showAnnouncementquery = $con->query($showAnnouncementSql);
                                            foreach ($showAnnouncementquery as $row) {
                                                $aId = $row['id'];
                                                $aQue = $row['quest'];
                                                $aAns = $row['answer'];
                                                $aDate = $row['date_created'];


                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $aId ?><input type="hidden" name="id" value="<?php echo $aId ?>" /></td>
                                                        <td><?php echo $aQue ?></td>
                                                        <td><?php echo $aAns ?></td>
                                                        <td><?php echo $aDate ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="add btn editBtn hvr-pulse-grow" type="button"><i class="fas fa-pen"></i></button>
                                                                <button class="add btn btn-danger hvr-pulse-grow" type="submit" name="removeArt"><i class="fas fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </form>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>

                                <!-- TABLE REPORT -->
                                <div class="tab-pane fade" id="nav-repo" role="tabpanel" aria-labelledby="nav-repo-tab">

                                    <table class="table table1 table-hover table-striped text-center" id="table3" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Question</th>
                                                <th scope="col">Answer</th>
                                                <th scope="col">Date Created</th>
                                                <th scope="col">Retrieve</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $showAnnouncementSql = "SELECT * FROM faq WHERE is_existing = 'no'";
                                            $showAnnouncementquery = $con->query($showAnnouncementSql);
                                            foreach ($showAnnouncementquery as $row) {
                                                $aId = $row['id'];
                                                $aQue = $row['quest'];
                                                $aAns = $row['answer'];
                                                $aDate = $row['date_created'];


                                            ?>
                                                <tr>
                                                    <form method="post">
                                                        <td><?php echo $aId ?><input type="hidden" name="id" value="<?php echo $aId ?>" /></td>
                                                        <td><?php echo $aQue ?></td>
                                                        <td><?php echo $aAns ?></td>
                                                        <td><?php echo $aDate ?></td>
                                                        <td><button class="add btn hvr-pulse-grow" type="submit" name="retrieveArt"><i class="fas fa-check"></i></button></td>
                                                    </form>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- MODAL FOR EDITING RBI INFORMATION -->
            <div class="modal fixed-left fade" id="editRBIModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-aside" role="document">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title" id="myModalLabel">Edit Article</h4>
                                <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                            </div>


                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <form method="post">
                                    <input type="hidden" class="form-control transparent text-muted" name="resInfo" id="resInfo" readonly>
                                    <div class="form-group">
                                        <label for="resInfo1">Question</label>
                                        <input type="text" class="form-control transparent editable" name="resInfo1" id="resInfo1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo2">Answer</label>
                                        <textarea class="form-control transparent editable" name="resInfo2" id="resInfo2" rows="6" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="resInfo3">Date Created</label>
                                        <input type="text" class="form-control transparent" name="resInfo3" id="resInfo3" readonly>
                                    </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btnsave" name="updateFaq">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End of modal -->
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

    <script type="text/javascript">
        $(document).ready(function() {

            $('.editBtn').on('click', function() {
                $('#editRBIModal').modal('show');

                $tr = $(this).closest('tr');

                var tddata = $tr.children("td").map(function() {
                    return $(this).text();

                }).get();

                $('#resInfo').val(tddata[0]);
                $('#resInfo1').val(tddata[1]);
                $('#resInfo2').val(tddata[2]);
                $('#resInfo3').val(tddata[3]);




            });
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