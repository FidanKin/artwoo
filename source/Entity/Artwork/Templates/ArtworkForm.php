<?php

namespace Source\Entity\Artwork\Templates;

use Illuminate\Validation\Rule;
use Source\Entity\Artwork\Models\Artwork;
use Source\Helper\Enums\FormElementsFormat;

class ArtworkForm extends \Source\Helper\FormObjectTransfer\FormInstance
{
    private array $extra;

    public function form_artwork(): void
    {
        // подключем общую библиотеку для получения базовых селект списков
        require_once base_path('source/Helper/AppLib.php');
        $uploadExtensions = implode(',', config('filesystems.upload.extension.image'));
        $topics = implode(',', array_keys(Artwork::artwork_topics_list()));
        $types = implode(',', array_keys(Artwork::artwork_types_list()));
        $maxImages = config('app.artwoo.artwork.max_files');
        $allowedColors = implode(',', array_keys(Artwork::getColorsMenu()));
        $componentQuantity = array_slice(config('app.artwoo.artwork.component_quantity'), 1, null, true);

        $imageUrls = ! empty($this->extra['images']) ? $this->extra['images'] : [];

        $this->definition->add('category', __('artwork.artwork_category'),
            ['select' => Artwork::artwork_types_list()], FormElementsFormat::SELECT, "required|string|in:{$types}");
        $this->definition->add('name', __('artwork.artwork_name'), [], FormElementsFormat::TEXT,
            'required|min:5|max:100|string');
        $this->definition->add('width', 'dummy', ['item' => 'required|numeric'], FormElementsFormat::TEXT, 'array|required');
        $this->definition->add('height', 'dummy', ['item' => 'required|numeric'], FormElementsFormat::TEXT, 'array|required');
        $this->definition->add('depth', 'dummy', ['item' => 'nullable|numeric'], FormElementsFormat::TEXT, 'nullable|array');
        $this->definition->add('has_components', __('artwork.has_components'), [], FormElementsFormat::CHECKBOX,
            'nullable');
        $this->definition->add('number_components', __('artwork.component_quantity'), ['select' => $componentQuantity],
            FormElementsFormat::SELECT, "nullable|integer|in:1,2,3,4,5");
        $this->definition->add('topic', __('artwork.artwork_topic'), ['select' => Artwork::artwork_topics_list()],
            FormElementsFormat::SELECT, "required|string|in:{$topics}");
        $this->definition->add('created_year', __('core.year'), ['select' => years_list()], FormElementsFormat::SELECT,
            'nullable|integer');
        // если указан стоимость, то значит работа рассматривается помимо портфолио, еще как и на продажу
        $this->definition->add('price', __('artwork.product_price'), [], FormElementsFormat::TEXT,
            'nullable|integer');
        /**
         * Максимум мы можем загрузить 6 изображений
         */
        $this->definition->add('images', __('artwork.choose_images', ['max' => $maxImages]), ['uploaded' => $imageUrls, 'item' => 'required|image|max:5000'],
            FormElementsFormat::FILE, "required|array|max:{$maxImages}");
        $this->definition->add('description', __('artwork.description'), [], FormElementsFormat::TEXT,
            'required|string');
        $this->definition->add('color', __('artwork.color_choose'), ['select' => Artwork::getColorsMenu()],
            FormElementsFormat::SELECT, "nullable|string|in:{$allowedColors}");
    }

    public function addFilesDefinitions($name, $files): void
    {
        $this->extra[$name] = $files;
    }

    public function addExtra(string $name, $value): void
    {
        $this->extra[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(array &$data): void
    {
        // TODO: Implement validation() method.
    }

    public static function sizeToForm(Artwork $artwork = null): array
    {
        if ($artwork) {
            return $artwork->size;
        }

        $size = [];
        $width = old('width');
        $height = old('height');
        $depth = old('depth');

        if (empty($width)) {
            return [];
        }

        $q = count($width);

        for ($i = 0; $i < $q; $i++) {
            $size[] = [
                'width' => $width[$i],
                'height' => $height[$i],
                'depth' => $depth[$i],
            ];
        }

        return $size;
    }
}
