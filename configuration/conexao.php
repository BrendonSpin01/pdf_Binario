<?php
function conectarAoBancoPrincipal() {
    $host_principal = getenv('BATATA'); // Servidor
    $dbname_principal = getenv('PDFB'); // Nome do Banco
    $username_principal = getenv('PDF'); // Usuário
    $password_principal = getenv('PDFS'); // Senha

    try {
        $pdo_principal = new PDO("mysql:host=$host_principal;dbname=$dbname_principal", $username_principal, $password_principal);
        return $pdo_principal;
    } catch (PDOException $e) {
        echo 'Erro na conexão com o banco de dados principal: ' . $e->getMessage();
        exit();
    }
}

// Chamando a função para obter a conexão
// $pdo_principal = conectarAoBancoPrincipal();

// Agora você pode usar $pdo_principal para realizar consultas no banco de dados.
// Por exemplo:
// $stmt = $pdo_principal->query('SELECT * FROM sua_tabela');
// while ($row = $stmt->fetch()) {
//    // Faça algo com os dados
// }
?>
