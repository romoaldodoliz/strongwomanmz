<?php
include('header.php');
include('config/conexao.php');
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Missão, Visão e Valores</h4>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Missao</th>
                            <th>Valores</th>
                            <th>Visao</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        // Consulta SELECT
                        $sql = "SELECT * FROM config";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                // Limitar a exibição dos primeiros 5 caracteres
                                echo "<td>" . substr($row["missao"], 0, 50) . "..." . "</td>";
                                echo "<td>" . substr($row["valores"], 0, 50) . "..." . "</td>";
                                echo "<td>" . substr($row["visao"], 0, 50) . "..." . "</td>";
                                echo "<td><a class='btn btn-dark' href='configform.php?id=" . $row["id"] ."'>atualizar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum resultado encontrado.</td></tr>";
                        }
                        // Fechar a conexão
                        $conn->close();
                        ?>
                    </tbody>
                </table>
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