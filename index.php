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


</head>

<body class="p-5 text-center">



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
                    <button class="btn btn-primary" id="btn-create">Create</button>
                </div>

            </div>
        </div>




    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


    <script>
    $(document).ready(function() {


        $("#btn-create").click(function(e) {
			//e.preventDefault();
            


			let name  = $("#name").val();
			let email = $("#email").val();

			//alert(name +" "+  email);

			if (email == ""){
				alert("Email is mandatory");
			}else if(name == ""){
				alert("Name is mandatory");
			}else{

				$.ajax({
                    type: "POST",
                    url: "SubscriberController.php",
                    data: { "function" : "prueba", //"addSubscriber",
                            "email" :  email,
                            "name" : name },
                    cache: false,
                    dataType: "json", 

    				success: function(res) {
                   
                        json = JSON.parse(res);
                        console.log(json);
                    } 
			    }); //ajax
			}


        }); //create

        

    });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</body>

</html>

