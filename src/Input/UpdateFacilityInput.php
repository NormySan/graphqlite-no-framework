<?php

declare(strict_types=1);

namespace App\Input;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Input;
use TheCodingMachine\GraphQLite\Types\ID;

#[Input]
class UpdateFacilityInput
{
    #[Field]
    public ID $id;

    #[Field]
    public string $name;

    #[Field]
    public string $subdomain;
}
