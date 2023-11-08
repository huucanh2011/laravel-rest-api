<?php

namespace App\Providers;

// use App\Helpers\Search;

use App\Repositories\PasswordReset\PasswordResetRepository;
use App\Repositories\PasswordReset\PasswordResetRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // if ($this->isConfigApplied()) {
        //     $this->bindAllRepositories();
        //     $this->bindAllServices();
        // }

        // Repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PasswordResetRepositoryInterface::class, PasswordResetRepository::class);

        // Services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    // /**
    //  * Loop through the repository interface and bind each interface to its
    //  * Repository inside the implementations.
    //  *
    //  * @return void
    //  */
    // private function bindAllRepositories()
    // {
    //     $repositoryInterfaces = $this->getRepositoryPath();

    //     foreach ($$repositoryInterfaces as $key => $repositoryInterface) {
    //         $repositoryInterfaceClass = config('repository-service.repository_namespace') . '\\'
    //                                     . $repositoryInterface . '\\'
    //                                     . $repositoryInterface
    //                                     . config('repository-service.repository_interface_suffix');

    //         $repositoryImplementClass = config('repository-service.repository_namespace') . '\\'
    //                                     . $repositoryInterface . '\\'
    //                                     . $repositoryInterface
    //                                     . config('repository-service.repository_suffix');

    //         $this->app->bind($repositoryInterfaceClass, $repositoryImplementClass);
    //     }
    // }

    // private function bindAllServices()
    // {
    //     $servicePath = $this->getServicePath();

    //     foreach ($servicePath as $serviceName) {
    //         $splitName = explode('/', $serviceName);
    //         $className = end($splitName);

    //         $pathService = str_replace('/', '\\', $serviceName);

    //         $serviceInterfaceClass = config('repository-service.service_namespace') . '\\'
    //                 . $pathService . '\\'
    //                 . $className
    //                 . config('repository-service.service_interface_suffix');

    //         $serviceImplementClass = config('repository-service.service_namespace') . '\\'
    //                 . $pathService . '\\'
    //                 . $className
    //                 . config('repository-service.service_suffix');

    //         $this->app->bind($serviceInterfaceClass, $serviceImplementClass);
    //     }
    // }

    // /**
    //  * Get repositories path
    //  *
    //  * @return array
    //  */
    // private function getRepositoryPath()
    // {
    //     $folders = [];

    //     $repositoryPath = $this->app->basePath() . '/' . config('repository-service.repository_directory');
    //     if (file_exists($repositoryPath)) {
    //         $dirs = File::directories($repositoryPath);
    //         foreach ($dirs as $dir) {
    //             $dir = str_replace('\\', '/', $dir);
    //             $arr = explode('/', $dir);

    //             $folders[] = end($arr);
    //         }
    //     }

    //     return $folders;
    // }

    // /**
    //  * Get service path
    //  *
    //  * @return array
    //  */
    // private function getServicePath()
    // {
    //     $root = $this->app->basePath() . '/' . config('repository-service.service_directory');
    //     $servicePath = [];

    //     if (file_exists($root)) {
    //         $path = Search::file($root, ['php']);

    //         foreach ($path as $file) {
    //             $filePath = strstr($file->getPath(), 'Services');
    //             $filePath = str_replace('\\', '/', $filePath);
    //             $servicePath[] = str_replace('Services/', '', $filePath);
    //         }
    //     }

    //     return array_unique($servicePath);
    // }

    // /**
    //  * Check if config is applied
    //  *
    //  * @param bool
    //  */
    // private function isConfigApplied(): bool
    // {
    //     return file_exists(config_path('repository-service.php'));
    // }
}
