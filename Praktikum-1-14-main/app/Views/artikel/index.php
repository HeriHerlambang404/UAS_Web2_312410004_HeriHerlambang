<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

```
<style>
    body{
        font-family: Arial, sans-serif;
        background:#f4f4f4;
        margin:0;
        padding:40px;
    }

    .container{
        max-width:900px;
        margin:auto;
    }

    h1{
        text-align:center;
        margin-bottom:40px;
        color:#333;
    }

    .card{
        background:white;
        padding:25px;
        margin-bottom:20px;
        border-radius:12px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
        transition:0.3s;
    }

    .card:hover{
        transform:translateY(-5px);
    }

    .card h2{
        margin-top:0;
    }

    .card a{
        text-decoration:none;
        color:#007bff;
    }

    .card a:hover{
        color:#0056b3;
    }

    .card p{
        color:#555;
        line-height:1.6;
    }

    .kategori{
        margin-bottom:15px;
        color:#444;
        font-size:14px;
    }

</style>
```

</head>
<body>

<div class="container">

```
<h1><?= $title; ?></h1>

<?php foreach ($artikel as $row): ?>

    <div class="card">

        <h2>
            <a href="/artikel/<?= $row['slug']; ?>">
                <?= $row['judul']; ?>
            </a>
        </h2>

        <div class="kategori">
            Kategori :
            <strong><?= $row['nama_kategori']; ?></strong>
        </div>

        <p>
            <?= substr($row['isi'],0,120); ?>...
        </p>

    </div>

<?php endforeach; ?>
```

</div>

</body>
</html>
