<?php
    include_once("../conexao.php");

    //verificar se foi setado algum valor para a exclusao
    if(isset($_GET["idTurma"])){
        $idTurma = $_GET["idTurma"];
        $sql = "DELETE FROM Aula WHERE Turma_idTurma = $idTurma";

        if($conn->query($sql)== TRUE){
            ?>
                <script>
                    window.location= "../tela_listar/horarios.php?resposta=5"
                </script>
            <?php
        }
        else{
            ?>
                <script>
                    window.location= "../tela_listar/horarios.php?resposta=6"
                </script>
            <?php
        }
    }

?>