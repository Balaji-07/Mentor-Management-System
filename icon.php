<?php
include("config.php");
$selectQuery = "SELECT * FROM icon WHERE sno = ?";
$selectStmt = $db->prepare($selectQuery);

if ($selectStmt)
{
  $no=1;
    $selectStmt->bind_param("i", $no);
    if ($selectStmt->execute()) {
        $selectResult = $selectStmt->get_result();
        $row = $selectResult->fetch_assoc();
        $Icon2 = $row['icon'];
$Icon = 'https://cdn4.iconfinder.com/data/icons/Pretty_office_icon_part_2/256/personal-information.png';
    }
  }
?>
<html>
    <head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
      <style>
        .circleContainer{
  display: inline-block;
  width: 50px;
  height: 50px;
}
.men_prof{
  display:flex;
}
.men_prof label{
  padding-left:10px;
}
.circle-container {
  width: 300px;
  height: 300px;
  border-radius: 50%;
  overflow: hidden;
  background-color: lightgray;
}
.circle-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
        </style>
    <div class="men_prof">
        <div class="circle-container">
        <img id="imageOutput" src="<?php echo $Icon; ?>" class="circle-image">
    </div>
    <input type="file" id="file" name="file">
    <div>
        <textarea id="base64Input" placeholder="Paste your base64 here"></textarea>
        <input type="text" id="validationTooltip02" name="email1" value="">
        <br>
        <button id="convertButton">Convert to Image</button>
    </div>
    </div>
    <button type="button" href="javascript:void(0)" onclick="swal('alert','','success')">Error</button>
    <script>
        document.getElementById("convertButton").addEventListener("click", function ()
        {
          document.getElementById("validationTooltip02").value = "<?php echo $Icon2; ?>";
            var base64Input = "<?php echo $Icon2; ?>";
            var imageOutput = document.getElementById("imageOutput");

            if (base64Input) {
                imageOutput.src = "data:image/png;base64," + base64Input;
            }
        });
    </script>
</body>
</html>