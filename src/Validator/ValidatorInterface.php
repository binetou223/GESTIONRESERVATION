<?php
namespace App\Validator;
use App\Validator\ValidationResult;
interface ValidatorInterface
{
    public function validate(array $data): ValidationResult;
}