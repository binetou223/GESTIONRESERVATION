<?php

namespace App\Validation;

use App\Validator\ValidationResult;
use App\Validator\ValidatorInterface;
use Respect\Validation\Validator as RespectValidator;
use Respect\Validation\Exceptions\NestedValidationException;


class SalleValidator implements ValidatorInterface
{
    private const TYPES_AUTORISES = ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'];
    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $rules = [
            'nom'      => RespectValidator::stringType()->length(2, 100),
            'batiment' => RespectValidator::stringType()->length(2, 100),
            'capacite' => RespectValidator::intType()->between(1, 1000),
            'type'     => RespectValidator::in(self::TYPES_AUTORISES),
            'active'   => RespectValidator::boolType(),
        ];
        foreach ($rules as $champ => $validator) {
            try {
                $validator->assert($data[$champ] ?? null);
            } catch (NestedValidationException $exception) {
                $errors[$champ] = $exception->getMessages()[0] ?? "Le champ {$champ} est invalide.";
            }
        }

        if ($errors !== []) {
            return new ValidationResult(valid: false, errors: $errors);
        }
        return new ValidationResult(valid: true, data: $data);
    }
}
