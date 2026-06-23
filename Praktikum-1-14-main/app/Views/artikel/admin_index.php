<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        input,
        select,
        button {
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background: #0f766e;
            color: white;
            border: 0;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            margin: 3px;
        }

        .btn-add { background: #15803d; }
        .btn-edit { background: #2563eb; }
        .btn-delete { background: #dc2626; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #222;
            color: white;
        }

        th a {
            color: white;
            text-decoration: none;
        }

        .muted {
            color: #666;
            font-size: 13px;
        }

        .loading {
            padding: 18px;
            background: white;
            border: 1px solid #ddd;
        }

        .pagination {
            display: flex;
            gap: 6px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            background: white;
            color: #222;
            border: 1px solid #ddd;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination .active {
            background: #0f766e;
            color: white;
            border-color: #0f766e;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?= esc($title); ?></h1>

    <div class="toolbar">
        <form id="search-form" class="search-box">
            <input type="text" name="q" id="search-box" value="<?= esc($q); ?>" placeholder="Cari judul artikel">

            <select name="kategori_id" id="category-filter">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= esc($k['id_kategori']); ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="sort" id="sort-field">
                <option value="id" <?= $sort === 'id' ? 'selected' : ''; ?>>ID</option>
                <option value="judul" <?= $sort === 'judul' ? 'selected' : ''; ?>>Judul</option>
                <option value="kategori" <?= $sort === 'kategori' ? 'selected' : ''; ?>>Kategori</option>
                <option value="status" <?= $sort === 'status' ? 'selected' : ''; ?>>Status</option>
            </select>

            <select name="order" id="sort-order">
                <option value="desc" <?= $order === 'desc' ? 'selected' : ''; ?>>Z-A / Terbaru</option>
                <option value="asc" <?= $order === 'asc' ? 'selected' : ''; ?>>A-Z / Terlama</option>
            </select>

            <button type="submit">Cari</button>
        </form>

        <div>
            <a class="btn btn-add" href="/admin/artikel/add">Tambah Artikel</a>
            <a class="btn btn-delete" href="/user/logout">Logout</a>
        </div>
    </div>

    <div id="article-container">
        <div class="loading">Memuat data artikel...</div>
    </div>

    <div id="pagination-container" class="pagination"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        const articleContainer = $('#article-container');
        const paginationContainer = $('#pagination-container');
        const searchForm = $('#search-form');

        const escapeHtml = (value) => $('<div>').text(value ?? '').html();

        const fetchData = (url = '/admin/artikel') => {
            articleContainer.html('<div class="loading">Memuat data artikel...</div>');

            $.ajax({
                url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    renderArticles(data.artikel);
                    renderPagination(data.pager.links, data);
                },
                error: function () {
                    articleContainer.html('<div class="loading">Gagal memuat data.</div>');
                }
            });
        };

        const renderArticles = (articles) => {
            let html = '<table>';
            html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';

            if (articles.length > 0) {
                articles.forEach((article) => {
                    html += `
                        <tr>
                            <td>${article.id}</td>
                            <td>
                                <strong>${escapeHtml(article.judul)}</strong>
                                <div class="muted">${escapeHtml((article.isi || '').substring(0, 80))}</div>
                            </td>
                            <td>${escapeHtml(article.nama_kategori || '-')}</td>
                            <td>${article.status == 1 ? 'Publish' : 'Draft'}</td>
                            <td>
                                <a class="btn btn-edit" href="/admin/artikel/edit/${article.id}">Edit</a>
                                <a class="btn btn-delete" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += '<tr><td colspan="5">Tidak ada data.</td></tr>';
            }

            html += '</tbody></table>';
            articleContainer.html(html);
        };

        const renderPagination = (links, data) => {
            let html = '';

            links.forEach((link) => {
                if (!link.uri) {
                    html += `<span>${link.title}</span>`;
                    return;
                }

                const url = `${link.uri}&q=${encodeURIComponent(data.q)}&kategori_id=${encodeURIComponent(data.kategori_id)}&sort=${encodeURIComponent(data.sort)}&order=${encodeURIComponent(data.order)}`;
                html += `<a href="${url}" class="${link.active ? 'active' : ''}">${link.title}</a>`;
            });

            paginationContainer.html(html);
        };

        searchForm.on('submit', function (event) {
            event.preventDefault();
            const params = searchForm.serialize();
            fetchData(`/admin/artikel?${params}`);
        });

        $('#category-filter, #sort-field, #sort-order').on('change', function () {
            searchForm.trigger('submit');
        });

        paginationContainer.on('click', 'a', function (event) {
            event.preventDefault();
            fetchData($(this).attr('href'));
        });

        fetchData('/admin/artikel');
    });
</script>
</body>
</html>
