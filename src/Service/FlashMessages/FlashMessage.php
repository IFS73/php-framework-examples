<?php

namespace Cda0521Framework\Service\FlashMessages;

class FlashMessage
{
    /**
     * Message text
     * @var string
     */
    protected string $message;
    /**
     * Message type
     * @var string
     */
    protected string $type;

    /**
     * Create new flash message from an array (typically stored in session)
     *
     * @param array $array Array to parse
     * @return self
     * @static
     */
    public static function fromArray(array $array): self
    {
        return new FlashMessage($array['message'], $array['type']);
    }

    /**
     * Create new flash message
     *
     * @param string $message Message text
     * @param string $type Message type
     */
    public function __construct(string $message, string $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Serialize flash message as an associative array (typically, in order to store in session)
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'type' => $this->getType(),
        ];
    }

    /**
     * Get message text
     *
     * @return  string
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get message type
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }
}
