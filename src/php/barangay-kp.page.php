<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/barangay-admin.style.css">

    <title>Document</title>
</head>

<body>
    <?php include './navbar/barangay.navbar.php'; ?>
    <div class="page-content mb-4" id="content">
        <?php include './navbar/barangay.navbar-top.php' ?>
        <div class="transition px-5">
            <section id="list-count" class="mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-clinic-medical fa-1x mr-3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">10</h5>
                                        <small class="card-text">Number of Rooms</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-sign-in-alt fa-1x mr-3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">20</h5>
                                        <small>Number of Acquire Patient</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 align-self-center"><i class="fas fa-comments fa-1x mr-3"></i></div>
                                    <div class="col-sm-8 text-right">
                                        <h5 class="card-text">30</h5>
                                        <small class="card-text">Number of Feedback</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="table-section">
                <div id="tableNavbar">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="mx-4 mt-4">List of Complaints</h1>
                        </div>
                        <div class="col-md-6 text-right align-self-center">
                            <button id="addBtn" class="add btn mx-4 mt-4" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-placement="left" title="Add Hospital"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card card-body transparent">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="container formm">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="First Name" name="ufirstname" id="fnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Last Name" name="ulastname" id="lnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control transparent text-center" placeholder="Email" name="uemail" id="emaillbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Username" name="uname" id="unamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control transparent text-center" placeholder="Password" name="upass" name="upass" id="password" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Name" name="hospname" id="hospnamelbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Address" name="hospaddress" id="hospaddlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Town" name="hosptown" id="hosptownlbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control transparent text-center" placeholder="Hospital Website" name="uwebsite" id="hospweblbl" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" name="profileImage" id="profileImage" class="form-control-file transparent" onChange="displayImage(this)" required><br>
                                                    <img src="" style="max-width: 300px;" class="img-fluid transparent" id="profileDisplay" onclick="triggerClick()">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="addhospbtn btn btn-block ">Add Hospital</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tableContent" class="table-responsive mt-3 px-4">
                    <div class="row">
                        <div class="col-md-12 align-self-center">
                            <form class="d-flex align-items-center sort">
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1 active" name="all" value="all">All</button>
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Confirmation</button>
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Pending</button>
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Ongoing</button>
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Completed</button>
                                <button type="submit" class="btn btn-dark btnSort px-4 mr-1" name="all" value="all">Archive</button>
                            </form>
                            <table class="table text-center mt-4" style="width: 100%">
                                <colgroup>
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 13%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 8%;">
                                    <col span="1" style="width: 7%;">
                                    <col span="1" style="width: 8%;">
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 2%;">
                                    <col span="1" style="width: 2%;">
                                </colgroup>
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Reference Numbers</th>
                                        <th scope="col">Complainant</th>
                                        <th scope="col">Defendant</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Date</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>20123123asdaa</td>
                                        <td>Carl Bermundo</td>
                                        <td>Ivan Perez<br>ASDsaddd<br>asddac zxasd </td>
                                        <td>ASDASDASD asda sdaDas asgagskdkahjs daskjhd ahsdghkas kldahskjhd aslkjd kjasdlj asjdh alskdj jahdk asjdjh askldjh ashjkdh askjdh kahsdkh aksjhdk ashdkh akshd
                                        </td>
                                        <td>Confirmation</td>
                                        <td>View Picture</td>
                                        <td>2012-15-15</td>
                                        <td>X</td>
                                        <td>X</td>
                                        <td>X</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>20123123asdaa</td>
                                        <td>Carl Bermundo</td>
                                        <td>Juvy Novicio<br> </td>
                                        <td>ASDASDASD asda sdaDas asgagskdkahjs daskjhd ahsdghkas kldahskjhd aslkjd kjasdlj asjdh alskdj jahdk asjdjh askldjh ashjkdh askjdh kahsdkh aksjhdk ashdkh akshd
                                        </td>
                                        <td>Completed</td>
                                        <td>View Picture</td>
                                        <td>2012-15-15</td>
                                        <td>X</td>
                                        <td>X</td>
                                        <td>X</td>
                                    </tr>
                                </tbody>


                            </table>
                        </div>
                    </div>

                </div>
            </section>
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
</body>

</html>