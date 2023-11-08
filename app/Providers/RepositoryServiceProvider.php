<?php

namespace App\Providers;

use App\Helpers\Search;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * File
     *
     * @property $fileSystem
     */
    private Filesystem $fileSystem;

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->fileSystem = $this->app->make(FileSystem::class);
        if ($this->isConfigApplied()) {
            $this->bindAllRepositories();
            $this->bindAllServices();
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Loop through the repository interface and bind each interface to its
     * Repository inside the implementations.
     *
     * @return void
     */
    private function bindAllRepositories()
    {
        $repositoryInterfaces = $this->getRepositoryPath();

        foreach ($$repositoryInterfaces as $key => $repositoryInterface) {
            $repositoryInterfaceClass = config('repository-service.repository_namespace') . '\\'
                                        . $repositoryInterface . '\\'
                                        . $repositoryInterface
                                        . config('repository-service.repository_interface_suffix');

            $repositoryImplementClass = config('repository-service.repository_namespace') . '\\'
                                        . $repositoryInterface . '\\'
                                        . $repositoryInterface
                                        . config('repository-service.repository_suffix');

            $this->app->bind($repositoryInterfaceClass, $repositoryImplementClass);
        }
    }

    private function bindAllServices()
    {
        $servicePath = $this->getServicePath();

        foreach ($servicePath as $serviceName) {
            $splitName = explode('/', $serviceName);
            $className = end($splitName);

            $pathService = str_replace('/', '\\', $serviceName);

            $serviceInterfaceClass = config('repository-service.service_namespace') . '\\'
                    . $pathService . '\\'
                    . $className
                    . config('repository-service.service_interface_suffix');

            $serviceImplementClass = config('repository-service.service_namespace') . '\\'
                    . $pathService . '\\'
                    . $className
                    . config('repository-service.service_suffix');

            $this->app->bind($serviceInterfaceClass, $serviceImplementClass);
        }
    }

    /**
     * Get repositories path
     *
     * @return array
     */
    private function getRepositoryPath()
    {
        $folders = [];

        $repositoryPath = $this->app->basePath() . '/' . config('repository-service.repository_directory');
        if (file_exists($repositoryPath)) {
            $dirs = File::directories($repositoryPath);
            foreach ($dirs as $dir) {
                $dir = str_replace('\\', '/', $dir);
                $arr = explode('/', $dir);

                $folders[] = end($arr);
            }
        }

        return $folders;
    }

    /**
     * Get service path
     *
     * @return array
     */
    private function getServicePath()
    {
        $root = $this->app->basePath() . '/' . config('repository-service.service_directory');
        $servicePath = [];

        if (file_exists($root)) {
            $path = Search::file($root, ['php']);

            foreach ($path as $file) {
                $filePath = strstr($file->getPath(), 'Services');
                $filePath = str_replace('\\', '/', $filePath);
                $servicePath[] = str_replace('Services/', '', $filePath);
            }
        }

        return array_unique($servicePath);
    }

    /**
     * Check if config is applied
     *
     * @param bool
     */
    private function isConfigApplied(): bool
    {
        $path = config_path('repository-service');
        $exists = file_exists($path);

        return $exists;
    }
}
