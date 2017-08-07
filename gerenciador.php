<?php

include_once 'conexao.php';
include_once '/PHPMailer-master/PHPMailerAutoload.php';
class gerenciador
{

    //verificar email(talvez deletar)
    public function confirmarEmail($email){
        $con = new conexao;
        $con->conectar();
        $log = $con->verificarEmail($email);
        if($log){
            //se achar
            $con->close();
            return true;
            exit();
        }
        $con->close();
        return false;
    }
    //Retorna Infos
    public function buscar($email){
        $con = new conexao;
        $con->conectar();
        $dados=$con->consultar($email);
        if($dados==null){
            //nunca deveria acontecer, mas ne...
            echo 'falha';
            exit();
        }else{
            $resp =$dados->fetch(PDO::FETCH_BOTH);
            return $resp;
        }

    }
    //autorizar login
    public function logar($email,$senha){
        if(isset($email) && isset($senha)) {
            try{
            $con = new conexao;
            $con->conectar();
            $log = $con->verificar($email,$senha);
            }catch (PDOException $exception){
             return $exception->getMessage();
            }
            if($log){
                //autenticacao.php;
                return true;
            }
            $con->close();
            echo 'usuario nao encontrado';
            return false;
        }else{
            echo "Entre com um valor";
            //die("Entre com um valor");
            }
    }
    //cadastra um usuario
    public function cadastrar($nome,$email,$telefone,$endereco,$senha,$hash){
        $con = new conexao;
        $con->conectar();
        if($con->verificarEmail($email)== 1){
            echo "Email em uso";
            return false;
        }else{
            $con->inserir($nome,$email,$telefone,$endereco,$senha,$hash);
            return true;
        }
    }


    //alterar banco
    public function atualizar(){
        $conexao = new conexao();
        $conexao->conectar();
        //não precisa fazer
    }

    //enviar email com confirmação
    public function confirmaValidEmail($email){
        $con = new conexao();
        $con->conectar();
        $dados = $con->consultarValidacao($email);
        if($dados[0]==0){
            return false;
        }else{
            return true;
        }


    }
    //validar email
    public function validaEmail($emailDestino,$nomeDestino,$hash){
        //enviando pelo
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Port = 465;

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure='ssl';//google
        $mail->Username = "teste@gmail.com";//conta do gmail pessoal tbm funciona
        $mail->Password = '';//senha do gmail


        $mail->FromName = 'Teste de autenticacao'; //Nome que será exibido para o destinatário
        $mail->From = 'teste@hotmail.com.br'; //Obrigatório ser a mesma caixa postal configurada no remetente do SMTP
        $mail->AddAddress($emailDestino,$nomeDestino); //Destinatários
        $mail->Subject = 'Verificação de cadastro';
        $mail->Body = 'Obrigado por se cadastrar! 
        Depois de terminar de se cadastrar, basta entrar com o seu email e a senha que foi cadastrada.        
        
        
        Para validar basta clicar no link abaixo:
        http://localhost/Usuarios/autenticacao.php?email='.$emailDestino.'&hash='.$hash.'             
        
        ';
        if(!$mail->Send())
        {
            echo "Message was not sent";
            echo "Mailer Error: " . $mail->ErrorInfo; exit; }
        print "E-mail enviado!";


    }

    public function atualizaFoto($email,$array_foto){
        if($this->confirmarEmail($email)){
            if (!empty($array_foto["name"])) {
                /*returns:
                 * -1 = tipo não suportado
                 *  0 = verificar resolução
                 * 1 = imagem atualizada com sucesso
                 * 2 = erro no banco
                */
                // Verifica se o arquivo é uma imagem
                if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $array_foto["type"])){
                    return -1;
                }else{
                    preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $array_foto["name"], $ext);
                }
                // Gera um nome único para a imagem
                $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

                // Caminho de onde ficará a imagem
                $caminho_imagem = "fotos/" . $nome_imagem;

                // Faz o upload da imagem para seu respectivo caminho
                move_uploaded_file($array_foto["tmp_name"], $caminho_imagem);
                //$dimensoes = getimagesize($array_foto["tmp_name"]);

                //resize na imagem

                $src = imagecreatefromjpeg($caminho_imagem);
                list($width,$heigth)= getimagesize($caminho_imagem);
                $newwidth= 150;
                $newheigth=($heigth/$width)*$newwidth;
                $tmp= imagecreatetruecolor($newwidth,$newheigth);
                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheigth,$width,$heigth);
                imagejpeg($tmp,$caminho_imagem,100);
                imagedestroy($tmp);
                imagedestroy($src);

                // Insere os dados no banco
                $con = new conexao;
                $con->conectar();
                $con->deletaImagem($email,$nome_imagem);
                $resp = $con->colocarImagem($email,$nome_imagem);

                // Se os dados forem inseridos com sucesso
                if ($resp){
                    return 0;
                }else{
                    return 2;
                }

            }
        }



    }

    public function validaHash($email,$hash){
        $con = new conexao();
        $con ->conectar();
        $resp = $con->atualizaHash($email,$hash);
        if($resp==1){
            //se os hash's combinam
            return 1;
        }else{
            //se os hash não combinam
            return 0;
        }

    }

}
