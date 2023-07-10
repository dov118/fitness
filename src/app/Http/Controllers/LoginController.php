<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('admin.auth.login');
    }

    public function loginDiscord(): RedirectResponse
    {
        return redirect()->away('https://discord.com/oauth2/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => env('DISCORD_APPLICATION_ID'),
            'scope' => 'email identify',
            'redirect_uri' => route('login.discord.oauth'),
            'prompt' => 'consent',
        ]));
    }

    /**
     * @codeCoverageIgnore
     * @throws GuzzleException
     */
    private function getDiscordTokenFromCode(string $code): string
    {
        return json_decode((new Client())->post('https://discord.com/api/oauth2/token',  [
            'form_params' => [
                'client_id' => env('DISCORD_APPLICATION_ID'),
                'client_secret' => env('DISCORD_APPLICATION_KEY'),
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('login.discord.oauth'),
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ])->getBody())->access_token;
    }

    /**
     * @codeCoverageIgnore
     * @throws GuzzleException
     */
    private function getDiscordUserData(string $token): array
    {
        return json_decode((new Client())->get('https://discord.com/api/users/@me',  [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ]
        ])->getBody(), true);
    }

    private function createUserFromDiscordData(array $user): User
    {
        if (User::where('email', $user['email'])->get()->count() === 0) {
            $model = User::create([
                'email' => $user['email'],
                'id' => $user['id'],
                'name' => $user['username'],
                'password' => Hash::make($user['username']),
                'avatar' => $user['avatar'],
            ]);
        } else {
            $model = User::where('email', $user['email'])->get()->first();
        }

        return $model;
    }

    /**
     * @codeCoverageIgnore
     * @throws GuzzleException
     */
    public function loginDiscordOAuth(Request $request): RedirectResponse
    {
        return $this->login($this->getDiscordUserData($this->getDiscordTokenFromCode($request->get('code'))));
    }

    private function login(array $discordUser): RedirectResponse
    {
        $user = $this->createUserFromDiscordData($discordUser);

        Auth::login($user);

        return Redirect::route('admin.index');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return to_route('login')->with('notification_type', 'success')->with('notification_message', 'Logout succeeded');
    }
}
