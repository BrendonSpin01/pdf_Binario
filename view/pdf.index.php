<?php
require_once(__DIR__ . '/../index.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Upload</title>
</head>
<body>

<form id="pdfForm" enctype="multipart/form-data">
    <input type="file" name="pdfFile" accept=".pdf">
    <input type="hidden" name="encryptedPdf" id="encryptedPdf">
    <button type="button" onclick="uploadPDF()">Enviar PDF</button>
</form>
<?php


// Substitua com sua lógica de conexão ao banco de dados
$pdo_principal = conectarAoBancoPrincipal();

try {
    // Preparar a declaração SQL para selecionar id e pdf_b da tabela
    $stmt = $pdo_principal->prepare("SELECT id, pdf_b FROM pdf");
    $stmt->execute();

    // Loop para obter os resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Obter os dados da linha
        $id = $row['id'];
        $pdfBinaryData = $row['pdf_b'];

        // Decodificar o conteúdo binário
        $decodedPdf = base64_decode($pdfBinaryData);

        // Definir cabeçalhos para download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="pdf_' . $id . '.pdf"');

        // Saída do PDF para o navegador
        echo $decodedPdf;
    }
} catch (PDOException $e) {
    // Exibir uma mensagem de erro em caso de falha na consulta
    echo 'Erro durante a consulta: ' . $e->getMessage();
}
?>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function uploadPDF() {
        // Obter o formulário e os dados do arquivo
        var formData = new FormData($('#pdfForm')[0]);

        // Requisição AJAX
        $.ajax({
            url: '../controller/codificar.pdf.php', // Substitua com o caminho para o seu controlador
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Exibir no console se a resposta foi bem-sucedida
                console.log('Upload bem-sucedido!');
                console.log('Resposta do servidor:', response);
            },
            error: function(error) {
                // Exibir no console se houve um erro
                console.error('Erro durante o upload:', error);
            }
        });
    }

    // Adicione esta função para ler o arquivo PDF e criptografá-lo
    function encryptPDF(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // Aqui você deve realizar a criptografia do conteúdo binário do PDF
            // e atribuir o resultado ao campo oculto
            var encryptedData = encryptFunction(e.target.result);
            $('#encryptedPdf').val(encryptedData);
        };

        reader.readAsBinaryString(file);
    }

    // Substitua esta função com a sua lógica de criptografia
    function encryptFunction(data) {
        // Implemente a lógica de criptografia aqui
        // Exemplo: converta a string para base64
        return btoa(data);
    }

    // Adicione um ouvinte de eventos para o campo de arquivo PDF
    $('input[name="pdfFile"]').change(function() {
        var file = this.files[0];
        encryptPDF(file);
    });
</script>


</body>
</html>
