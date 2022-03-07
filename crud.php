<?php

require_once('./connection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <title>Document</title>
</head>

<body>
    <h1>Cadastro de Aluno</h1>

    <h2>Inserção de aluno</h2>

    <?php

    function create($aluno) #Ínicio função Create#
    {

        try {

            $con = getConnection();
            #Insert something

            $stmt = $con->prepare("INSERT INTO alunos(nome, email) VALUES (:nome , :email)");

            $stmt->bindParam(":nome", $aluno->nome);
            $stmt->bindParam(":email", $aluno->email);

            if ($stmt->execute()) {
                echo " Aluno Cadastrado com sucesso";
            }
        } catch (PDOException $error) {
            echo "Error ao cadastrar o aluno. Error: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }
    ?>

    <?php
    #Área de teste#

    #create test - 
    $aluno = new stdClass();
    $aluno->nome = "Rock";
    $aluno->email = "rock@gmail.com";
    create($aluno);

    echo "<br><br>---<br><br>";
    ?>

    <h2>Listar Alunos</h2>

    <?php

    function get() #Ínicio Função Get#
    {
        try {
            $con = getConnection();

            $rs = $con->query("SELECT nome, email FROM alunos");

            while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                echo "Nome: " . $row->nome . " <br> Email: ";
                echo $row->email . "<br><br>";
            }
        } catch (PDOException $error) {
            echo "Erro ao listar as cidades. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($rs);
        }
    }

    ?>

    <?php
    #get test
    get();


    ?>

    <h2>Busca de Aluno</h2>

    <?php #Ínicio função Find#

    function find($nome)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("SELECT nome, email FROM alunos WHERE nome LIKE :nome");

            $stmt->bindValue(":nome", "%{$nome}%");

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "Nome: " . $row->nome . " <br> Email: ";
                        echo $row->email . "<br><br>";
                    }
                }
            }
        } catch (PDOException $error) {
            echo "Erro ao buscar ao aluno '{$nome}'. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }
    ?>

    <?php

    #teste do find
    find("Maria");

    ?>

    <h2>Atualizar dados</h2>

    <?php

    function update($aluno)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("UPDATE alunos SET nome= :nome, email = :email WHERE id = :id");

            $stmt->bindParam(":id", $aluno->id);
            $stmt->bindParam(":nome", $aluno->nome);
            $stmt->bindParam(":email", $aluno->email);
            if ($stmt->execute())
                echo "Aluno atualizado com sucesso";
        } catch (PDOException $error) {
            echo "Erro ao atualizar o aluno. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }

    ?>

    <?php

    #teste upgrade - Retirado aluno Letícia Diogo e incluído Sergio Rodrigues
    $aluno = new stdClass();
    $aluno->nome = "Carlos";
    $aluno->email = "carlos@gmail.com";
    $aluno->id = 1;
    update($aluno);

    echo "<br><br>";

    ?>

    <h2>Deletar aluno</h2>

    <?php # Função deletar

    function delete($id)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("DELETE FROM alunos WHERE id = ?");
            $stmt->bindParam(1, $id);

            if ($stmt->execute())
                echo "Aluno deletado com sucesso";
        } catch (PDOException $error) {
            echo "Erro ao deletar aluno. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }


    ?>

    <?php

    #delete test
    echo "<br>";
    delete(1); #deletado aluno Sergio Rodrigues, sergio@gmail.com
    echo "<br><br>";
    echo "<br>-----<br>";
    get();

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>