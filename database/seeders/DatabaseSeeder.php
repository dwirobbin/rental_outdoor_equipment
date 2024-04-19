<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\BillingSeeder;
use Illuminate\Support\Facades\File;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\OrderDetailSeeder;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\PaymentMethodSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (is_dir(storage_path('framework/sessions'))) {
            $pathSession = storage_path('framework/sessions');
            $ignoreFiles = ['.gitignore', '.', '..'];
            $sessionFiles = scandir($pathSession);
            foreach ($sessionFiles as $sessionFile) {
                if (!in_array($sessionFile, $ignoreFiles)) unlink($pathSession . '/' . $sessionFile);
            }
        }

        if (is_dir(storage_path('framework/views'))) {
            $pathViews = storage_path('framework/views');
            $ignoreFilesOnViews = ['.gitignore', '.', '..'];
            $viewFiles = scandir($pathViews);
            foreach ($viewFiles as $viewFile) {
                if (!in_array($viewFile, $ignoreFilesOnViews)) unlink($pathViews . '/' . $viewFile);
            }
        }

        if (is_dir(storage_path('framework/cache/laravel-excel'))) {
            $pathLaravelExcelFile = storage_path('framework/cache/laravel-excel');
            $laravelExcelFiles = File::allFiles($pathLaravelExcelFile);
            foreach ($laravelExcelFiles as $laravelExcelFile) {
                File::delete($pathLaravelExcelFile . '/' . $laravelExcelFile->getFilename());
            }
        }

        if (is_dir(storage_path('app/livewire-tmp'))) {
            $livewireTmpFiles = Storage::allFiles('livewire-tmp');
            foreach ($livewireTmpFiles as $livewireTmpFile) {
                Storage::delete($livewireTmpFile);
            }
        }

        if (is_dir(storage_path('app/public/image/users'))) {
            $pathUser = storage_path('app/public/image/users');
            $userImgFiles = File::allFiles($pathUser);
            foreach ($userImgFiles as $userImgFile) {
                File::delete($pathUser . '/' . $userImgFile->getFilename());
            }
        }

        if (is_dir(storage_path('app/public/image/equipments'))) {
            $pathEquipment = storage_path('app/public/image/equipments');
            $equipmentFiles = File::allFiles($pathEquipment);
            foreach ($equipmentFiles as $equipmentFile) {
                File::delete($pathEquipment . '/' . $equipmentFile->getFilename());
            }
        }

        if (is_dir(storage_path('app/public/image/payment-methods'))) {
            $pathPaymentMethod = storage_path('app/public/image/payment-methods');
            $payMethodFiles = File::allFiles($pathPaymentMethod);
            foreach ($payMethodFiles as $payMethodFile) {
                File::delete($pathPaymentMethod . '/' . $payMethodFile->getFilename());
            }
        }

        if (is_dir(storage_path('app/public/image/orders'))) {
            $pathOrder = storage_path('app/public/image/orders');
            $orderFiles = File::allFiles($pathOrder);
            foreach ($orderFiles as $orderFile) {
                File::delete($pathOrder . '/' . $orderFile->getFilename());
            }
        }

        if (is_dir(storage_path('app/public/image/billings'))) {
            $pathBilling = storage_path('app/public/image/billings');
            $billingFiles = File::allFiles($pathBilling);
            foreach ($billingFiles as $billingFile) {
                File::delete($pathBilling . '/' . $billingFile->getFilename());
            }
        }

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EquipmentSeeder::class,
            PaymentMethodSeeder::class,
            // OrderSeeder::class,
            // OrderDetailSeeder::class,
            // BillingSeeder::class,
        ]);
    }
}
