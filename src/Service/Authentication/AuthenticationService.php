<?php

namespace Cda0521Framework\Service\Authentication;

use Cda0521Framework\Service\Authentication\User;
use Cda0521Framework\Exception\UnauthorizedException;
use Cda0521Framework\Exception\InvalidFormDataException;
use Cda0521Framework\Exception\InvalidCredentialsException;

class AuthenticationService
{
    /**
     * Try to authenticate user based on email and password
     *
     * @param string $email User email
     * @param string $password User password
     * @return void
     */
    public function authenticate(string $email, string $password): void
    {
        // Récupère l'utilisateur correspondant à l'adresse e-mail fournie
        $result = User::findWhere('email', $email);

        // Si aucun utilisateur avec l'adresse demandée n'existe
        if (empty($result)) {
            throw new InvalidCredentialsException('User \'' . $email . '\' does not exist.', InvalidCredentialsException::WRONG_EMAIL);
        }

        $user = $result[0];

        // Vérifie si le mot de passe fourni correspond au mot de passe défini en BDD
        if (password_verify($password, $user->getPassword())) {
            setcookie('PHP_AUTH', $user->getSecret());
        } else {
            throw new InvalidCredentialsException('Wrong password for user \'' . $email . '\'.', InvalidCredentialsException::WRONG_PASSWORD);
        }
    }

    /**
     * Forget authentication information
     *
     * @return void
     */
    public function forget(): void
    {
        // Si l'utilisateur est bien authentifié
        if (isset($_COOKIE['PHP_AUTH'])) {
            // Supprime le cookie
            unset($_COOKIE['PHP_AUTH']);
            setcookie('PHP_AUTH', '', time() - 3600, '/');
        }
    }

    /**
     * Get currently authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser(): ?User
    {
        // Si le cookie d'authentification existe
        if (isset($_COOKIE['PHP_AUTH'])) {
            // Récupère l'utilisateur dont la clé secrète est dans le cookie
            $result = User::findWhere('secret', $_COOKIE['PHP_AUTH']);
            // Si le tableau est vide, cela signifie que le secret écrit dans le cookie ne correspond à aucune utilisateur
            // et donc, que le client a falsifié un cookie (et ça, c'est mal)
            if (empty($result)) {
                throw new InvalidFormDataException('Invalid authentication cookie data');
            }

            // Renvoie le premier résultat (sachant qu'il doit normalement y en avoir un seul)
            return $result[0];

        // Sinon, renvoie null
        } else {
            return null;
        }
    }

    /**
     * Check if user is authenticated, and throw an error otherwise
     *
     * @return void
     */
    public function denyAccessUnlessGranted(): void
    {
        $currentUser = $this->getAuthenticatedUser();
        if (is_null($currentUser)) {
            throw new UnauthorizedException('You must be authenticated to access this page.');
        }
    }
}
