<?php

require_once __DIR__ . '/../class/Database.php';

function createToken(string $email): void {
    $token = bin2hex(random_bytes(16)); //Generate random token
    $pdo = Database::getConnection();

    //Add token to login_tokens table
    $state = $pdo->prepare('INSERT INTO login_tokens (email, token) VALUES (:email, :token)');
    $state->bindValue(':email', $email, PDO::PARAM_STR);
    $state->bindValue(':token', $token, PDO::PARAM_STR);
    $state->execute();

    //Save token to cookie (7 days)
    setcookie('login_token', $token, time() + 604800, '/', '', false, true);
}

function verifyToken(): ?string {
    if (!isset($_COOKIE['login_token'])) {
        return null; //Cookie does not exist
    }

    $token = $_COOKIE['login_token'];
    $pdo = Database::getConnection();

    //Check token in login_tokens table
    $state = $pdo->prepare('SELECT email FROM login_tokens WHERE token = :token');
    $state->bindValue(':token', $token, PDO::PARAM_STR);
    $state->execute();

    $result = $state->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['email']; //Return email if token is valid
    }

    return null; //Token is invalid
}

function logout(): void {
    if (isset($_COOKIE['login_token'])) {
        $pdo = Database::getConnection();
        $state = $pdo->prepare('DELETE FROM login_tokens WHERE token = :token');
        $state->bindValue(':token', $_COOKIE['login_token'], PDO::PARAM_STR);
        $state->execute();

        //Delete cookie
        setcookie('login_token', '', time() - 3600, '/', '', true, true);
    }

    header('Location: login.php'); //Redirect to login page
    exit();
}


