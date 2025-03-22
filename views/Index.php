<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: #ecf0f1;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 70%;
        }
        .login-logo {
            width: 40%;
            text-align: center;
        }
        .login-logo img {
            max-width: 100%;
            position: relative;
            margin-top: -5rem;
        }
        .login-form {
            width: 50%;
        }
        .login-form h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #3498db;
            text-transform: uppercase;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffffff;
            color: #333;
            border: 2px solid #3498db;
            border-radius: 5px;
        }
        .btn-login {
            background-color: #3498db;
            color: #fff;
            font-size: 1.2rem;
            padding: 12px 25px;
            text-transform: uppercase;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }
        .btn-login:hover {
            background-color: #2980b9;
        }
        .text-secondary {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        .welcome-text {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: -6rem;
            text-align: center;
            color: #3498db;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h1 class="text-center">Login</h1>
        <form action="../actions/user-actions.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label text-secondary">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-secondary">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-login" name="login">Sign In</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#registration">Create an Account</button>
        </div>

        <div class="modal fade" id="registration" tabindex="-1" aria-labelledby="registrationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registrationLabel">Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../actions/user-actions.php" method="post">
                            <div class="mb-3">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first-name" class="form-control" placeholder="First Name">
                            </div>
                            <div class="mb-3">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="mb-3">
                                <label for="reg-username" class="form-label">Username</label>
                                <input type="text" name="username" id="reg-username" class="form-control" placeholder="Create a Username">
                            </div>
                            <div class="mb-3">
                                <label for="reg-password" class="form-label">Password</label>
                                <input type="password" name="password" id="reg-password" class="form-control" placeholder="Create a Password">
                            </div>
                            <button type="submit" class="btn btn-danger w-100" name="register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
