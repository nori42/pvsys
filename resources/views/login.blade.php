<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/login.css')
    <title>PVSYS</title>
</head>
<body>
    <div class="login-form d-flex justify-content-center align-items-center bg-secondary-subtle mx-auto mt-5">
        <form 
        class="d-flex flex-column align-items-center justify-content-center" 
        action=""
        autocomplete="off"
        >
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" id="username" name="email" required>    
        </div>
        <div>
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" id="username" name="password" required>
        </div>
        <button class="btn btn-primary my-3 px-5">Login</button>
        <div>
            <a href="/register">Register</a>
        </div>
    </form>
    </div>
</body>
</html>