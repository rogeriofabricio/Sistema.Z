<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf8">
        <title>Contato</title>
    </head>
    <body>
        <form action="mail_send.php" method="post">
            <fieldset>
                <label for="email">E-mail: </label>
                <input required name="email" type="email">
            </fieldset>
            <fieldset>
                <label for="mensagem">Mensagem: </label>
                <textarea required name="mensagem"></textarea>
            </fieldset>
            <fieldset>
                <button type="submit">Enviar</button>
            </fieldset>
        </form>
    </body>
</html>


<!-- mail_ok.php -->
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf8">
        <title>Sucesso</title>
    </head>
    <body>
        <h1>Sucesso</h1>
        
        <hr>
        
        <p>O e-mail foi enviado com sucesso.</p>
    </body>
</html>

<!-- mail_error.php -->
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf8">
        <title>Erro</title>
    </head>
    <body>
        <h1>Erro</h1>
        
        <hr>
        
        <p>Houve um erro no envio do e-mail. <a href="index.php">Tentar novamente</a>.</p>
    </body>
</html>

<!-- mail_send.php -->
<?php

function pegaValor($valor) {
    return isset($_POST[$valor]) ? $_POST[$valor] : '';
}

function validaEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function enviaEmail($de, $assunto, $mensagem, $para, $email_servidor) {
    $headers = "From: $email_servidor\r\n" .
               "Reply-To: $de\r\n" .
               "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  
  mail($para, $assunto, nl2br($mensagem), $headers);
}

$email_servidor = "email@servidor.com";
$para = "seu@email.com";
$de = pegaValor("email");
$mensagem = pegaValor("mensagem");
$assunto = "Assunto da mensagem";

?>

<!-- corpo script -->
if ($nome && validaEmail($de) && $mensagem) {
    enviaEmail($de, $assunto, $mensagem, $para, $email_servidor);
    $pagina = "mail_ok.php";
} else {
    $pagina = "mail_error.php";
}

header("location:$pagina");