<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Locker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LockerController
 */
class LockerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $lockers = Locker::factory()->count(3)->create();

        $response = $this->get(route('locker.index'));

        $response->assertOk();
        $response->assertViewIs('locker.index');
        $response->assertViewHas('lockers');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('locker.create'));

        $response->assertOk();
        $response->assertViewIs('locker.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LockerController::class,
            'store',
            \App\Http\Requests\LockerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $level = $this->faker->word;
        $location = $this->faker->word;
        $locker_number = $this->faker->word;
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('locker.store'), [
            'level' => $level,
            'location' => $location,
            'locker_number' => $locker_number,
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $lockers = Locker::query()
            ->where('level', $level)
            ->where('location', $location)
            ->where('locker_number', $locker_number)
            ->where('status', $status)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $lockers);
        $locker = $lockers->first();

        $response->assertRedirect(route('locker.index'));
        $response->assertSessionHas('locker.id', $locker->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $locker = Locker::factory()->create();

        $response = $this->get(route('locker.show', $locker));

        $response->assertOk();
        $response->assertViewIs('locker.show');
        $response->assertViewHas('locker');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $locker = Locker::factory()->create();

        $response = $this->get(route('locker.edit', $locker));

        $response->assertOk();
        $response->assertViewIs('locker.edit');
        $response->assertViewHas('locker');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LockerController::class,
            'update',
            \App\Http\Requests\LockerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $locker = Locker::factory()->create();
        $level = $this->faker->word;
        $location = $this->faker->word;
        $locker_number = $this->faker->word;
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('locker.update', $locker), [
            'level' => $level,
            'location' => $location,
            'locker_number' => $locker_number,
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $locker->refresh();

        $response->assertRedirect(route('locker.index'));
        $response->assertSessionHas('locker.id', $locker->id);

        $this->assertEquals($level, $locker->level);
        $this->assertEquals($location, $locker->location);
        $this->assertEquals($locker_number, $locker->locker_number);
        $this->assertEquals($status, $locker->status);
        $this->assertEquals($user->id, $locker->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $locker = Locker::factory()->create();

        $response = $this->delete(route('locker.destroy', $locker));

        $response->assertRedirect(route('locker.index'));

        $this->assertModelMissing($locker);
    }
}
