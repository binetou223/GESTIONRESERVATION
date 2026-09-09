<?php
namespace App\Validator;
use Respect\Validation\Validator as RespectValidator;
use App\Validator\ValidationResult;
use App\Validator\ValidatorInterface;
use Respect\Validation\Exceptions\NestedValidationException;

class ReservationValidator implements ValidatorInterface
{
    public function supports(string $type): bool
    {
        return $type === 'reservation';
    }

    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $rules = [
            'salle_id'    => RespectValidator::intType()->positive(),
            'responsable' => RespectValidator::stringType()->length(2, 120),
            'email'       => RespectValidator::email(),
            'motif'       => RespectValidator::stringType()->length(5, 255),
            'date_debut'  => RespectValidator::dateTime(format: 'Y-m-d H:i:s'),
            'date_fin'    => RespectValidator::dateTime(format: 'Y-m-d H:i:s'),
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
