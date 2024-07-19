<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Tambah Antrian</h1>
        <?= form_open('queue/create') ?>
            <div class="form-group">
                <label for="service">Layanan</label>
                <select class="form-control" id="service" name="service_id" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= $service->id ?>"><?= $service->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">
            <button type="submit" class="btn btn-primary">Antri Sekarang</button>
        <?= form_close() ?>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
