<?php
include('header.php');
include('config/conexao.php');
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Eventos</h4>
        <div class="" style="padding-bottom: 10px;">
            <a class='btn btn-dark' href="eventosform.php">Adicionar eventos</a>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Foto</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Acção</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $sql = "SELECT * FROM eventos";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['foto']) . "' width='100' height='100' /></td>";
                                echo "<td>" . $row["descricao"] . "</td>";
                                echo "<td>" . $row["data"] . "</td>";
                                echo "<td>";
                                echo "<form method='POST' action='remover_evento.php'>";
                                echo "<input type='hidden' name='evento_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='remover'>Remover</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum resultado encontrado.</td></tr>";
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