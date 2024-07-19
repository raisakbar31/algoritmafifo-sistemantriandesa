<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?= form_open('register/create') ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <?= form_error('username', '<div class="text-danger">', '</div>') ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <?= form_error('password', '<div class="text-danger">', '</div>') ?>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        <?= form_close() ?>
        <p>Sudah punya akun? <a href="<?= site_url('login') ?>">Login di sini</a></p>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
