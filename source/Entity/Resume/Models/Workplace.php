<?php

namespace Source\Entity\Resume\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Source\Helper\Datetimelib\artwooCastToTimestamp;

class Workplace extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'resume_workplaces';
    protected $fillable = ['resume_id', 'organization_name', 'position', 'duties', 'date_employment',
        'date_dismissal', 'description'];

    protected $casts = [
        'resume_id' => 'integer',
        'date_employment' => "datetime:d.m.Y",
        'date_dismissal' => "datetime:d.m.Y",
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    protected function dateEmployment(): Attribute
    {
        return Attribute::make(set:function($value) {
            if (is_null($value)) {
                return null;
            }

            return \DateTime::createFromFormat(config('app.artwoo.date.format'), $value)
                ->format(config('app.artwoo.date.mysql_format'));
        });
    }

    protected function dateDismissal(): Attribute
    {
        return Attribute::make(set:function($value) {
            if (is_null($value)) {
                return null;
            }

            return \DateTime::createFromFormat(config('app.artwoo.date.format'), $value)
                ->format(config('app.artwoo.date.mysql_format'));
        });
    }
}
