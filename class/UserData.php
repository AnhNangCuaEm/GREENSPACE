<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';

class UserData
{

    public static function getUser(): ?User
    {
        $pdo = Database::getConnection();

        $state = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $state->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
        $state->execute();

        $row = $state->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password_hash'],
            $row['name'],
            $row['phone'],
            $row['avatar'],
            $row['address']
        );
    }

    public static function createUser(User $user): void
    {
        if (empty($user->email) || empty($user->password)) {
            throw new InvalidArgumentException('User properties must be initialized.');
        }

        $pdo = Database::getConnection();

        $state = $pdo->prepare('INSERT INTO user (email, password_hash, name, phone, avatar, address) VALUES (:email, :password_hash, :name, :phone, :avatar, :address)');
        $state->bindValue(':email', $user->email, PDO::PARAM_STR);
        $state->bindValue(':password_hash', password_hash($user->password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $state->bindValue(':name', $user->name, PDO::PARAM_STR);
        $state->bindValue(':phone', $user->phone, PDO::PARAM_STR);
        $user->avatar = '/GREENSPACE/img/avatar/panda.png';
        $state->bindValue(':avatar', $user->avatar, PDO::PARAM_STR);
        $state->bindValue(':address', $user->address, PDO::PARAM_STR);
        $state->execute();
    }
}
