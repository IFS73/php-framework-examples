<?php

namespace Cda0521Framework\Service\FlashMessages;

use Cda0521Framework\Service\FlashMessages\FlashMessage;

class FlashMessagesService
{
    public function __construct()
    {
        // Vérifie que la session contient bien un tableau de messages afin d'éviter que le service ne tente
        // de faire des opérations de tableau sur une valeur non-existante
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
    }

    /**
     * Store flash message in session
     *
     * @param string $message Message to store
     * @return void
     */
    public function addMessage(FlashMessage $flashMessage): void
    {
        // Demande à l'objet FlashMessage de se transformer en tableau associatif, afin de le stocker dans la session
        array_push($_SESSION['messages'], $flashMessage->toArray());
    }

    /**
     * Get flash message stored in session
     *
     * @return FlashMessage[]|null
     */
    public function getMessages(): array
    {
        $flashMessages = [];

        // Transforme les tableaux associatifs correspondant à des messages stockés en session en objets FlashMessage
        foreach ($_SESSION['messages'] as $messageArray) {
            // Demande à la classe FlashMessage de construire un nouvel objet à partir du tableau associatif stocké en session
            $flashMessages []= FlashMessage::fromArray($messageArray);
        }
        // Efface tous les messages de la session, de sorte que chaque message ne soit affiché qu'une seule fois
        $this->deleteMessages();

        return $flashMessages;
    }

    /**
     * Delete flash message from session
     *
     * @return void
     */
    public function deleteMessages(): void
    {
        // Supprime les informations du message stockées en session
        $_SESSION['messages'] = [];
    }
}
