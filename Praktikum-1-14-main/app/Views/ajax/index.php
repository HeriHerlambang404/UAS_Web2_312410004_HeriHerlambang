<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 40px; }
        .container { max-width: 900px; margin: auto; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #222; color: white; }
        .btn { padding: 8px 12px; border-radius: 5px; color: white; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2563eb; }
        .btn-danger { background: #dc2626; }
    </style>
</head>
<body>
<div class="container">
    <h1>Data Artikel</h1>

    <table id="artikelTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        const loadData = () => {
            $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');

            $.getJSON('/ajax/getData', function (data) {
                let tableBody = '';

                data.forEach(function (row) {
                    tableBody += `<tr>
                        <td>${row.id}</td>
                        <td>${row.judul}</td>
                        <td>${row.status == 1 ? 'Publish' : 'Draft'}</td>
                        <td>
                            <a href="/admin/artikel/edit/${row.id}" class="btn btn-primary">Edit</a>
                            <a href="#" class="btn btn-danger btn-delete" data-id="${row.id}">Delete</a>
                        </td>
                    </tr>`;
                });

                $('#artikelTable tbody').html(tableBody || '<tr><td colspan="4">Tidak ada data.</td></tr>');
            });
        };

        loadData();

        $(document).on('click', '.btn-delete', function (event) {
            event.preventDefault();
            const id = $(this).data('id');

            if (!confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                return;
            }

            $.ajax({
                url: `/ajax/delete/${id}`,
                method: 'DELETE',
                success: loadData,
                error: function () {
                    alert('Gagal menghapus artikel.');
                }
            });
        });
    });
</script>
</body>
</html>
