<?php
include('header.php');
include('config/conexao.php');
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Blog /</span> Nossos Movimentos
        </h4>
        
        <div class="mb-4">
            <a class='btn btn-primary' href="movimentosform.php">
                <i class="bx bx-plus"></i> Adicionar Novo Movimento
            </a>
        </div>

        <!-- Estatísticas -->
        <?php
        $stats_sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'publicado' THEN 1 ELSE 0 END) as publicados,
            SUM(CASE WHEN status = 'rascunho' THEN 1 ELSE 0 END) as rascunhos
            FROM movimentos";
        $stats_result = $conn->query($stats_sql);
        $stats = $stats_result->fetch_assoc();
        ?>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">Total</h6>
                                <h3 class="mb-0"><?php echo $stats['total']; ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="bx bx-news bx-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">Publicados</h6>
                                <h3 class="mb-0"><?php echo $stats['publicados']; ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">Rascunhos</h6>
                                <h3 class="mb-0"><?php echo $stats['rascunhos']; ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded">
                                    <i class="bx bx-edit bx-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Lista de Movimentos</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Tema</th>
                            <th>Data do Evento</th>
                            <th>Local</th>
                            <th>Status</th>
                            <th>Fotos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $sql = "SELECT m.*, 
                                (SELECT COUNT(*) FROM movimentos_fotos WHERE movimento_id = m.id) as total_fotos 
                                FROM movimentos m 
                                ORDER BY m.created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $status_badge = [
                                    'publicado' => 'bg-success',
                                    'rascunho' => 'bg-warning',
                                    'arquivado' => 'bg-secondary'
                                ];
                                
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                
                                // Imagem
                                if ($row['imagem_principal']) {
                                    echo "<td><img src='../" . htmlspecialchars($row['imagem_principal']) . "' width='80' height='80' style='object-fit: cover; border-radius: 8px;' /></td>";
                                } else {
                                    echo "<td><div style='width:80px;height:80px;background:#eee;border-radius:8px;display:flex;align-items:center;justify-content:center;'><i class='bx bx-image'></i></div></td>";
                                }
                                
                                echo "<td><strong>" . htmlspecialchars($row['titulo']) . "</strong></td>";
                                echo "<td>" . htmlspecialchars($row['tema'] ?? '-') . "</td>";
                                echo "<td>" . ($row['data_evento'] ? date('d/m/Y', strtotime($row['data_evento'])) : '-') . "</td>";
                                echo "<td>" . htmlspecialchars($row['local'] ?? '-') . "</td>";
                                echo "<td><span class='badge " . $status_badge[$row['status']] . "'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td><span class='badge bg-label-info'>" . $row['total_fotos'] . " fotos</span></td>";
                                echo "<td>";
                                echo "<div class='dropdown'>";
                                echo "<button type='button' class='btn btn-sm btn-outline-primary dropdown-toggle' data-bs-toggle='dropdown'>Ações</button>";
                                echo "<div class='dropdown-menu'>";
                                echo "<a href='movimentosform.php?id=" . $row['id'] . "' class='dropdown-item'><i class='bx bx-edit'></i> Editar</a>";
                                echo "<a href='../movimento-detalhes.php?id=" . $row['id'] . "' target='_blank' class='dropdown-item'><i class='bx bx-show'></i> Ver no Site</a>";
                                echo "<form method='POST' action='remover_movimento.php' class='d-inline'>";
                                echo "<input type='hidden' name='movimento_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='dropdown-item text-danger' onclick='return confirm(\"Tem certeza que deseja remover este movimento e todas as suas fotos?\")'><i class='bx bx-trash'></i> Remover</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>Nenhum movimento encontrado.</td></tr>";
                        }
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
$conn->close();
?>
