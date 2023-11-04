<?php
   include("server.php");

   if (!isset($_SESSION['unameMMS']))
    {
        header("Location: index.php");
        exit();
    }

   $mail = $_SESSION['unameMMS'];
   $sql = "SELECT  * FROM reg WHERE email='$mail'";
   $Result = $db->query($sql);
   $sessHolder =$Result->fetch_assoc()["uname"];
   $cleanedUsername = str_replace(' ', '', $sessHolder);
   $Icon = 'https://cdn4.iconfinder.com/data/icons/Pretty_office_icon_part_2/256/personal-information.png';

   $menteeName = array();
   $menteeEmails = array();
   $menteesub1 = array();
   $menteesub2 = array();
   $menteesub3 = array();
   $menteesub4 = array();
   $menteesub5 = array();
   $menteesub6 = array();
   $menteeavg = array();

for ($i = 1; $i <= 6; $i++)
{
    $query = "SELECT * FROM $cleanedUsername WHERE mno = ?";
    
    // Prepare the statement
    $stmt = $db->prepare($query);

    if (!$stmt)
    {
        die("Error in SQL query: " . mysqli_error($db)); // Add error handling
    }

    // Bind parameter and execute
    $stmt->bind_param("i", $i);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($mnos, $mname, $email, $sub1s, $sub2s, $sub3s, $sub4s, $sub5s, $sub6s, $avgs);
    
    // Fetch and store results
    if ($stmt->fetch())
    {
        $menteeName[$i] = $mname;
        $menteeEmails[$i] = $email;
        $menteesub1[$i] = $sub1s;
        $menteesub2[$i] = $sub2s;
        $menteesub3[$i] = $sub3s;
        $menteesub4[$i] = $sub4s;
        $menteesub5[$i] = $sub5s;
        $menteesub6[$i] = $sub6s;
        $menteeavg[$i] = $avgs;
    }

    // Close the statement
    $stmt->close();
}

$selectQuery = "SELECT * FROM reg WHERE email = ?";
$selectStmt = $db->prepare($selectQuery);

if ($selectStmt)
{
    $selectStmt->bind_param("s", $_SESSION['unameMMS']);
    if ($selectStmt->execute()) {
        $selectResult = $selectStmt->get_result();
        $row = $selectResult->fetch_assoc();
        
        $dobFetched = date('Y-m-d', strtotime($row['dob']));
        $dob = $dobFetched;
        $Age = $row['age'];
        $country = $row['country'];
        $state = $row['stat'];
        $zip = $row['zip'];
    }
    else
    {
        echo "Error fetching data: " . $selectStmt->error;
    }
    $selectStmt->close();
  }
  else
  {
    echo "Error in preparing select statement: " . $db->error;
  }

?>

<html> 
    <head>
      <title>Account</title>
      <link rel="icon" type="image/x-icon" href="https://cdn4.iconfinder.com/data/icons/Pretty_office_icon_part_2/256/personal-information.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="navbar">
    <div class="display">
            <img src="https://img.icons8.com/color/48/teacher.png" height=30px width=30px>
            <p class="">Mentor Dashboard</p>
        </div>
        <h1><?php $_SESSION['unameMMS'] ?></h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="javascript:void(0);" onclick="swal('Courses not Configured!','','error')">Courses</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="javascript:void(0);" onclick="swal('Contact not Configured!','','error')">Contact</a></li>
                <li><a href="javascript:void(0);" onclick="swal('About not Configured!','','error')">About</a></li>
                <li><a href="javascript:void(0);" id="logout-button"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg></a></li>
            </ul>
        </nav>
    </div>
