<?php

namespace App\View\Core\Abstract;

use App\View\Core\Interfaces\ImageInterface;
use App\View\Core\Abstract\BaseAbstract;
use Exception;

/**
 * Абстрактный класс для работы с изображением
 */
abstract class ImageAbstract extends BaseAbstract implements ImageInterface  {

    public function __construct(
        public string $pathToImage,
        public string $imageType
    )
    {
        if (!in_array($this->imageType, self::IMAGE_TYPES)) {
            throw new Exception('Указан неверный тип для изображения!');
        }
    }

    /**
     * Пока реализовано в простом виде, у нас файлы хранятся в двух вариантах:
     *  yandex storage
     *  хранилище нашего сервера (те файлы, которые нам нужны для фронта)
     *
     * @return string
     */
    public function getImagePath() : string {
        return $this->pathToImage;
    }

    protected function fullImageStyles() {
        return self::FULL_IMAGE_SIZE_CLASSES . ' ' .
            self::BORDER_RADIUSES['big'];
    }

    protected function previewImageStyles() {
        return self::PREVIEW_IMAGE_SIZE_CLASSES . ' ' .
            self::BORDER_RADIUSES['md'];
    }

    protected function smallImageStyles() {
        return self::SMALL_IMAGE_SIZE_CLASSES . ' ' .
            self::BORDER_RADIUSES['sm'];
    }

    protected function authImageStyles() {
        return self::AUTH_PAGE_IMAGE_SIZE_CLASSES;
    }

    abstract protected function getFullImageClasses();

    /**
     *  Получение стилей для изображения
     *
     * @return mixed
     * @throws Exception
     */
    final protected function buildImageClasses() {
        $methodFullName = $this->imageType . 'ImageStyles';

        if (method_exists($this, $methodFullName)) {
            return $this->$methodFullName();
        };

        throw new Exception('Не удалось получить классы для изображения!');
    }
}
