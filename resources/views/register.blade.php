<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/register.css')
    <title>PVSYS</title>
</head>
<body>
    <div class="login-form d-flex justify-content-center align-items-center bg-secondary-subtle mx-auto mt-5">
        <form 
        class="d-flex flex-column justify-content-center p-3"
        action="/register"
        method="POST"
        autocomplete="off"
        id="registerForm"
        >
            @csrf
            <div>
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="username" name="email" required>    
            </div>

            <div>
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>

            <div>
                <label class="form-label" for="confPassword">Confirm Password</label>
                <input class="form-control" type="password" id="confPassword" name="confPassword" required>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <div>
                    <label class="form-label" for="firstname">First Name</label>
                    <input class="form-control" type="text" id="firstname" name="firstname" required>    
                </div>

                <div>
                    <label class="form-label" for="lastname">Last Name</label>
                    <input class="form-control" type="text" id="lastname" name="lastname" required>    
                </div>
            </div>

            <div>
                <label class="form-label" for="phoneno">Phone No</label>
                <input class="form-control" type="text" id="phoneno" name="phoneno" required>    
            </div>

            <button class="btn btn-primary my-3" id="btnRegister">Register</button>
            <div class="text-danger d-none" id="confPassError">Confirm password must match with password</div>
            @if (session('emailExist'))
                <div class="text-danger">Email Already Exist</div>
            @endif
        </form>
    </div>
</body>
<script>
    const btnRegister = document.querySelector("#btnRegister");

    btnRegister.addEventListener("click",()=>{
        const inputPass = document.querySelector("#password");
        const inputConfPass = document.querySelector("#confPassword");
        // if(inputPass.value != inputConfPass.value){
        //     document.querySelector("#confPassError").classList.remove('d-none');
        // }else{
        //     document.querySelector("#registerForm").submit();
        // }
        if (inputPass.value != inputConfPass.value) {
            inputConfPass.setCustomValidity("Password must match");
        } else {
            inputConfPass.setCustomValidity("");
        }
    })
</script>
</html>