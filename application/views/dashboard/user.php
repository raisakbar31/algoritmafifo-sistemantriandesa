<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <a href="<?= site_url('queue') ?>" class="btn btn-primary">Lihat Antrian</a>
        <a href="<?= site_url('queue/add') ?>" class="btn btn-success">Antri Sekarang</a>
        <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">Logout</a>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
