<?php
namespace catsalad\V1\Validator;

use Zend\Validator\AbstractValidator;

class FloatValue extends AbstractValidator
{
    const FLOAT = 'float';

    protected $messageTemplates = array(
        self::FLOAT => "'%value%' is not a floating point value"
    );

    public function isValid($value)
    {
        $this->setValue($value);

        if (!is_float($value)) {
            $this->error(self::FLOAT);
            return false;
        }

        return true;
    }
}