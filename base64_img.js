document.getElementById("update").addEventListener("click", function ()
{
    var base64Input = document.getElementById("base64Input").value;
    var imageOutput = document.getElementById("imageOutput");

    if (base64Input)
    {
        imageOutput.src = "data:image/png;base64," + base64Input;
    }
});



/*




        <div class="modal fade" id="exampleModalM1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mentee-1</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
      <div class="userdetails">
      <h5 class="modal-title" id="exampleModalLabel">Mentee-1</h5>
    </div>
      </div>
    </div>
  </div>
</div>
</div>
  </div>


  */