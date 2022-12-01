<?php

declare(strict_types=1);

namespace App\Input;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Input;

#[Input]
class CreateFacilityInput
{
    #[Field]
    public string $name;

    #[Field]
    public string $subdomain;
}
