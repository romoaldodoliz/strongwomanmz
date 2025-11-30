<?php
include('header.php');
include('config/conexao.php');
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Noticias</span>
                            <h3 class="card-title mb-2">
                                <?php
                                    $sql = 'SELECT COUNT(*) as total FROM eventos';
                                    $result = $conn->query($sql);
                                    $row = $result->fetch_assoc();
                                    echo $row['total'];
                                    // Fechar a conexão
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Causas</span>
                            <h3 class="card-title mb-2">85</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Areas de intervencao</span>
                            <h3 class="card-title mb-2">
                                <?php
                                    $sql3 = 'SELECT COUNT(*) as total3 FROM areas';
                                    $result3 = $conn->query($sql3);
                                    $row3 = $result3->fetch_assoc();
                                    echo $row3['total3'];
                                    // Fechar a conexão
                                    $conn->close();
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <?php include('footerprincipal.php'); ?>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
<?php
include('footer.php');
?>