<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="welcome">
        <center><p class="fst-italic">Hello <b><?php echo $sessHolder; ?></b> here you can able to modify some details</p></center>
      </div>
      <div class="errors">
          <center><?php include('errors.php'); ?></center>
      </div>
      <div class="userdetails">
        <form action="#" class="row g-3 needs-validation" id="update" method="post" enctype="multipart/form-data" novalidate>
        <center><i><p class="fst-italic">All the fields are mandatory <sup>*</sup></p></i></center>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name</label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname" value="<?php echo $sessHolder; ?>" disabled readonly>
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email</label>
        <input type="text" class="form-control" id="validationTooltip02" name="email" value="<?php echo $_SESSION['unameMMS']; ?>" disabled readonly>
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-6 position-relative">
        <label for="validationTooltip03" class="form-label">Date of Birth<sup>*</sup></label>
        <input type="date" value="<?php echo $row['dob']; ?>" min="2000-01-01" max="2020-12-31" class="form-control" id="dob" name="dob" onfocusout="ageCalculator()" required>
      </div>
      <div class="col-md-3 position-relative">
        <label for="validationTooltip05" class="form-label">Age</label>
        <input type="number" class="form-control" id="age" name="age" disabled readonly>
      </div>
      <div class="col-md-3 position-relative">
        <label for="validationTooltip05" class="form-label">Pincode<sup>*</sup></label>
        <input type="number" class="form-control" id="zip" name="zip" value="<?php echo $row['zip']; ?>" required>
      </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country<sup>*</sup></label>
            <select id="country" class="form-select" name="country" required>
                <option>Choose..</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="state" class="form-label">State<sup>*</sup></label>
            <select id="state" class="form-select" name="state">
                <option>Choose..</option>
            </select>
        </div>
        
<div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label">SUB-1<sup>*</sup></label>
        <input type="text" class="form-control" id="sub1" name="sub1" value="<?php echo $row['sub1']; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label">SUB-2<sup>*</sup></label>
        <input type="text" class="form-control" id="sub2" name="sub2" value="<?php echo $row['sub2']; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label">SUB-3<sup>*</sup></label>
        <input type="text" class="form-control" id="sub3" name="sub3" value="<?php echo $row['sub3']; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label">SUB-4<sup>*</sup></label>
        <input type="text" class="form-control" id="sub4" name="sub4" value="<?php echo $row['sub4']; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label">SUB-5<sup>*</sup></label>
        <input type="text" class="form-control" id="sub5" name="sub5" value="<?php echo $row['sub5']; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label">SUB-6<sup>*</sup></label>
        <input type="text" class="form-control" id="sub6" name="sub6" value="<?php echo $row['sub6']; ?>">
      </div>
      <div class="mb-3">
            <label for="mentorprofile" class="form-label">Mentor Profile</label>
            <input type="file" class="form-control" id="mentorprofile" name="mentorprofile" accept="image/*">
      </div>
      <small><sup>*</sup> Enter the Subject Names in Abbreviation</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update" name="update">Save changes</button>
          </div>
        <center><u><b><i><p class="fst-italic">Mentee Inputs <small>(%)</small></p></i></b></u></center>
        <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
        <label><b><i>Mentee-1</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname1" value="<?php echo $menteeName[1]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email1" value="<?php echo $menteeEmails[1]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m1" name="sub1m1" value="<?php echo $menteesub1[1]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m1" name="sub2m1" value="<?php echo $menteesub2[1]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m1" name="sub3m1" value="<?php echo $menteesub3[1]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m1" name="sub4m1" value="<?php echo $menteesub4[1]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m1" name="sub5m1" value="<?php echo $menteesub5[1]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m1" name="sub6m1" value="<?php echo $menteesub6[1]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update1" name="update1">Save changes</button>
          </div>
      <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" id="menm1" class="circle-image">
    </div>
        <label><b><i>Mentee-2</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname2" value="<?php echo $menteeName[2]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email2" value="<?php echo $menteeEmails[2]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m2" name="sub1m2" value="<?php echo $menteesub1[2]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m2" name="sub2m2" value="<?php echo $menteesub2[2]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m2" name="sub3m2" value="<?php echo $menteesub3[2]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m2" name="sub4m2" value="<?php echo $menteesub4[2]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m2" name="sub5m2" value="<?php echo $menteesub5[2]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m2" name="sub6m2" value="<?php echo $menteesub6[2]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update2" name="update2">Save changes</button>
          </div>
      <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
        <label><b><i>Mentee-3</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname3" value="<?php echo $menteeName[3]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email3" value="<?php echo $menteeEmails[3]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m3" name="sub1m3" value="<?php echo $menteesub1[3]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m3" name="sub2m3" value="<?php echo $menteesub2[3]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m3" name="sub3m3" value="<?php echo $menteesub3[3]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m3" name="sub4m3" value="<?php echo $menteesub4[3]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m3" name="sub5m3" value="<?php echo $menteesub5[3]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m3" name="sub6m3" value="<?php echo $menteesub6[3]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update3" name="update3">Save changes</button>
          </div>
      <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
        <label><b><i>Mentee-4</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname4" value="<?php echo $menteeName[4]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email4" value="<?php echo $menteeEmails[4]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m4" name="sub1m4" value="<?php echo $menteesub1[4]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m4" name="sub2m4" value="<?php echo $menteesub2[4]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m4" name="sub3m4" value="<?php echo $menteesub3[4]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m4" name="sub4m4" value="<?php echo $menteesub4[4]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m4" name="sub5m4" value="<?php echo $menteesub5[4]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m4" name="sub6m4" value="<?php echo $menteesub6[4]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update4" name="update4">Save changes</button>
          </div>
      <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
        <label><b><i>Mentee-5</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname5" value="<?php echo $menteeName[5]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email5" value="<?php echo $menteeEmails[5]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m5" name="sub1m5" value="<?php echo $menteesub1[5]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m5" name="sub2m5" value="<?php echo $menteesub2[5]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m5" name="sub3m5" value="<?php echo $menteesub3[5]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m5" name="sub4m5" value="<?php echo $menteesub4[5]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m5" name="sub5m5" value="<?php echo $menteesub5[5]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m5" name="sub6m5" value="<?php echo $menteesub6[5]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update5" name="update5">Save changes</button>
          </div>
      <div class="men_prof">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
        <label><b><i>Mentee-6</i></b></label>
