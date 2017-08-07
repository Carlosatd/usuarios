<?php

    class conexao
    {
        private $host ="localhost";
        private $user = "root";
        private $pass = "";
        private $dbname ="usuarios";
        private $pdo;


        //conectar ao banco de dados
        public function conectar(){
            try{
            $this->pdo = new PDO("mysql:host=localhost;dbname=usuarios",$this->user,$this->pass);
            }catch (PDOException $exception){
                    echo $exception->getMessage();
            }

    }
        //dada uma informacao retorna aconsulta dado certo email
        //ex: buscar o nome dado o email x
        //DEU ERRADO, não estava retornando certo REPENSAR
        public function consultarInfo($email,$informacao){
            $dados = $this->pdo->prepare("SELECT ? FROM cadastrados WHERE email=?");
            $dados->bindValue(1,$informacao);
            $dados->bindValue(2,$email);
            $dados->execute();
            $resp = $dados->fetch(PDO::FETCH_BOTH);
            return $resp;
        }

        public function consultarValidacao($email){
            $dados = $this->pdo->prepare("SELECT validacao FROM cadastrados WHERE email=?");
            $dados->bindValue(1,$email);
            $dados->execute();
            $resp = $dados->fetch(PDO::FETCH_BOTH);
            return $resp;
        }



        //dado um email retorne toda a linha da tabela
        public function consultar($email){
            try {
                $dados = $this->pdo->prepare("SELECT * FROM cadastrados WHERE email=?");
                $dados->bindValue(1,$email);
                $dados->execute();
                return $dados;

            }catch (PDOException $exception){
                return null;
            }
        }

        public function atualizaHash($email, $hash){
            $dados = $this->pdo->prepare("SELECT hash FROM cadastrados WHERE email=?");
            $dados->bindValue(1,$email);
            $dados->execute();
            $resp = $dados->fetch(PDO::FETCH_BOTH);
            if(strcmp($hash, $resp['hash'])==0){
                $validar = $this->pdo->prepare("UPDATE cadastrados SET validacao=? WHERE email=?");
                $validar->bindValue(1,1);
                $validar->bindValue(2,$email);
                $validar->execute();
                //hash igual
                return 1;
            }else{
                return 0;
            }
        }

        //verifica se o email ja esta em uso
        public function verificarEmail($email){
            $dados = $this->pdo->prepare("SELECT * FROM cadastrados WHERE email=?");
            $dados->bindValue(1,$email);
            $dados->execute();
            $resp = $dados->rowCount();
            if($resp==0){
                //email não encontrado
                return 0;
            }else{
                //email encontrado
                return 1;
            }
        }


        //Verifica se possui foto
        public function verificarFoto($email){
            $dados = $this->pdo->prepare("SELECT foto FROM cadastrados WHERE email=?");
            $dados->bindValue(1,$email);
            $dados->execute();
            $resp = $dados->rowCount();
            if($resp==0){
                //email não encontrado
                return 0;
            }else{
                //email encontrado
                return 1;
            }
        }

        //duplicado, deletar depois
        public function verificarImagem($email)
        {
            try {
            $dados = $this->pdo->prepare("SELECT foto FROM cadastrados WHERE email=?");
            $dados->bindValue(1, $email);
            $dados->execute();
            $resp = $dados->fetch(PDO::FETCH_BOTH);
            if (is_null($resp['foto'])) {
                //Imagem nula
                return 0;
            } else {
                //Possui imagem
                return 1;
            }
            }catch (PDOException $exception){
                return 2;
            }
        }

        //verifica se a combinacao usuario e senha existe
        //NOTA: campo senha sempre criptografado
        public function verificar($email, $senha){
            $cript = $this->encriptar($senha);
            $dados = $this->pdo->prepare("SELECT* FROM cadastrados WHERE email=? and senha=?");
            $dados->bindValue(1,$email);
            $dados->bindValue(2,$cript);
            $dados->execute();
            $resp = $dados->rowCount();
            if($resp==0){
                //echo "combinacao Usuario/senha nao encontrada";
                return 0;
            }else{
                //echo "Logando";
                return 1;
            }
            //erro
            return 2;
        }

        public function close(){
            unset($this->pdo);
        }
        //encripta usando um hash
        public function encriptar($dado){
            //usaremos sha1 na falta de sha 256 retornando como binario
            $criptoDado = hash('sha512',$dado);
            return $criptoDado;
        }

        //insere no banco
        public function inserir($nome,$email,$telefone,$endereço,$senha,$hash){
            try {
                //recolocar o script
                $cript = $this->encriptar($senha);
                $insert = $this->pdo->prepare("INSERT INTO cadastrados(nome, email, telefone, endereco, senha, hash) VALUES (?,?,?,?,?,?)");
                //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $insert->bindValue(1,$nome);
                $insert->bindValue(2,$email);
                $insert->bindValue(3,$telefone);
                $insert->bindValue(4,$endereço);
                $insert->bindValue(5, $cript);
                $insert->bindValue(6,$hash);

                //$insertPass = $this->prepare("INSERT into pass()");
                $resp = $insert->execute();
                return $resp;
            }catch (PDOException $exp){
                echo "Erro no cadastro";
                echo $exp;
                return false;

            }
            echo "Usuario cadastrado com sucesso";
            return true;


        }


    //insere a imagem no banco
    public function colocarImagem($email,$nome_imagem){
        $update = $this->pdo->prepare("UPDATE cadastrados SET foto=? WHERE email=?");
        $update->bindValue(1,$nome_imagem);
        $update->bindValue(2,$email);
        $resp = $update->execute();
        if($resp){
            return 1;
        }else{
            //caso não consiga inserir
            return 0;
        }

    }
    //coloca o campo foto como null e deleta a antiga(caso tenha)
    public function deletaImagem($email,$nome_imagem){
        // Selecionando nome da foto do usuário
        $busca = $this->pdo->prepare("SELECT nome,foto FROM cadastrados WHERE email=?");
        $busca->bindValue(1,$email);
        $busca->execute();
        $resp = $busca->fetch(PDO::FETCH_BOTH);
        if(is_null($resp['foto'])){
            //deletado com sucesso
            return 1;
        }
        // Colocando NULL no campo foto
        $delete = $this->pdo->prepare("UPDATE cadastrados SET foto=? WHERE email=?");
        $delete->bindValue(1,NULL);
        $delete->bindValue(2,$email);
        $delete->execute();

        // Removendo imagem da pasta fotos/
        unlink("fotos/".$resp['foto']."");
        return 1;

    }


    }

?>