<?php
/**
 * Helper de Upload de Imagens
 * Funções seguras para upload, validação e redimensionamento
 */

class ImageUploader {
    
    private $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    private $max_size = 5242880; // 5MB
    
    /**
     * Upload de imagem com validação e redimensionamento
     * 
     * @param array $file $_FILES['campo']
     * @param string $directory Diretório de destino (ex: 'eventos')
     * @param int $max_width Largura máxima
     * @param int $max_height Altura máxima
     * @return array ['success' => bool, 'message' => string, 'path' => string]
     */
    public function uploadImage($file, $directory, $max_width = 1200, $max_height = 1200) {
        // Verificar se há arquivo
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['success' => false, 'message' => 'Nenhum arquivo foi enviado.'];
        }
        
        // Verificar erros no upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Erro no upload do arquivo.'];
        }
        
        // Validar tipo de arquivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime_type, $this->allowed_types)) {
            return ['success' => false, 'message' => 'Tipo de arquivo não permitido. Apenas imagens são aceitas.'];
        }
        
        // Validar tamanho
        if ($file['size'] > $this->max_size) {
            return ['success' => false, 'message' => 'Arquivo muito grande. Tamanho máximo: 5MB.'];
        }
        
        // Criar nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        
        // Caminho completo
        $base_path = $_SERVER['DOCUMENT_ROOT'] . '/strongwoman/uploads/' . $directory . '/';
        $full_path = $base_path . $filename;
        $relative_path = 'uploads/' . $directory . '/' . $filename;
        
        // Criar diretório se não existir
        if (!is_dir($base_path)) {
            mkdir($base_path, 0755, true);
        }
        
        // Redimensionar e salvar
        if ($this->resizeImage($file['tmp_name'], $full_path, $max_width, $max_height, $mime_type)) {
            return [
                'success' => true,
                'message' => 'Upload realizado com sucesso.',
                'path' => $relative_path,
                'filename' => $filename
            ];
        } else {
            return ['success' => false, 'message' => 'Erro ao processar a imagem.'];
        }
    }
    
    /**
     * Redimensiona imagem mantendo proporção
     */
    private function resizeImage($source, $destination, $max_width, $max_height, $mime_type) {
        // Obter dimensões originais
        list($orig_width, $orig_height) = getimagesize($source);
        
        // Calcular novas dimensões mantendo proporção
        $ratio = min($max_width / $orig_width, $max_height / $orig_height);
        
        // Se imagem já é menor, não redimensionar
        if ($ratio >= 1) {
            return move_uploaded_file($source, $destination);
        }
        
        $new_width = intval($orig_width * $ratio);
        $new_height = intval($orig_height * $ratio);
        
        // Criar imagem a partir do tipo
        switch ($mime_type) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }
        
        if (!$image) {
            return false;
        }
        
        // Criar nova imagem redimensionada
        $new_image = imagecreatetruecolor($new_width, $new_height);
        
        // Preservar transparência para PNG e GIF
        if ($mime_type == 'image/png' || $mime_type == 'image/gif') {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $new_width, $new_height, $transparent);
        }
        
        // Redimensionar
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
        
        // Salvar
        $result = false;
        switch ($mime_type) {
            case 'image/jpeg':
            case 'image/jpg':
                $result = imagejpeg($new_image, $destination, 85);
                break;
            case 'image/png':
                $result = imagepng($new_image, $destination, 8);
                break;
            case 'image/gif':
                $result = imagegif($new_image, $destination);
                break;
            case 'image/webp':
                $result = imagewebp($new_image, $destination, 85);
                break;
        }
        
        // Limpar memória
        imagedestroy($image);
        imagedestroy($new_image);
        
        return $result;
    }
    
    /**
     * Delete arquivo de imagem
     */
    public function deleteImage($path) {
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/strongwoman/' . $path;
        if (file_exists($full_path)) {
            return unlink($full_path);
        }
        return false;
    }
    
    /**
     * Upload múltiplo de imagens
     */
    public function uploadMultiple($files, $directory, $max_width = 1200, $max_height = 1200) {
        $results = [];
        
        // Reorganizar array de arquivos múltiplos
        $file_array = [];
        foreach ($files as $key => $values) {
            foreach ($values as $index => $value) {
                $file_array[$index][$key] = $value;
            }
        }
        
        foreach ($file_array as $file) {
            $results[] = $this->uploadImage($file, $directory, $max_width, $max_height);
        }
        
        return $results;
    }
}

/**
 * Sanitiza string para evitar XSS
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Valida email
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Gera token CSRF
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida token CSRF
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
