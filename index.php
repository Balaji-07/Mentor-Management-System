<?php
   include("server.php");
   if (isset($_SESSION['unameMMS'])) {
    header("Location: home.php");
    exit();
  }
  $notify = $_GET['notify'] ?? '';
   
  if ($notify === 'inSuccess') {
      echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
      <script src="regtoast.js"></script>
      ';
  }

  if ($notify === 'outSuccess') {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="outtoast.js"></script>
    ';
}
?>



<html>
    <head>
        <title>Login/SignUp</title>
        <link rel="icon" type="image/x-icon" href="https://cdn1.iconfinder.com/data/icons/tiny-iconz-line-vol-09/20/fingerprint_biometric_login_scan-512.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="style.css?v=<?php echo time()?>">
    </head>
    <body>
        <div class="container">
        <div class="display">
            <img src="https://img.icons8.com/color/48/teacher.png" height=30px width=30px>
            <p class="">Mentee Management System</p>   
        </div>
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="errors">
                <?php include('errors.php'); ?>
            </div>
            <div class="form-inner">
                <div class="col">
                    <form action="#" class="login" id="login" method="post">
                        <div class="mb-3">
                                <input type="email" class="form-control" name="uname" id="uname" placeholder="Email Address">
                        </div>
                        <div class="mb-3">
                                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
                        </div>
                        <div class="btn">
                                <button type="submit" name="login" id="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <form action="#" class="register" id="register" method="post">
                        <div class="mb-3" style="position: relative;display: inline-block;">
                            <input type="text" class="form-control" style="padding-right: 30px;" name="uname" placeholder="Enter Your Name">
                            <span class="info-icon" style="position: absolute;top: 50%;right: 10px;transform: translateY(-80%);cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </svg>
    </span>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_1" placeholder="Enter Your Password">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_2" placeholder="Confirm your Password">
                        </div>
                        <div class="btn">
                            <button type="submit" name="register" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script src="formnav.js?v=<?php echo time()?>"></script>
    </body>
</html>