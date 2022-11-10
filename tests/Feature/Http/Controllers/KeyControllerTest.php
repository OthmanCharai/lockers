<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Key;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\KeyController
 */
class KeyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $keys = Key::factory()->count(3)->create();

        $response = $this->get(route('key.index'));

        $response->assertOk();
        $response->assertViewIs('key.index');
        $response->assertViewHas('keys');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('key.create'));

        $response->assertOk();
        $response->assertViewIs('key.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KeyController::class,
            'store',
            \App\Http\Requests\KeyStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $locker = Locker::factory()->create();
        $user = User::factory()->create();

        $response = $this->post(route('key.store'), [
            'locker_id' => $locker->id,
            'user_id' => $user->id,
        ]);

        $keys = Key::query()
            ->where('locker_id', $locker->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $keys);
        $key = $keys->first();

        $response->assertRedirect(route('key.index'));
        $response->assertSessionHas('key.id', $key->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $key = Key::factory()->create();

        $response = $this->get(route('key.show', $key));

        $response->assertOk();
        $response->assertViewIs('key.show');
        $response->assertViewHas('key');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $key = Key::factory()->create();

        $response = $this->get(route('key.edit', $key));

        $response->assertOk();
        $response->assertViewIs('key.edit');
        $response->assertViewHas('key');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KeyController::class,
            'update',
            \App\Http\Requests\KeyUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $key = Key::factory()->create();
        $locker = Locker::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('key.update', $key), [
            'locker_id' => $locker->id,
            'user_id' => $user->id,
        ]);

        $key->refresh();

        $response->assertRedirect(route('key.index'));
        $response->assertSessionHas('key.id', $key->id);

        $this->assertEquals($locker->id, $key->locker_id);
        $this->assertEquals($user->id, $key->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $key = Key::factory()->create();

        $response = $this->delete(route('key.destroy', $key));

        $response->assertRedirect(route('key.index'));

        $this->assertModelMissing($key);
    }
}
