<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div id="navbar-placeholder"></div>

    <div class="container-fluid">
        <div class="row">
            <div id="sidebar-placeholder"></div>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Visualisasi Dashboard</h2>
                </div>

                <!-- Timeline -->
                <div class="timeline">
                    <?php foreach ($tanggungan as $item): ?>
                        <div class="timeline-item">
                            <div class="timeline-icon bg-jtiyellow text-white">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5><?= htmlspecialchars($item['nama_berkas']); ?></h5>
                            <p>Status: <?= htmlspecialchars($item['status']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Card Tanggungan -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                List Tanggungan
                            </div>
                            <div class="card-body">
                                <ul>
                                    <?php foreach ($tanggungan as $item): ?>
                                        <li><?= htmlspecialchars($item['nama_berkas']); ?> - <?= htmlspecialchars($item['status']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.php");
        });
    </script>
</body>

</html>
