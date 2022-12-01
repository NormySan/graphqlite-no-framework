<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Input\CreateFacilityInput;
use App\Entity\Facility;
use App\Input\UpdateFacilityInput;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Types\ID;

class FacilityResolver
{
    #[Query]
    public function facility(ID $id): Facility {
        return new Facility((string) $id, 'Facility', 'facility');
    }

    #[Mutation]
    public function createFacility(CreateFacilityInput $input): Facility {
        return new Facility('1', $input->name, $input->subdomain);
    }

    #[Mutation]
    public function updateFacility(UpdateFacilityInput $input): Facility {
        return new Facility((string) $input->id, $input->name, $input->subdomain);
    }
}
