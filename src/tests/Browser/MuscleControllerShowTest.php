<?php

namespace Tests\Browser;

use App\Models\Group;
use App\Models\Muscle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\MuscleControllerShow;
use Tests\DuskTestCase;
use Throwable;

class MuscleControllerShowTest extends DuskTestCase
{
    use DatabaseMigrations;
    use Header;
    use Sidenav;

    protected string $page = MuscleControllerShow::class;

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_show_title_contain_muscle_name(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->assertSeeIn('@content-title', $muscle->name);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_the_admin_muscle_index_title_edit_button_works(): void
    {
        Group::factory()->create();
        $muscle = Muscle::factory()->create();

        $this->browse(function (Browser $browser) use ($muscle) {
            $browser->loginAs(User::factory()->create())
                ->visit(new $this->page($muscle))
                ->click('@title-edit')
                ->assertRouteIs('admin.muscle.edit', [$muscle]);
        });
    }
}
