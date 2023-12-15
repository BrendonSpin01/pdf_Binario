<?php
require_once(__DIR__ . '/../index.php');

// Substitua com sua lógica de conexão ao banco de dados
$pdo_principal = conectarAoBancoPrincipal();

// Verificar se o ID do PDF está presente na URL
if (isset($_GET['pdf_id'])) {
    try {
        // Preparar a declaração SQL para selecionar pdf_b do ID especificado
        $stmt = $pdo_principal->prepare("SELECT pdf_b FROM pdf WHERE id = ?");
        $stmt->bindParam(1, $_GET['pdf_id'], PDO::PARAM_INT);
        $stmt->execute();

        // Obter o resultado
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Decodificar o conteúdo binário
            $decodedPdf = base64_decode($row['pdf_b']);

            // Definir cabeçalhos para download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="pdf_' . $_GET['pdf_id'] . '.pdf"');

            // Saída do PDF para o navegador
            echo $decodedPdf;
        } else {
            echo 'PDF não encontrado.';
        }
    } catch (PDOException $e) {
        // Exibir uma mensagem de erro em caso de falha na consulta
        echo 'Erro durante a consulta: ' . $e->getMessage();
    }
} else {
    echo 'ID do PDF não fornecido.';
}
?>
