<?php

namespace Source\Entity\Resume\Models;

use App\View\Core\Components\ContentMetaInfo\ContentMetaInfo;
use App\View\Core\Components\ContentMetaInfo\MainInfo;
use App\View\Core\Components\ContentMetaInfo\SecondaryInfo;
use App\View\Core\Components\ContentMetaInfo\TagInfo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Source\Entity\User\Models\User;
use function Source\Helper\{artwooDiffTwoTimestamps, artwooSumIntervalToHumanFormat};

class Resume extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['user_id', 'skills', 'preferred_work', 'has_art_education', 'has_pedagogical_education'];

    protected $casts = [
        'skills' => 'string',
        'user_id' => 'integer',
        'preferred_work' => 'string',
        'has_art_education' => 'boolean',
        'has_pedagogical_education' => 'boolean'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function workplace(): HasMany {
        return $this->hasMany(Workplace::class);
    }

    /**
     * Получение ключевых данных для отображения резюме
     *
     * @return \App\View\Core\Components\ContentMetaInfo\ContentMetaInfo
     */
    public function getMetaInfo(): ContentMetaInfo {
        $metaInfo = new ContentMetaInfo();
        $mainInfo = new MainInfo();
        $tagInfo = new TagInfo();

        $intervals = $this->workplace->reduce(function($accum, $record) {
            $interval = artwooDiffTwoTimestamps(
              $record->getRawOriginal('date_dismissal'),
              $record->getRawOriginal('date_employment')
            );
            if ($interval) return [...$accum, $interval];
        }, []);
        $yearsOfWork = artwooSumIntervalToHumanFormat($intervals, ' ', true);
        if (!$yearsOfWork) $yearsOfWork = '-';

        $mainInfo->add(true, $yearsOfWork);
        if ($this->has_art_education) {
            $mainInfo->add(false, __('resume.art_education'));
        }
        if ($this->has_pedagogical_education) {
            $mainInfo->add(false, __('resume.pedagogical_education')
            );
        }

        if ($enum = $this->user->getCreativityEnum()) {
            $tagInfo->add('text', $enum->getAuthorCreativityName());
            $tagInfo->add('url', '/?topic='.$enum->value);
        }

        $metaInfo[] = $tagInfo;
        $metaInfo[] = $mainInfo;
        $metaInfo[] = new SecondaryInfo();

        return $metaInfo;
    }

    public function getSkillsValues(): array {
        $skills = collect(\json_decode($this->skills, true));
        return $skills->map(function($value) {
            return $value['value'];
        })->all();
    }
}
