<?php
session_start();
   if(!isset($_SESSION['login_user'])){
    header("location:login.php");
    die();
 } else {
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Angels Resort - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link href="css/dashboard.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Angels Resort Dashboard</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Logout</span></a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Details</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div>
                                        <label for="indate">From:</label>
                                        <input name="indate" id="fromdate" type="text" onfocus="(this.type='date')">
                                    </div>
                                    <div>
                                    <label for="outdate">To:</label>
                                        <input name="outdate" id="todate" type="text" onfocus="(this.type='date')">
                                    </div>
                                    <input type="button" id="displaydata" value="View Records">
                                    <div>
                                    <label for="BasePrice">Base Price:</label>
                                        <input name="baseprice" id="baseprice" type="text">
                                    </div>
                                    <div>
                                    <label for="extraprice">Extra Pax Price:</label>
                                        <input name="extraprice" id="extraprice"  type="text">
                                    </div>
                                    <div>
                                    <label for="BasePrice">Total Rooms:</label>
                                        <input name="totalrooms" id="totalrooms" type="text">
                                    </div>
                                    <input type="button" value="Update" id="updatedata">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">View Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Total Rooms</th>
                                            <th scope="col">Base Rate</th>
                                            <th scope="col">Extra Pax Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataresponse">
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Card Body -->
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Angels Resort &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#displaydata').click(function(){
                var fromdate = $("#fromdate").val();
                var todate = $("#todate").val();
                if(!fromdate){
                    alert('Select To and From Date');
                } else {
                    $.ajax({
                    url: 'dashdisplay.php',
                    data: { fromdate_val: fromdate, todate_val: todate },
                    type: 'post',
                    success: function (responsedata) {
                        $('#dataresponse').html(responsedata);
                    }
                });
                }
            });
            $('#updatedata').click(function(){
                var baseprice = $("#baseprice").val();
                var extraprice = $("#extraprice").val();
                var totalrooms = $("#totalrooms").val();
                var fromdate = $("#fromdate").val();
                var todate = $("#todate").val();
                if(!fromdate){
                    alert('Select To and From Date');
                }
                else{
                    console.log(baseprice);
                    if (!baseprice && !extraprice && !totalrooms) {
                        alert('Enter all the fields to update');
                    } else {
                        $.ajax({
                            url: 'dashdisplay.php',
                            data: { fromdate_val: fromdate, todate_val: todate, baseprice_val: baseprice, extraprice_val: extraprice, totalrooms_val: totalrooms  },
                            type: 'post',
                            success: function (responsedata) {
                                $('#dataresponse').html(responsedata);
                            }
                        });
                    }
                }
            });
        })
    </script>
</body>

</html>
<?php
}
?>