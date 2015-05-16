<?php
namespace catsalad\V1\Validator;

use Zend\Validator\AbstractValidator;

class BooleanValue extends AbstractValidator
{
    const MESSAGE = 'BooleanValue';

    protected $messageTemplates = array(
        self::MESSAGE => "'%value%' is invalid."
    );

    public function isValid($value)
    {
        $this->setValue($value);
        
        if (!is_bool($value)) {
            $this->error(self::MESSAGE);
            return false;
        }
        return true;
    }
}