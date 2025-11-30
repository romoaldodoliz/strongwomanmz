<?php
include('header.php');
include('config/conexao.php');
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Galeria</h4>
        <div class="row">
             <div class="col-md-6 mr-auto" style="padding-bottom: 10px;">
                <a class="btn btn-dark w-50" href="galeriaform.php">Adicionar imagem</a>
            </div>
            
            <div class="col-md-6" style="padding-bottom: 10px;">
                <a class="btn btn-dark float-right w-50" href="galeriavform.php">Adicionar video</a>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titulo</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        // Consulta SELECT
                        $sql = "SELECT * FROM galeria";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["titulo"] . "</td>";
                                echo "<td>" . $row["link"] . "</td>";
                                echo "<td>";
                                echo "<form method='POST' action='remover_galeria.php'>";
                                  echo "<input type='hidden' name='galeria_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='remover'>Remover</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum resultado encontrado.</td></tr>";
                        }

                        // Fechar a conex達o
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