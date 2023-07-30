<?php
// Obter os dados do formulário de cadastro
$email = $_POST['email'];
$senha = $_POST['senha'];
$nome_empresa = $_POST['nome_empresa'];
$nome_dono = $_POST['nome_dono'];
$cpf_dono = $_POST['cpf_dono'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];

// Conexão com o banco de dados (substitua pelas suas credenciais)
$servername = "mafcdevdb.mysql.database.azure.com";
$username = "MAFCadmin";
$password = "@Alfacar2240-";
$dbname = "bancodevempresas";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Iniciar a transação
$conn->begin_transaction();

try {
    // Inserir os dados na tabela de login
    $sql_login = "INSERT INTO f_empresas_login (EMAIL, SENHA) VALUES ('$email', '$senha')";
    $conn->query($sql_login);

    // Obter o ID_EMPRESA gerado na tabela de login
    $id_empresa = $conn->insert_id;

    // Inserir os dados na tabela de cadastro usando o mesmo ID_EMPRESA
    $sql_cadastro = "INSERT INTO f_empresas_cadastro (ID_EMPRESA, NOME_EMPRESA, NOME_DONO, CPF_DONO, CEP, RUA, NUMERO, CIDADE, UF, CNPJ, TELEFONE) 
                     VALUES ('$id_empresa', '$nome_empresa', '$nome_dono', '$cpf_dono', '$cep', '$rua', '$numero', '$cidade', '$uf', '$cnpj', '$telefone')";
    $conn->query($sql_cadastro);

    // Confirmar a transação
    $conn->commit();
    echo "Cadastro realizado com sucesso!";
} catch (Exception $e) {
    // Em caso de erro, desfazer a transação (rollback)
    $conn->rollback();
    echo "Erro ao cadastrar: " . $e->getMessage();
}

$conn->close();
?>
