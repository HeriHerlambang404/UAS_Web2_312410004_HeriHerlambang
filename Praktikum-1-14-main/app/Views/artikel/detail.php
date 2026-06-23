<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $artikel['judul']; ?></title>

    <style>
        body{
            font-family:Arial, sans-serif;
            background:#f4f4f4;
            padding:40px;
        }

        .container{
            max-width:800px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        h1{
            color:#333;
        }

        p{
            line-height:1.8;
            color:#555;
        }

        a{
            text-decoration:none;
            color:#007bff;
        }

    </style>
</head>
<body>

<div class="container">

    <a href="/artikel">← Kembali</a>

    <h1><?= $artikel['judul']; ?></h1>

    <hr>

    <p><?= $artikel['isi']; ?></p>

</div>

</body>
</html>