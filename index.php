<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscriptions System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="p-5">



        <div class="card bg-dark  text-white" style="width: 30rem;">
            <div class="card-body">
                <div class="m-1">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mt-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="John Doe">
                </div>


                <div class="mt-3 text-center">
                    <button class="btn btn-primary" id="btn-create"><i class="fas fa-user-plus mx-2"></i>Create</button>
                </div>

            </div>
        </div> <!-- card -->




<!-- Modal -->
<div class="modal fade" id="tycModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Terminos y Condiciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p>si aceptas los terminos, nos autorizas a guardar datos tu siguiente informacion extra:</p>
          <ul>
              <li>Ip desde donde realizo la suscripcion</li>
              <li>Url desde donde realizo la suscripcion</li>
              <li>Fecha en que realizo la suscripcion</li>
              <li>Hora en que realizo la suscripcion</li>
          </ul>
          <em>No es obligatorio aceptar TyC para registrarte.</em>
            <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" id="check_tyc" checked>
                    <label class="form-check-label" for="check_tyc">Acepto</label>
            </div>
      </div> <!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="btn-continuar">
            <i class="fas fa-door-open mx-3"></i>Cerrar y continuar Registro
        </button>
      </div>
    </div>
  </div>
</div>





    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


    <script>
    $(document).ready(function() {

        $("#btn-create").click(function(e) {
            $("#tycModal").modal("show");
        }); //create


        $("#btn-continuar").click(function(e) {
                  
			let name  = $("#name").val();
			let email = $("#email").val();
            let tyc   = $("check_tyc").val();


            if( $('#check_tyc').prop('checked') ) {
                tyc = true;
            }else{
                tyc = false;
            }

            if (email == ""){
				alert("Email is mandatory");
			}else if(name == ""){
				alert("Name is mandatory");
			}else{

				$.ajax({
                    type: "POST",
                    url: "controllers/SubscriberController.php",
                    data: { 
                            "email" : email,
                            "name"  : name,
                            "tyc"   : tyc,   
                        },
                    cache: false,
                    dataType: "json", 

    				success: function(res) {
                   
                        json = JSON.parse(res);
                        console.log(json);
                    } 
			    }); //ajax
			} // if validated 
        }); //continuar      

    });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</body>

</html>

