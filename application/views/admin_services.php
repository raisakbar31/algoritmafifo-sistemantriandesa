<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Layanan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Manajemen Layanan</h1>

        <!-- Form untuk menambahkan layanan -->
        <?= form_open('admin/add_service') ?>
            <div class="form-group">
                <label for="name">Nama Layanan</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Layanan</button>
        <?= form_close() ?>

        <!-- Daftar layanan -->
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Layanan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service->id ?></td>
                        <td><?= $service->name ?></td>
                        <td>
                            <?= form_open('admin/edit_service/'.$service->id, array('class' => 'd-inline')) ?>
                                <input type="text" name="name" value="<?= $service->name ?>" required>
                                <button type="submit" class="btn btn-warning">Edit</button>
                            <?= form_close() ?>
                            <?= form_open('admin/delete_service/'.$service->id, array('class' => 'd-inline')) ?>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            <?= form_close() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
