<?php
include('config/conexao.php');
require_once('helpers/upload.php');

if (isset($_POST['movimento_id'])) {
    $movimento_id = intval($_POST['movimento_id']);
    
    // Buscar imagem principal
    $stmt = $conn->prepare("SELECT imagem_principal FROM movimentos WHERE id = ?");
    $stmt->bind_param("i", $movimento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movimento = $result->fetch_assoc();
    $stmt->close();
    
    // Deletar imagem principal
    if ($movimento && $movimento['imagem_principal']) {
        $uploader = new ImageUploader();
        $uploader->deleteImage($movimento['imagem_principal']);
    }
    
    // Buscar e deletar todas as fotos da galeria
    $stmt = $conn->prepare("SELECT foto FROM movimentos_fotos WHERE movimento_id = ?");
    $stmt->bind_param("i", $movimento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $uploader = new ImageUploader();
    while ($foto = $result->fetch_assoc()) {
        $uploader->deleteImage($foto['foto']);
    }
    $stmt->close();
    
    // Deletar movimento (cascade irá deletar as fotos do banco automaticamente)
    $stmt = $conn->prepare("DELETE FROM movimentos WHERE id = ?");
    $stmt->bind_param("i", $movimento_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Movimento removido com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao remover movimento: " . $conn->error . "');</script>";
    }
    
    $stmt->close();
}

$conn->close();
echo "<script>window.location.href='movimentos.php';</script>";
?>