</div>
        <div class="col-md-4 position-relative">
        <label for="validationTooltip01" class="form-label">Name<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip01" name="uname6" value="<?php echo $menteeName[6]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltip02" class="form-label">Email<sup>*</sup></label>
        <input type="text" class="form-control" id="validationTooltip02" name="email6" value="<?php echo $menteeEmails[6]; ?>">
      </div>
      <div class="col-md-4 position-relative">
        <label for="validationTooltipUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
          <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
        </div>
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip01" class="form-label"><?php echo $row['sub1']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub1m6" name="sub1m6" value="<?php echo $menteesub1[6]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub2']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub2m6" name="sub2m6" value="<?php echo $menteesub2[6]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub3']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub3m6" name="sub3m6" value="<?php echo $menteesub3[6]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub4']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub4m6" name="sub4m6" value="<?php echo $menteesub4[6]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub5']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub5m6" name="sub5m6" value="<?php echo $menteesub5[6]; ?>">
      </div>
      <div class="col-md-2 position-relative">
        <label for="validationTooltip02" class="form-label"><?php echo $row['sub6']; ?><sup>*</sup></label>
        <input type="number" class="form-control" id="sub6m6" name="sub6m6" value="<?php echo $menteesub6[6]; ?>">
      </div>
      <small><sup>*</sup> Enter the values between 0 - 100</small>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="update6" name="update6">Save changes</button>
          </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
    </form>
    </div>
      </div>
    </div>
  </div>
