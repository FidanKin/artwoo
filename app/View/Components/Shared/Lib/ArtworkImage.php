<?php

namespace App\View\Components\Shared\Lib;

use Closure;
use Illuminate\Contracts\View\View;
use App\View\Core\Abstract\ImageAbstract;

class ArtworkImage extends ImageAbstract
{

    protected function getFullImageClasses()
    {
        $classes = '';
        try {
            $classes = $this->buildImageClasses();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.lib.artwork-image', [
            self::IMAGE_STYLES_KEY => $this->getFullImageClasses(),
            'imageUrl' => $this->getImagePath()
        ]);
    }
}
