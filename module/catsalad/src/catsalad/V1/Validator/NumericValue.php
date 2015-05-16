<?php
namespace catsalad\V1\Validator;

use Zend\Validator\AbstractValidator;

class NumericValue extends AbstractValidator
{
    const NUMERIC = 'numberic';

    protected $messageTemplates = array(
        self::NUMERIC => "'%value%' is not a numeric value"
    );

    public function isValid($value)
    {
        $this->setValue($value);

        if (!is_numeric($value)) {
            $this->error(self::NUMERIC);
            return false;
        }

        return true;
    }
}