</div>
</div>
  </div>
        <div class="view">
        `<div class="welcome">
        <center><p class="fst-italic">Hello <b><?php echo $sessHolder; ?></b> here you can able to view your details</p></center>
            <div class="userdetails">
            <div class="user_prof">
    <div class="circleContainer">
        <img id="userDisp" src= "<?php echo 'https://cdn-icons-png.flaticon.com/128/609/609001.png' ?>" class="circle-image">
    </div>
</div>
    <form action="#" class="row g-3 needs-validation" novalidate>
  <div class="col-md-4 position-relative">
    <label for="validationTooltip01" class="form-label">Name</label>
    <input type="text" class="form-control" id="validationTooltip01" name="uname" value="<?php echo $sessHolder; ?>" disabled readonly>
  </div>
  <div class="col-md-4 position-relative">
    <label for="validationTooltip02" class="form-label">Email</label>
    <input type="text" class="form-control" id="validationTooltip02" name="email" value="<?php echo $_SESSION['unameMMS']; ?>" disabled readonly>
  </div>
  <div class="col-md-4 position-relative">
    <label for="validationTooltipUsername" class="form-label">Username</label>
    <div class="input-group has-validation">
      <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
      <input type="text" class="form-control" id="validationTooltipUsername" value="Not Applicable" aria-describedby="validationTooltipUsernamePrepend" disabled readonly>
    </div>
  </div>
  <div class="col-md-6 position-relative">
    <label for="validationTooltip03" class="form-label">Date of Birth</label>
    <input type="date" value="<?php echo $dob; ?>" class="form-control" id="dob" name="dob" disabled readonly>
  </div>
  <div class="col-md-3 position-relative">
    <label for="validationTooltip05" class="form-label">Age</label>
    <input type="number" class="form-control" id="age" name="age" value="<?php echo $Age; ?>" disabled readonly>
  </div>
  <div class="col-md-3 position-relative">
    <label for="validationTooltip05" class="form-label">Pincode</label>
    <input type="number" class="form-control" id="zip" name="zip" value="<?php echo $zip; ?>" disabled readonly>
  </div>
    <div class="mb-3">
        <label for="country" class="form-label">Country</label>
        <input type="text" id="country" class="form-control" name="country" value="<?php echo $country; ?>" disabled readonly>
    </div>
    <div class="mb-3">
        <label for="statee" class="form-label">State</label>
        <input type="text" id="statee" class="form-control" name="statee" value="<?php echo $state; ?>" disabled readonly>
    </div>
    <center><u><b><i><p class="fst-italic">Mentee Average Progress</p></i></b></u></center>
    <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[1]; ?></label></i></b><p><?php echo $menteesub2[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar html" role="progressbar" style="width: <?php echo $menteeavg[1]; ?>%" aria-valuenow="<?php echo $menteesub2[1]; ?>%" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM1"></div>
</div>
<div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[2]; ?></label></i></b><p><?php echo $menteesub2[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar css" role="progressbar" style="width: <?php echo $menteeavg[2]; ?>%" aria-valuenow="<?php echo $menteesub2[2]; ?>" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM2"></div>
</div>
<div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[3]; ?></label></i></b><p><?php echo $menteesub2[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar php" role="progressbar" style="width: <?php echo $menteeavg[3]; ?>%" aria-valuenow="<?php echo $menteesub2[3]; ?>" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM3"></div>
</div>
<div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[4]; ?></label></i></b><p><?php echo $menteesub2[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar js" role="progressbar" style="width: <?php echo $menteeavg[4]; ?>%" aria-valuenow="<?php echo $menteesub2[4]; ?>" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM4"></div>
</div>
<div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[5]; ?></label></i></b><p><?php echo $menteesub2[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar sql" role="progressbar" style="width: <?php echo $menteeavg[5]; ?>%" aria-valuenow="<?php echo $menteesub2[5]; ?>" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM5"></div>
</div>
<div class="percent" ><label for="" class=""><b><i><?php echo $menteeName[6]; ?></label></i></b><p><?php echo $menteesub2[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar mdb" role="progressbar" style="width: <?php echo $menteeavg[6]; ?>%" aria-valuenow="<?php echo $menteesub2[6]; ?>" aria-valuemin="0" aria-valuemax="100" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModalM6"></div>
</div>
  </div>
</form>
        </div>


        <div class="modal fade" id="exampleModalM1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[1] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[1]; ?>%" aria-valuenow="<?php echo $menteesub1[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[1]; ?>%" aria-valuenow="<?php echo $menteesub2[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[1]; ?>%" aria-valuenow="<?php echo $menteesub3[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[1]; ?>%" aria-valuenow="<?php echo $menteesub4[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[1]; ?>%" aria-valuenow="<?php echo $menteesub5[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[1]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[1]; ?>%" aria-valuenow="<?php echo $menteesub6[1]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModalM2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[2] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
        
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[2]; ?>%" aria-valuenow="<?php echo $menteesub1[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[2]; ?>%" aria-valuenow="<?php echo $menteesub2[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[2]; ?>%" aria-valuenow="<?php echo $menteesub3[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[2]; ?>%" aria-valuenow="<?php echo $menteesub4[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[2]; ?>%" aria-valuenow="<?php echo $menteesub5[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[2]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[2]; ?>%" aria-valuenow="<?php echo $menteesub6[2]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModalM3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[3] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
        
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[3]; ?>%" aria-valuenow="<?php echo $menteesub1[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[3]; ?>%" aria-valuenow="<?php echo $menteesub2[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[3]; ?>%" aria-valuenow="<?php echo $menteesub3[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[3]; ?>%" aria-valuenow="<?php echo $menteesub4[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[3]; ?>%" aria-valuenow="<?php echo $menteesub5[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[3]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[3]; ?>%" aria-valuenow="<?php echo $menteesub6[3]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModalM4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[4] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
        
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[4]; ?>%" aria-valuenow="<?php echo $menteesub1[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[4]; ?>%" aria-valuenow="<?php echo $menteesub2[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[4]; ?>%" aria-valuenow="<?php echo $menteesub3[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[4]; ?>%" aria-valuenow="<?php echo $menteesub4[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[4]; ?>%" aria-valuenow="<?php echo $menteesub5[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[4]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[4]; ?>%" aria-valuenow="<?php echo $menteesub6[4]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModalM5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[5] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
        
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[5]; ?>%" aria-valuenow="<?php echo $menteesub1[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[5]; ?>%" aria-valuenow="<?php echo $menteesub2[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[5]; ?>%" aria-valuenow="<?php echo $menteesub3[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[5]; ?>%" aria-valuenow="<?php echo $menteesub4[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[5]; ?>%" aria-valuenow="<?php echo $menteesub5[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[5]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[5]; ?>%" aria-valuenow="<?php echo $menteesub6[5]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModalM6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $menteeName[6] ?> Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="men_prof prog" style="justify-content: center; align-items: center; padding-bottom:10px;">
        <div class="circle-container">
        <img src="<?php echo $Icon; ?>" class="circle-image">
    </div>
</div>
      <div class="userdetails">
        
      <div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub1']; ?></label></i></b><p><?php echo $menteesub1[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub1[6]; ?>%" aria-valuenow="<?php echo $menteesub1[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub2']; ?></label></i></b><p><?php echo $menteesub2[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub2[6]; ?>%" aria-valuenow="<?php echo $menteesub2[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub3']; ?></label></i></b><p><?php echo $menteesub3[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub3[6]; ?>%" aria-valuenow="<?php echo $menteesub3[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub4']; ?></label></i></b><p><?php echo $menteesub4[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub4[6]; ?>%" aria-valuenow="<?php echo $menteesub4[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub5']; ?></label></i></b><p><?php echo $menteesub5[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub5[6]; ?>%" aria-valuenow="<?php echo $menteesub5[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>

<div class="progressbar">
      <div class="percent" ><label for="" class=""><b><i><?php echo $row['sub6']; ?></label></i></b><p><?php echo $menteesub6[6]; ?>%</p></div>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $menteesub6[6]; ?>%" aria-valuenow="<?php echo $menteesub6[6]; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

</div>
  </div>


        <div class="footer">
          <div class"copyright">
            <center><p>© 2023 Copyright: Mentor Dashboard</p></center>
            </div>
            <div class="social">
                <nav>
                    <ul>
                        <li> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-linkedin" viewBox="0 0 16 16"><path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/></svg></li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-facebook" viewBox="0 0 16 16"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/></svg></li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-twitter" viewBox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/></svg></li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-instagram" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/></svg></li>
                    </ul>
                </nav>
            </div>
        </div>

        <script src="country-states.js"></script>
        <script> document.cookie = "decode = data:image/png;base64,"</script>
        <script>
        function ageCalculator()
        {
          var userinput = document.getElementById("dob").value;
          var dob = new Date(userinput);

          var month_diff = Date.now() - dob.getTime();
          var age_dt = new Date(month_diff); 
          var year = age_dt.getUTCFullYear();
          var age = Math.abs(year - 1970);
          document.getElementById('age').value = age;
        }

        var user_country_code = "";
        (() => {

        const country_array = country_and_states.country;
        const states_array = country_and_states.states;

        const id_state_option = document.getElementById("state");
        const id_country_option = document.getElementById("country");

        const createCountryNamesDropdown = () => {
        let option =  '';
        option += '<option value="">Choose..</option>';

        for(let country_code in country_array)
        {
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="'+country_code+'"'+selected+'>'+country_array[country_code]+'</option>';
        }
        id_country_option.innerHTML = option;
    };

    const createStatesNamesDropdown = () => {
        let selected_country_code = id_country_option.value;
        // get state names
        let state_names = states_array[selected_country_code];

        // if invalid country code
        if(!state_names){
            id_state_option.innerHTML = '<option>Choose..</option>';
            return;
        }
        let option = '';
        option += '<select id="state">';
        for (let i = 0; i < state_names.length; i++) {
            option += '<option value="'+state_names[i].code+'">'+state_names[i].name+'</option>';
        }
        option += '</select>';
        id_state_option.innerHTML = option;
    };

    // country select change event
    id_country_option.addEventListener('change', createStatesNamesDropdown);

    createCountryNamesDropdown();
    createStatesNamesDropdown();
})();
</script>
<script>
            document.getElementById('logout-button').addEventListener('click', function ()
            {
                swal({
                    title: "Logout?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willLogout) => {
                    if (willLogout)
                    {
                        window.location.href = "logout.php";
                    }
                });
            });
        </script>
    </body>
</html>