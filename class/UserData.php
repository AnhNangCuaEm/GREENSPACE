<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';

if (!class_exists('UserData')) {
    class UserData
    {

        public static function getUser(string $email): ?User
        {
            $pdo = Database::getConnection();

            $state = $pdo->prepare('SELECT * FROM user WHERE email = :email');
            $state->bindValue(':email', $email, PDO::PARAM_STR);
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
                $row['address'],
                $row['role'],
                $row['status']
            );
        }

        public static function getProfile(): ?User
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
                $row['address'],
                $row['role'],
                $row['status']
            );
        }

        public static function createUser(User $user): void
        {
            if (empty($user->email) || empty($user->password)) {
                throw new InvalidArgumentException('User properties must be initialized.');
            }

            $pdo = Database::getConnection();

            $state = $pdo->prepare('INSERT INTO user (email, password_hash, name, phone, avatar, address, role, status) VALUES (:email, :password_hash, :name, :phone, :avatar, :address, :role, :status)');
            $state->bindValue(':email', $user->email, PDO::PARAM_STR);
            $state->bindValue(':password_hash', password_hash($user->password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $state->bindValue(':name', $user->name, PDO::PARAM_STR);
            $state->bindValue(':phone', $user->phone, PDO::PARAM_STR);
            $avatars = [
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Cat.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Dog.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Fox.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Panda.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Wolf.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Lion.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Deer.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Bear.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Rabbit.webp',
                'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Pig.webp',
            ];
            $user->avatar = $avatars[array_rand($avatars)];
            $state->bindValue(':avatar', $user->avatar, PDO::PARAM_STR);
            $state->bindValue(':address', $user->address, PDO::PARAM_STR);
            $state->bindValue(':role', $user->role, PDO::PARAM_STR);
            $state->bindValue(':status', $user->status, PDO::PARAM_STR);
            $state->execute();
        }

        public static function updateAvatar(string $email, string $newAvatar): void
        {
            $pdo = Database::getConnection();

            $state = $pdo->prepare('UPDATE user SET avatar = :avatar WHERE email = :email');
            $state->bindValue(':avatar', $newAvatar, PDO::PARAM_STR);
            $state->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
            $state->execute();
        }

        public static function updateInfo(string $email, string $name, string $phone, string $address): void
        {
            $pdo = Database::getConnection();

            $state = $pdo->prepare('UPDATE user SET name = :name, phone = :phone, address = :address WHERE email = :email');
            $state->bindValue(':name', $name, PDO::PARAM_STR);
            $state->bindValue(':phone', $phone, PDO::PARAM_STR);
            $state->bindValue(':address', $address, PDO::PARAM_STR);
            $state->bindValue(':email', $email, PDO::PARAM_STR);

            // Execute the statement and check for errors
            if (!$state->execute()) {
                error_log('SQL Error: ' . implode(', ', $state->errorInfo())); // Log SQL error
            }
        }

        public static function updatePassword(string $email, string $newPassword): void
        {
            $pdo = Database::getConnection();

            $state = $pdo->prepare('UPDATE user SET password_hash = :password_hash WHERE email = :email');
            $state->bindValue(':password_hash', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $state->bindValue(':email', $email, PDO::PARAM_STR);

            // Execute the statement and check for errors
            if (!$state->execute()) {
                error_log('SQL Error: ' . implode(', ', $state->errorInfo())); // Log SQL error
            }
        }

        public static function getAllUsers(): array
        {
            $pdo = Database::getConnection();
            $state = $pdo->query('SELECT * FROM user ORDER BY name');

            $users = [];
            while ($row = $state->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['id'],
                    $row['email'],
                    $row['password_hash'],
                    $row['name'],
                    $row['phone'],
                    $row['avatar'],
                    $row['address'],
                    $row['role'],
                    $row['status']
                );
            }

            return $users;
        }
    }
}
