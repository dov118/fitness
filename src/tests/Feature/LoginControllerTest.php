<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws ReflectionException
     */
    private static function callPrivate($method_name, $args) {
        $class = new ReflectionClass(new LoginController());
        $method = $class->getMethod($method_name);
        return $method->invokeArgs(new LoginController(), $args);
    }

    public function test_the_login_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Login with discord');
        $response->assertDontSee('Dashboard');
        $response->assertDontSee('General');
        $response->assertDontSee('Groups');
    }

    public function test_the_discord_login_returns_a_successful_response(): void
    {
        $response = $this->get(route('login.discord'));

        $response->assertRedirect('https://discord.com/oauth2/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => 'DISCORD_APPLICATION_ID',
            'scope' => 'email identify',
            'redirect_uri' => route('login.discord.oauth'),
            'prompt' => 'consent',
        ]));
    }

    /**
     * @throws ReflectionException
     */
    public function test_the_user_creation_from_discord_data_works(): void
    {
        $email = fake()->email();
        $id = fake()->randomNumber();
        $username = fake()->name();
        $avatar = fake()->randomNumber();

        $this->callPrivate('createUserFromDiscordData', [[
            'email' => $email,
            'id' => $id,
            'username' => $username,
            'avatar' => $avatar,
        ]]);

        $this->assertDatabaseHas(app(User::class)->getTable(), [
            'email' => $email,
            'id' => $id,
            'name' => $username,
            'avatar' => $avatar,
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function test_the_user_fetch_from_discord_data_works(): void
    {
        $email = fake()->email();
        $id = fake()->randomNumber();
        $username = fake()->name();
        $avatar = fake()->randomNumber();

        $this->assertDatabaseMissing(app(User::class)->getTable(), [
            'email' => $email,
        ]);

        $created_user = User::create([
            'email' => $email,
            'id' => $id,
            'name' => $username,
            'password' => Hash::make($username),
            'avatar' => $avatar,
        ]);

        $this->assertDatabaseHas(app(User::class)->getTable(), [
            'email' => $email,
        ]);

        $user = $this->callPrivate('createUserFromDiscordData', [[
            'email' => $email,
            'id' => $id,
            'username' => $username,
            'avatar' => $avatar,
        ]]);

        $this->assertTrue($user->id === $created_user->id);
    }

    /**
     * @throws ReflectionException
     */
    public function test_the_user_login_from_discord_data_works(): void
    {
        $email = fake()->email();
        $id = fake()->randomNumber();
        $username = fake()->name();
        $avatar = fake()->randomNumber();

        $this->assertTrue(!Auth::hasUser());

        $created_user = User::create([
            'email' => $email,
            'id' => $id,
            'name' => $username,
            'password' => Hash::make($username),
            'avatar' => $avatar,
        ]);

        $user = $this->callPrivate('login', [[
            'email' => $email,
            'id' => $id,
            'username' => $username,
            'avatar' => $avatar,
        ]]);

        $this->assertTrue(Auth::hasUser());
        $this->assertTrue(Auth::user()->id === $created_user->id);
    }

    public function test_the_user_logout_works(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->assertTrue(Auth::hasUser());

        $response = $this->delete(route('logout'));

        $this->assertTrue(!Auth::hasUser());

        $response->assertRedirect(route('login'));
    }

    public function test_all_indexes_admin_view_redirected_to_login_page_when_not_logged(): void
    {
        $this->assertTrue(!Auth::hasUser());

        foreach (Route::getRoutes()->getRoutes() as $route) {
            if (str_contains($route->getControllerClass(), 'App\Http\Controllers') &&
                str_contains($route->getName(), 'admin.') &&
                str_contains($route->getName(), '.index')
            ) {
                $response = $this->get(route($route->getName()));
                $response->assertRedirect(route('login'));
            }
        }
    }

    public function test_the_logged_page_dont_show_login_button(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get(route('admin.index'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('General');
        $response->assertSee('Groups');
    }
}
