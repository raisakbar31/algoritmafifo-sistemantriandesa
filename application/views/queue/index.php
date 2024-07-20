<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position:fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar h2 {
            margin-top: 0;
            font-size: 24px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 330px; /* Same as the width of the sidebar */
            padding: 20px;
            flex: 1;
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
        /* Gaya untuk Tabel */
.table {
    border-collapse: separate;
    border-spacing: 0;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.table thead th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    border: none;
}

.table tbody tr {
    transition: background-color 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table tbody td {
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
}

.table tbody td:first-child {
    border-radius: 10px 0 0 10px;
}

.table tbody td:last-child {
    border-radius: 0 10px 10px 0;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered thead th {
    border-bottom-width: 2px;
}


  
    </style>
</head>
<body>
 
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="nav flex-column">
       
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('auth/logout') ?>">Logout</a>
            </li>
            <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard/admin') ?>">Dashboard Admin</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard/user') ?>">Dashboard User</a>
                    </li>
                <?php endif; ?>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Daftar Antrian</h1>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <h2>Informasi Antrian</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nomor Antrian Terakhir</h5>
                        <p class="card-text"><?= $last_queue_number ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nomor Antrian Saya</h5>
                        <p class="card-text"><?= isset($my_queue->queue_number) ? $my_queue->queue_number : 'Anda belum mengambil nomor antrian' ?></p>
                        <?php if (isset($my_queue->queue_number)): ?>
                            <p class="card-text">Layanan yang Dipilih: <?= isset($my_queue->service_name) ? $my_queue->service_name : 'Tidak ada layanan' ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <h2>Antrian Sekarang</h2>
        <?php if (isset($queues) && is_array($queues) && !empty($queues)): ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>Nama</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($queues as $queue): ?>
                        <tr>
                            <td>
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <form action="<?= site_url('admin/update_queue_service') ?>" method="post" class="form-inline">
                                        <input type="hidden" name="queue_id" value="<?= $queue->id ?>">
                                        <input type="number" class="form-control" name="queue_number" value="<?= $queue->queue_number ?>" required>
                                        <select class="form-control ml-2" name="service_id" required>
                                            <?php foreach ($services as $service): ?>
                                                <option value="<?= $service->id ?>" <?= $queue->service_id == $service->id ? 'selected' : '' ?>><?= $service->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary ml-2">Ubah</button>
                                    </form>
                                <?php else: ?>
                                    <?= $queue->queue_number ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $queue->username ?></td>
                            <td><?= isset($queue->service_name) ? $queue->service_name : 'Tidak ada layanan' ?></td>
                            <td><?= $queue->status ?></td>
                            <td><?= $queue->created_at ?></td>
                            <?php if ($this->session->userdata('role') == 'admin'): ?>
                                <td>
                                    <a href="<?= site_url('queue/serve/'.$queue->id) ?>" class="btn btn-success">Layani</a>
                                    <a href="<?= site_url('queue/delete_queue/'.$queue->id) ?>" class="btn btn-danger">Hapus</a>
                                    <a href="<?= site_url('queue/move_to_end/'.$queue->id) ?>" class="btn btn-info">Lewati</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada antrian saat ini.</p>
        <?php endif; ?>

        <h2>Historis Antrian</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Layanan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($queue_history as $history): ?>
                    <tr>
                        <td><?= $history->queue_number ?></td>
                        <td><?= $history->username ?></td>
                        <td><?= $history->status ?></td>
                        <td><?= $history->created_at ?></td>
                        <td><?= isset($history->service_name) ? $history->service_name : 'Tidak ada layanan' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
