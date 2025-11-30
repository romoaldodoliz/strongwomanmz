<?php
include('config/conexao.php');
require_once('helpers/upload.php');

if (isset($_POST['doador_id'])) {
    $doador_id = intval($_POST['doador_id']);
    
    // Buscar comprovativo para deletar arquivo
    $stmt = $conn->prepare("SELECT comprovativo FROM doadores WHERE id = ?");
    $stmt->bind_param("i", $doador_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doador = $result->fetch_assoc();
    $stmt->close();
    
    // Deletar arquivo de comprovativo se existir
    if ($doador && $doador['comprovativo']) {
        $uploader = new ImageUploader();
        $uploader->deleteImage($doador['comprovativo']);
    }
    
    // Deletar doador do banco
    $stmt = $conn->prepare("DELETE FROM doadores WHERE id = ?");
    $stmt->bind_param("i", $doador_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Doador removido com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao remover doador: " . $conn->error . "');</script>";
    }
    
    $stmt->close();
}

$conn->close();
echo "<script>window.location.href='doadores.php';</script>";
?>
