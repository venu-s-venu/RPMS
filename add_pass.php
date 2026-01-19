<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(strlen($_SESSION['bpmsaid']==0)){
    header('location:logout.php');
    } else{
        if(isset($_POST['submit']))
            {
               $fname=$_POST['fullname'];
               $cnum=$_POST['cnumber'];
                $email=$_POST['email'];
                $itype=$_POST['identitytype'];
                $icnum=$_POST['icnum'];
                $cat=$_POST['category'];
                $source=$_POST['source'];
                $des=$_POST['destination'];
                $tc=$_POST['trainclass'];
                $fdate=$_POST['fromdate'];
                $tdate=$_POST['todate'];
                $cost=$_POST['cost'];
                $passnum=mt_rand(100000000, 999999999);
                $propic=$_FILES["propic"]["name"];
                $wtype=$_POST['waytype'];
                $extension = substr($propic,strlen($propic)-4,strlen($propic));
                $allowed_extensions = array(".jpg","jpeg",".png",".gif");
                if(!in_array($extension,$allowed_extensions))
                {
                    echo "<script>alert('Profile Pics has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";    
            }
            else{
                $propic=md5($propic).time().$extension;
                move_uploaded_file($_FILES["propic"]["tmp_name"],"images/".$propic);
                $sql="insert into tblpass(FullName,ContactNumber,Email,IdentityType,IdentityCardNumber,Category,Source,Destination,TrainClass,FromDate,ToDate,Cost,PassNumber,ProfilePic,WayType)values(:fname,:cnum,:email,:itype,:icnum,:cat,:source,:des,:tc,:fdate,:tdate,:cost,:passnum,:propic,:wtype)";
                $query=$dbh->prepare($sql);
                $query->bindParam(':fname',$fname,PDO::PARAM_STR);
                $query->bindParam(':cnum',$cnum,PDO::PARAM_STR);
                $query->bindParam(':email',$email,PDO::PARAM_STR);
                $query->bindParam(':itype',$itype,PDO::PARAM_STR);
                $query->bindParam(':icnum',$icnum,PDO::PARAM_STR);
                $query->bindParam(':cat',$cat,PDO::PARAM_STR);
                $query->bindParam(':source',$source,PDO::PARAM_STR);
                $query->bindParam(':des',$des,PDO::PARAM_STR);
                $query->bindParam(':tc',$tc,PDO::PARAM_STR);
                $query->bindParam(':fdate',$fdate,PDO::PARAM_STR);
                $query->bindParam(':tdate',$tdate,PDO::PARAM_STR);
                $query->bindParam(':cost',$cost,PDO::PARAM_STR);
                $query->bindParam(':passnum',$passnum,PDO::PARAM_STR);
                $query->bindParam(':propic',$propic,PDO::PARAM_STR);
                $query->bindParam(':wtype',$wtype,PDO::PARAM_STR);
                $query->execute();
                $LastInsertId=$dbh->lastInsertId();
                if ($LastInsertId>0) {
               echo '<script>alert("Pass has been added.")</script>';
               echo '<script>window.location.href="add_pass.php"</script>';
                }
            else
            {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Railway Pass Management System | Add Pass</title>
        <!-- Core CSS - Include with every page -->
        <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" />
    </head>
    <body>
        <!--  wrapper -->
        <div id="wrapper">
            <!-- navbar top -->
            <?php include_once('includes/header.php');?>
            <!-- end navbar top -->

            <!-- navbar side -->
            <?php include_once('includes/sidebar.php');?>
            <!-- end navbar side -->

            <!--  page-wrapper -->
            <div id="page-wrapper">
                <div class="row">
                    <!-- Page Header -->
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Pass</h1>
                    </div>
                    <!--End Page Header -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Profile Image</label>
                                                <input type="file" class="form-control" id="propic" name="propic" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Contact Number</label>
                                                <input type="text" class="form-control" id="cnumber" name="cnumber" value="" required='true' maxlength='10' pattern="[09]+">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Identity type</label>
                                                <select type="text" class="form-control" id="identitytype" name="identitytype" value="" required='true'>
                                                    <option value="">Select Identity Type</option>
                                                    <option value="Voter ID">Voter ID</option>
                                                    <option value="PAN card">PAN card</option>
                                                    <option value="Aadhar Card">Aadhar Card</option>
                                                    <option value="Student ID">Student ID</option>
                                                    <option value="Driving License">Driving License</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="Any Official Card">Any Official Card</option>
                                                    <option value="Any Other Govt Issued Doc">Any Other Govt Issued Doc</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Identity Card Number</label>
                                                <input type="text" class="form-control" id="icnum" name="icnum" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Category</label>
                                                <select name="text" name="Category" value="" class="Form-group" required='true'>
                                                    <?php
                                                    $sql2="SELECT * from tblcategory";
                                                    $query2=$dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2=$query2->fetchAll(PDO::FETCH_OBJ);
                                                    foreach($result2 as $row)
                                                        {
                                                            ?>  
                                                            <option value="<?php echo htmlentities($row->CategoryName);?>"><?php echo htmlentities($row->CategoryName);?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Source</label>
                                                <input type="text" class="form-control" id="source" name="source" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Destination</label>
                                                <input type="text" class="form-control" id="destination" name="destination" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Class of Pass Eligible</label>
                                                <select type="text" class="form-control" id="trainclass" name="trainclass" value="" required='true'>
                                                <option value="">Choose Class</option>
                                                <option value="IA">IA</option>
                                                <option value="I">I</option>
                                                <option value="IIA">IIA</option>
                                                <option value="II Class">II Class</option>
                                                <option value="Slepper">Slepper</option>
                                                <option value="General">General</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">From Date</label>
                                                <input type="date" class="form-control" id="fromdate" name="fromdate" value="" required='true'>                                            
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">To Date</label>
                                                <input type="date" class="form-control" id="todate" name="todate" value="" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Way Type</label>
                                                <select type="text" name="waytype" id="waytype" class="form-control" required='true'>
                                                    <option value="">Select Way Type</option>
                                                    <option value="Single Way">One Way</option>
                                                    <option value="Two Way">Round Way</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Cost</label>
                                                <input type="text" class="form-control" id="cost" name="cost" value="" required='true'>
                                                </div>
                                                <p style="padding-left:450px">
                                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Add</button>
                                                </p>
                                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>
            </div>
            <!-- end page-wrapper -->
        </div>
        <!-- end wrapper -->
        <!-- Core Scripts - Include with every page -->
        <script src="assets/plugins/jquery-1.10.2.js"></script>
        <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="assets/plugins/pace/pace.js"></script>
        <script src="assets/scripts/siminta.js"></script>
    </body>
    </html>
    <?php }  ?>
<?php }  ?>
