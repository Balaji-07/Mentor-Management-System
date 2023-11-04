<?php
   include("config.php");
   session_start();

   $username = "";
   $email    = "";
   $errors = array(); 

   // REGISTER USER
   static $cleanedUsername="";
if (isset($_POST['register']))
{
   $username = mysqli_real_escape_string($db, $_POST['uname']);
   $email = mysqli_real_escape_string($db, $_POST['email']);
   $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
   $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
 
  
   if (empty($username)) { array_push($errors, "Username is required"); }
   elseif (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/', $username)) {
    array_push($errors, "Username must starts with Alphabet");
}
   if (empty($email)) { array_push($errors, "Email is required"); }
   if (empty($password_1)) { array_push($errors, "Password is required"); }
   if ($password_1 != $password_2)
   {
    array_push($errors, "The two passwords doesn't match");
   }
 
   $user_check_query = "SELECT * FROM reg WHERE email='$email' LIMIT 1";
   $result = mysqli_query($db, $user_check_query);
   $user = mysqli_fetch_assoc($result);
   
   if ($user)
   {
      array_push($errors, "email already exists");
   }

   $user_check_query2 = "SELECT * FROM reg WHERE uname='$username' LIMIT 1";
   $result2 = mysqli_query($db, $user_check_query2);
   $user2 = mysqli_fetch_assoc($result2);
   
   if ($user2)
   {
      array_push($errors, "Username already exists");
   }
 
   if (count($errors) == 0)
   {
      $password = md5($password_1);
 
      $query = "INSERT INTO reg (uname, email, password_1) 
              VALUES('$username', '$email', '$password')";
      mysqli_query($db, $query);
      $cleanedUsername = str_replace(' ', '', $username);
      $query = "CREATE TABLE $cleanedUsername (
         mno integer NOT NULL,
         uname varchar(100) DEFAULT 'User Not Configured',
         email varchar(30) DEFAULT NULL,
         sub1 integer DEFAULT 0,
         sub2 integer DEFAULT 0,
         sub3 integer DEFAULT 0,
         sub4 integer DEFAULT 0,
         sub5 integer DEFAULT 0,
         sub6 integer DEFAULT 0,
         avg integer DEFAULT 0
     )";
     mysqli_query($db, $query);
     for($i=1;$i<=6;$i++)
     {
      $query = "INSERT INTO $cleanedUsername (mno) VALUES('$i')";
     mysqli_query($db, $query);
     }
      $_SESSION['success'] = "You are now logged in";
      header("location: index.php?notify=inSuccess");
      exit();
   }
 }


// LOGIN USER
if (isset($_POST['login'])) {
   $username = mysqli_real_escape_string($db, $_POST['uname']);
   $password = mysqli_real_escape_string($db, $_POST['pass']);
 
   if (empty($username)) {
      array_push($errors, "Username is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }
   if (count($errors) == 0) {
      $password = md5($password);
      $query = "SELECT * FROM reg WHERE email='$username' AND password_1='$password'";
      $results = mysqli_query($db, $query);
      $row2 = $results->fetch_assoc();
      if (mysqli_num_rows($results) == 1) {
        $_SESSION['unameMMS'] = $username;
        $cleanedUsername = str_replace(' ', '', $row2['uname']);
        header('location: home.php');
      }else {
         array_push($errors, " Wrong username/password combination");
      }
   }
 }

 

 $sub1 = "";
 $sub2 = "";
 $sub3 = "";
 $sub4 = "";
 $sub5 = "";
 $sub6 = "";


if (isset($_POST['update'])) {
   $dob = $_POST['dob'];
   $dobDateTime = new DateTime($dob);
   $now = new DateTime();
   $interval = $dobDateTime->diff($now);
   $Age = $interval->y;

   $country = $_POST['country'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $subName1 = $_POST['sub1'];
    $subName2 = $_POST['sub2'];
    $subName3 = $_POST['sub3'];
    $subName4 = $_POST['sub4'];
    $subName5 = $_POST['sub5'];
    $subName6 = $_POST['sub6'];

        $query = "UPDATE reg SET dob = ?, age = ?, country = ?, stat = ?, zip = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ? WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssssssssssss", $dob, $Age, $country, $state, $zip, $subName1, $subName2, $subName3, $subName4, $subName5, $subName6, $_SESSION['unameMMS']);
        $stmt->execute();
        $stmt->close();

      
}

if (isset($_POST['update1'])) {

   
      $mname = $_POST["uname1"];
      $memail = $_POST["email1"];

      $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
    $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

    if ($selectStmtUser->execute()) {
        $selectResult = $selectStmtUser->get_result();
        $row2 = $selectResult->fetch_assoc();
        $cleanedUsername = str_replace(' ', '', $row2['uname']);;

        for ($j = 1; $j <= 6; $j++) {
            ${"subret{$j}"} = $_POST["sub{$j}m1"];
        }



        if (count($errors) == 0) {
         $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
               $stmt = $db->prepare($query);

            if ($stmt) {
               $mno=1;
               $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
               $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
                $stmt->execute();
                $stmt->close();
                $_SESSION['success'] = "Details Updated";
            } else {
                echo "Prepare failed: (" . $db->errno . ") " . $db->error;
            }
        } else {
            echo "Error: " . implode(', ', $errors);
        }
    } else {
        echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
    }
}
}

if (isset($_POST['update2'])) {

   
   $mname = $_POST["uname2"];
   $memail = $_POST["email2"];

   $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
 $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

 if ($selectStmtUser->execute()) {
     $selectResult = $selectStmtUser->get_result();
     $row2 = $selectResult->fetch_assoc();
     $cleanedUsername = str_replace(' ', '', $row2['uname']);;

     for ($j = 1; $j <= 6; $j++) {
         ${"subret{$j}"} = $_POST["sub{$j}m2"];
     }

 

     if (count($errors) == 0) {
      $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
            $stmt = $db->prepare($query);

         if ($stmt) {
            $mno=2;
            $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
            $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
             $stmt->execute();
             $stmt->close();
             $_SESSION['success'] = "Details Updated";
         } else {
             echo "Prepare failed: (" . $db->errno . ") " . $db->error;
         }
     } else {
         echo "Error: " . implode(', ', $errors);
     }
 } else {
     echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
 }
}
}

