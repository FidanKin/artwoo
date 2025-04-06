<?php

namespace App\View\Components\Widgets;

use app\Models\User;
use App\View\Core\Components\ContentMetaInfo\ContentMetaInfo;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Source\Entity\Artwork\Models\Artwork;

class AuthorArtwork extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $author,
        public bool $canEdit,
        public array $formData = [],
        public array $artwork = [],
        public bool $canSendMessage = false,
        public ?ContentMetaInfo $metaInfo = null,
        public array $actions = [], // ссыли на различные действия  (actions: delete, edit and etc)
        public string $backUrl = '/',
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.author-artwork');
    }
}
