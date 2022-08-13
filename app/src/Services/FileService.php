<?php

namespace Arslav\KnaaruBot\Services;

use Arslav\Bot\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

class FileService
{
    /**
     * @param string $dir
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function getFiles(string $dir): array
    {
        $files = [];
        try {
            $finder = new Finder();

            $finder->files()->in(__DIR__ . '/../../' . $dir);

            foreach ($finder as $file) {
                $files[] = $file->getPathname();
            }
        } catch (DirectoryNotFoundException $exception) {
            App::getLogger()->error($exception->getMessage());
        }

        return $files;
    }
}
