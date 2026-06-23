<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>

        body{
            font-family:Arial;
            background:#f4f4f4;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box{
            background:white;
            padding:40px;
            width:350px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            background:#007bff;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }

        .error{
            background:#ffdddd;
            color:#d8000c;
            padding:10px;
            margin-bottom:15px;
            border-radius:8px;
        }

    </style>
</head>
<body>

<div class="login-box">

    <h2>Login Admin</h2>

    <?php if(session()->getFlashdata('msg')): ?>

        <div class="error">
            <?= session()->getFlashdata('msg'); ?>
        </div>

    <?php endif; ?>

    <form action="/user/login" method="post">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>