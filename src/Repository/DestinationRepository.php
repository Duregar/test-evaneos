<?php

namespace Evaneos\Repository;

use Evaneos\Entity\Destination;
use Evaneos\Helper\SingletonTrait;

class DestinationRepository implements Repository
{
    use SingletonTrait;

    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD

        $faker = \Faker\Factory::create();
        $faker->seed($id);

        return new Destination(
            $id,
            $faker->country,
            'en',
            $faker->slug()
        );
    }
}
