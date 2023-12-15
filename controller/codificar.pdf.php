<?php
require_once(__DIR__ . '/../index.php');

// Substitua com sua lógica de conexão ao banco de dados
$pdo_principal = conectarAoBancoPrincipal();

// Receba os dados do formulário
$encryptedPdf = $_POST['encryptedPdf'];

try {
    // Iniciar uma transação
    $pdo_principal->beginTransaction();

    // Preparar a declaração SQL
    $stmt = $pdo_principal->prepare("INSERT INTO pdf (pdf_b) VALUES (?)");

    // Vincular o parâmetro e executar a declaração
    $stmt->bindParam(1, $encryptedPdf, PDO::PARAM_STR);
    $stmt->execute();

    // Confirmar a transação se tudo estiver bem
    $pdo_principal->commit();

    // Retornar uma resposta de sucesso (pode ser útil para o lado do cliente)
    echo 'Upload bem-sucedido!';
} catch (PDOException $e) {
    // Reverter a transação em caso de erro
    $pdo_principal->rollBack();

    // Exibir uma mensagem de erro
    echo 'Erro durante o upload: ' . $e->getMessage();
}
?>
