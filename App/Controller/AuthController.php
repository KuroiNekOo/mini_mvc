<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;

class AuthController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'login':
                        $this->login();
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                    case 'signup':
                        $this->signup();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                        break;
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }


    protected function login()
    {
        $errors = [];

        if (isset($_POST['loginUser'])) {

            $userRepository = new UserRepository();

            $user = $userRepository->findOneByEmail($_POST['email']);

            if ($user && $user->verifyPassword($_POST['password'])) {
                // Regénère l'id session pour éviter la fixation de session
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'first_name' => $user->getFirstName(),
                    'last_name' => $user->getLastName(),
                ];
                header('location: index.php');
                return;
            } else {
                $errors[] = 'Email ou mot de passe incorrect';
            }
        }

        $this->render('auth/login', [
            'errors' => $errors,
        ]);
    }


    protected function logout()
    {
        //Prévient les attaques de fixation de session
        session_regenerate_id(true);
        //Supprime les données de session du serveur
        session_destroy();
        //Supprime les données du tableau $_SESSION
        unset($_SESSION);
        header ('location: index.php?controller=auth&action=login');
    }

    protected function signup() {

        $errors = [];
        $user = new User();

        if (isset($_POST['signupUser'])) {

            if ($_POST['password'] !== $_POST['confirmPassword']) {
                $errors[] = 'Les mots de passe ne correspondent pas';
            }

            $user->setFirstName($_POST['first_name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

            $errors = $user->validate();

            if (empty($errors)) {
                $userRepository = new UserRepository();
                $userRepository->persist($user);
                header('location: index.php');
            }

            if ($user) {
              // Regénère l'id session pour éviter la fixation de session
              session_regenerate_id(true);
              $_SESSION['user'] = [
                  'id' => $user->getId(),
                  'email' => $user->getEmail(),
                  'first_name' => $user->getFirstName(),
                  'last_name' => $user->getLastName(),
              ];
              header('location: index.php');
              return;
            } else {
                $errors[] = 'Erreur d\'inscription';
            }
        }

        $this->render('auth/signup', [
            'errors' => $errors,
        ]);

    }
}
