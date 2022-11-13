<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\HomeController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_success_response()
    {
        CategoryFactory::new()->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999,
            ]);

        $category = CategoryFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        BrandFactory::new()->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999,
            ]);

        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        ProductFactory::new()->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999,
            ]);

        $product = ProductFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1,
            ]);

        $this->get(action(HomeController::class))
            ->assertOk()
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('products.0', $product)
            ->assertViewHas('brands.0', $brand);
    }




}
