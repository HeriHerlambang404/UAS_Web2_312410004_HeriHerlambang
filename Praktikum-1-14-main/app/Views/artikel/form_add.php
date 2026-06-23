<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tambah Artikel'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 760px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button,
        .btn {
            display: inline-block;
            background: #15803d;
            color: white;
            border: 0;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-secondary {
            background: #555;
        }

        .error {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 6px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Artikel</h1>

    <?php if (isset($validation)): ?>
        <div class="error"><?= $validation->listErrors(); ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <label>Judul Artikel</label>
        <input type="text" name="judul" value="<?= old('judul'); ?>" required>

        <label>Isi Artikel</label>
        <textarea name="isi" rows="10"><?= old('isi'); ?></textarea>

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']); ?>" <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : ''; ?>>
                    <?= esc($k['nama_kategori']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Status</label>
        <select name="status">
            <option value="1" <?= old('status', '1') == '1' ? 'selected' : ''; ?>>Publish</option>
            <option value="0" <?= old('status') == '0' ? 'selected' : ''; ?>>Draft</option>
        </select>

        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*">

        <button type="submit">Simpan Artikel</button>
        <a class="btn btn-secondary" href="/admin/artikel">Kembali</a>
    </form>
</div>
</body>
</html>
