<?php

declare(strict_types=1);

namespace App\Validator;

final class ValidatorFactory
{
    public function __construct(private readonly iterable $validators)
    {
    }

    public function getValidator(string $type): ValidatorInterface
    {
        foreach ($this->validators as $validator) {
            if ($validator->supports($type)) {
                return $validator;
            }
        }

        throw new \InvalidArgumentException("Aucun validateur trouvé pour le type : {$type}");
    }
}