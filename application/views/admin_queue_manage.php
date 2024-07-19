<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Antrian</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<style>
    /* custom.css */
body {
    background-color: #f8f9fa;
}

.container {
    margin-top: 20px;
}

h1, h2 {
    color: #343a40;
}

.card {
    border-radius: 10px;
    border: 1px solid #dee2e6;
    margin-bottom: 20px;
}

.card-body {
    padding: 20px;
}

.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background-color: #007bff;
    color: #fff;
}

.table th, .table td {
    text-align: center;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #e9ecef;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-primary, .btn-success, .btn-danger, .btn-info {
    border-radius: 5px;
}

.alert {
    border-radius: 5px;
}
</style>
<body>
    <div class="container">
        <h1>Manajemen Antrian</h1>
        <a href="<?= site_url('dashboard/admin') ?>" class="btn btn-secondary">Kembali ke Dashboard</a>

        <h2>Antrian Sekarang</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>Nama</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($queues as $queue): ?>
                    <tr>
                        <td><?= $queue->queue_number ?></td>
                        <td><?= $queue->username ?></td>
                        <td><?= $queue->service_name ?></td>
                        <td><?= $queue->status ?></td>
                        <td><?= $queue->created_at ?></td>
                        <td>
                            <form action="<?= site_url('admin/update_queue_service') ?>" method="post" class="form-inline">
                                <input type="hidden" name="queue_id" value="<?= $queue->id ?>">
                                <select class="form-control" name="service_id" required>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?= $service->id ?>" <?= $queue->service_id == $service->id ? 'selected' : '' ?>><?= $service->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary ml-2">Ubah</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
