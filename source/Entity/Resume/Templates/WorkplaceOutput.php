<?php

namespace Source\Entity\Resume\Templates;

use Source\Entity\Resume\Models\Workplace;
use function Source\Helper\artwooDiffTimestampsToHuman;

class WorkplaceOutput
{
    public static function getContext(Workplace $workplace): \stdClass {
        $object = new \stdClass();
        $object->title = $workplace->position . " / " . $workplace->organization_name;
        $object->duration = artwooDiffTimestampsToHuman($workplace->getRawOriginal('date_dismissal'),
            $workplace->getRawOriginal('date_employment'));
        $object->description = $workplace->description;
        $object->duties = $workplace->duties;
        $object->id = $workplace->id;
        return $object;
    }
}
