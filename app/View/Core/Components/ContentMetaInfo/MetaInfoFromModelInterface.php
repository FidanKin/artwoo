<?php

namespace App\View\Core\Components\ContentMetaInfo;

// получение мета информации из модели
interface MetaInfoFromModelInterface
{
    public function getContentMetaInfo(): ContentMetaInfo;
}
