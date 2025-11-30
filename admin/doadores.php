<?php
include('header.php');
include('config/conexao.php');

// Processar ações (aprovar/rejeitar)
if (isset($_POST['action']) && isset($_POST['doador_id'])) {
    $doador_id = intval($_POST['doador_id']);
    $action = $_POST['action'];
    
    if ($action == 'aprovar') {
        $stmt = $conn->prepare("UPDATE doadores SET status = 'confirmado' WHERE id = ?");
    } else if ($action == 'rejeitar') {
        $stmt = $conn->prepare("UPDATE doadores SET status = 'rejeitado' WHERE id = ?");
    }
    
    if (isset($stmt)) {
        $stmt->bind_param("i", $doador_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Filtros
$where = [];
$params = [];
$types = '';

if (isset($_GET['status']) && $_GET['status'] != '') {
    $where[] = "status = ?";
    $params[] = $_GET['status'];
    $types .= 's';
}

if (isset($_GET['metodo']) && $_GET['metodo'] != '') {
    $where[] = "metodo_pagamento = ?";
    $params[] = $_GET['metodo'];
    $types .= 's';
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar doadores
$sql = "SELECT * FROM doadores $where_clause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Estatísticas
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'confirmado' THEN valor ELSE 0 END) as total_confirmado,
    SUM(CASE WHEN status = 'pendente' THEN 1 ELSE 0 END) as pendentes
    FROM doadores";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Doações /</span> Lista de Doadores
        </h4>

        <!-- Estatísticas -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">Total de Doações</h6>
                                <h3 class="mb-0"><?php echo $stats['total']; ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="bx bx-donate-heart bx-lg"></i>
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
                                <h6 class="card-title mb-1">Valor Confirmado</h6>
                                <h3 class="mb-0"><?php echo number_format($stats['total_confirmado'], 2); ?> MT</h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded">
                                    <i class="bx bx-money bx-lg"></i>
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
                                <h6 class="card-title mb-1">Pendentes</h6>
                                <h3 class="mb-0"><?php echo $stats['pendentes']; ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded">
                                    <i class="bx bx-time bx-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Todos</option>
                                <option value="pendente" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                <option value="confirmado" <?php echo (isset($_GET['status']) && $_GET['status'] == 'confirmado') ? 'selected' : ''; ?>>Confirmado</option>
                                <option value="rejeitado" <?php echo (isset($_GET['status']) && $_GET['status'] == 'rejeitado') ? 'selected' : ''; ?>>Rejeitado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Método de Pagamento</label>
                            <select name="metodo" class="form-select">
                                <option value="">Todos</option>
                                <option value="banco" <?php echo (isset($_GET['metodo']) && $_GET['metodo'] == 'banco') ? 'selected' : ''; ?>>Banco</option>
                                <option value="mpesa" <?php echo (isset($_GET['metodo']) && $_GET['metodo'] == 'mpesa') ? 'selected' : ''; ?>>M-Pesa</option>
                                <option value="emola" <?php echo (isset($_GET['metodo']) && $_GET['metodo'] == 'emola') ? 'selected' : ''; ?>>e-Mola</option>
                                <option value="paypal" <?php echo (isset($_GET['metodo']) && $_GET['metodo'] == 'paypal') ? 'selected' : ''; ?>>PayPal</option>
                                <option value="outro" <?php echo (isset($_GET['metodo']) && $_GET['metodo'] == 'outro') ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-filter"></i> Filtrar
                            </button>
                            <a href="doadores.php" class="btn btn-secondary">
                                <i class="bx bx-reset"></i> Limpar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela de Doadores -->
        <div class="card">
            <h5 class="card-header">Doadores Registrados</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Valor</th>
                            <th>Método</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $status_badge = [
                                    'pendente' => 'bg-warning',
                                    'confirmado' => 'bg-success',
                                    'rejeitado' => 'bg-danger'
                                ];
                                
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td><strong>" . htmlspecialchars($row['nome']) . "</strong></td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                                echo "<td><strong>" . number_format($row['valor'], 2) . " MT</strong></td>";
                                echo "<td><span class='badge bg-label-info'>" . strtoupper($row['metodo_pagamento']) . "</span></td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['data_doacao'])) . "</td>";
                                echo "<td><span class='badge " . $status_badge[$row['status']] . "'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td>";
                                echo "<div class='dropdown'>";
                                echo "<button type='button' class='btn btn-sm btn-outline-primary dropdown-toggle' data-bs-toggle='dropdown'>Ações</button>";
                                echo "<div class='dropdown-menu'>";
                                
                                if ($row['status'] == 'pendente') {
                                    echo "<form method='POST' action='' class='d-inline'>";
                                    echo "<input type='hidden' name='doador_id' value='" . $row['id'] . "'>";
                                    echo "<input type='hidden' name='action' value='aprovar'>";
                                    echo "<button type='submit' class='dropdown-item'><i class='bx bx-check'></i> Aprovar</button>";
                                    echo "</form>";
                                    
                                    echo "<form method='POST' action='' class='d-inline'>";
                                    echo "<input type='hidden' name='doador_id' value='" . $row['id'] . "'>";
                                    echo "<input type='hidden' name='action' value='rejeitar'>";
                                    echo "<button type='submit' class='dropdown-item'><i class='bx bx-x'></i> Rejeitar</button>";
                                    echo "</form>";
                                }
                                
                                if ($row['comprovativo']) {
                                    echo "<a href='../" . $row['comprovativo'] . "' target='_blank' class='dropdown-item'><i class='bx bx-file'></i> Ver Comprovativo</a>";
                                }
                                
                                echo "<form method='POST' action='remover_doador.php' class='d-inline'>";
                                echo "<input type='hidden' name='doador_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='dropdown-item text-danger' onclick='return confirm(\"Tem certeza que deseja remover este doador?\")'><i class='bx bx-trash'></i> Remover</button>";
                                echo "</form>";
                                
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>Nenhum doador encontrado.</td></tr>";
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