if (isset($_POST['update3'])) {

   
   $mname = $_POST["uname3"];
   $memail = $_POST["email3"];

   $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
 $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

 if ($selectStmtUser->execute()) {
     $selectResult = $selectStmtUser->get_result();
     $row2 = $selectResult->fetch_assoc();
     $cleanedUsername = $row2['uname'];

     for ($j = 1; $j <= 6; $j++) {
         ${"subret{$j}"} = $_POST["sub{$j}m3"];
     }

  

     if (count($errors) == 0) {
      $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
            $stmt = $db->prepare($query);

         if ($stmt) {
            $mno=3;
            $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
            $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
             $stmt->execute();
             $stmt->close();
             $_SESSION['success'] = "Details Updated";
         } else {
             echo "Prepare failed: (" . $db->errno . ") " . $db->error;
         }
     } else {
         echo "Error: " . implode(', ', $errors);
     }
 } else {
     echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
 }
}
}

if (isset($_POST['update4'])) {

   
   $mname = $_POST["uname4"];
   $memail = $_POST["email4"];

   $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
 $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

 if ($selectStmtUser->execute()) {
     $selectResult = $selectStmtUser->get_result();
     $row2 = $selectResult->fetch_assoc();
     $cleanedUsername = $row2['uname'];

     for ($j = 1; $j <= 6; $j++) {
         ${"subret{$j}"} = $_POST["sub{$j}m4"];
     }



     if (count($errors) == 0) {
      $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
            $stmt = $db->prepare($query);

         if ($stmt) {
            $mno=4;
            $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
            $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
             $stmt->execute();
             $stmt->close();
             $_SESSION['success'] = "Details Updated";
         } else {
             echo "Prepare failed: (" . $db->errno . ") " . $db->error;
         }
     } else {
         echo "Error: " . implode(', ', $errors);
     }
 } else {
     echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
 }
}
}

if (isset($_POST['update5'])) {

   
   $mname = $_POST["uname5"];
   $memail = $_POST["emai5"];

   $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
 $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

 if ($selectStmtUser->execute()) {
     $selectResult = $selectStmtUser->get_result();
     $row2 = $selectResult->fetch_assoc();
     $cleanedUsername = $row2['uname'];

     for ($j = 1; $j <= 6; $j++) {
         ${"subret{$j}"} = $_POST["sub{$j}m5"];
     }



     if (count($errors) == 0) {
      $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
            $stmt = $db->prepare($query);

         if ($stmt) {
            $mno=5;
            $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
            $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
             $stmt->execute();
             $stmt->close();
             $_SESSION['success'] = "Details Updated";
         } else {
             echo "Prepare failed: (" . $db->errno . ") " . $db->error;
         }
     } else {
         echo "Error: " . implode(', ', $errors);
     }
 } else {
     echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
 }
}
}

if (isset($_POST['update6'])) {

   
   $mname = $_POST["uname6"];
   $memail = $_POST["email6"];

   $selectUser = "SELECT uname FROM reg WHERE email = ?";
$selectStmtUser = $db->prepare($selectUser);

if ($selectStmtUser) {
 $selectStmtUser->bind_param("s", $_SESSION['unameMMS']);

 if ($selectStmtUser->execute()) {
     $selectResult = $selectStmtUser->get_result();
     $row2 = $selectResult->fetch_assoc();
     $cleanedUsername = $row2['uname'];

     for ($j = 1; $j <= 6; $j++) {
         ${"subret{$j}"} = $_POST["sub{$j}m6"];
     }

  

     if (count($errors) == 0) {
      $query = "UPDATE $cleanedUsername SET uname = ?, email = ?, sub1 = ?, sub2 = ?, sub3 = ?, sub4 = ?, sub5 = ?, sub6 = ?, avg = ? WHERE mno = ?";
            $stmt = $db->prepare($query);

         if ($stmt) {
            $mno=6;
            $average = (int)(($subret1+$subret2+$subret3+$subret4+$subret5+$subret6)/6);
            $stmt->bind_param("ssiiiiiiii", $mname, $memail, $subret1, $subret2, $subret3, $subret4, $subret5, $subret6, $average,$mno);
             $stmt->execute();
             $stmt->close();
             $_SESSION['success'] = "Details Updated";
         } else {
             echo "Prepare failed: (" . $db->errno . ") " . $db->error;
         }
     } else {
         echo "Error: " . implode(', ', $errors);
     }
 } else {
     echo "Execution failed: (" . $selectStmtUser->errno . ") " . $selectStmtUser->error;
 }
}
}
?>