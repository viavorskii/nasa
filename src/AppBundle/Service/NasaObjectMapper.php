<?php

namespace AppBundle\Service;

use AppBundle\Entity\NasaObject;

/**
 * @author Vladislav Iavorskii
 */
class NasaObjectMapper
{
    public function map($nasaObject)
    {
        //I'm not sure about reset because may be the same object will appear several times,
        // but then the database structure should be a litle bit more complicated.
        // It makes sense to create a new table with appears information(many to one relation)

        $closeApproachData = isset($nasaObject["close_approach_data"]) ? reset($nasaObject["close_approach_data"]) : null;
        $speed = 0;
        $date = null;
        if ($closeApproachData) {
            if (isset($closeApproachData["relative_velocity"]) && isset($closeApproachData["relative_velocity"]["kilometers_per_hour"])){
                $speed = $closeApproachData["relative_velocity"]["kilometers_per_hour"];
            }
            if (isset($closeApproachData["close_approach_date"])) {
                $date = new \DateTime($closeApproachData["close_approach_date"]);
            }
        }

        $object = new NasaObject();
        $object->setReference($nasaObject["neo_reference_id"])
            ->setName($nasaObject["name"])
            ->setSpeed($speed)
            ->setIsHazardous($nasaObject["is_potentially_hazardous_asteroid"])
            ->setDate($date)
        ;

        return $object;
    }
}