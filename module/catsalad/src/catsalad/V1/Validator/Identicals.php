<?php
namespace catsalad\V1\Validator;

use Zend\Validator\AbstractValidator;

class Identicals extends AbstractValidator
{
    const MESSAGE = 'Identical';

    protected $tokens = array();
    protected $messageTemplates = array(
        self::MESSAGE => "'%value%' is invalid token."
    );

    public function __construct($token = null)
    {
        parent::__construct();
        $this->tokens = $token;
    }

    public function addToken($token)
    {
        array_push($this->tokens, $token);
        return $this->tokens;
    }

    /**
     * @var Array tokens
     */
    public function getTokens()
    {
        $this->tokens;
    }

    public function isValid($value)
    {
        $tokens = $this->tokens['token'];

        $this->setValue($value);

        $valid = false;
        foreach ($tokens as $key => $token) {
            if ($value == $token)
                $valid = true;
        }
        if (!$valid) {
            $this->error(self::MESSAGE);
            return false;
        }
        return true;
    }
}