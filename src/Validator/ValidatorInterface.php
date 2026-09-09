<?php
namespace App\Validator;
use App\Validator\ValidationResult;
interface ValidatorInterface
{
    public function supports(string $type): bool;

    public function validate(array $data): ValidationResult;
}