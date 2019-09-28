<?php

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
    }

    public function uploadImage(UploadedFile $image)
    {
        $filename = md5(uniqid()) . '.' . $image->guessClientExtension();
        $image->move(
            $this->container->getParameter('uploads_dir'),
            $filename
        );

        return $filename;
    }
}
