<?php
/**
 * Advert fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Advert;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AdvertFixtures.
 */
class AdvertFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $advert = new Advert();
            $advert->setTitle($this->faker->sentence);
            $advert->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $advert->setUpdatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $this->manager->persist($advert);
        }

        $this->manager->flush();
    }
}
