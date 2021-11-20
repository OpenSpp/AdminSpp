<?php

namespace Tests\Feature\Http\Controllers\Jetstream\Department;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\User;
use App\Models\Department;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    private $user = [];
    private $department = [];

    /**
     * DepartmentController Test Get Index.
     *
     * @return void
     */
    public function test_departments_index()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

        $response = $this->actingAs($this->user)->get(route('departments.index'));
        $response->assertStatus(200);
    }

    /**
     * DepartmentController Test Get Form Create.
     *
     * @return void
     */
    public function test_departments_create()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

        $response = $this->actingAs($this->user)->get(route('departments.create'));
        $response->assertStatus(200);
    }

    /**
     * DepartmentController Test Post.
     *
     * @return void
     */
    public function test_departments_store_success()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

        $response = $this->actingAs($this->user)->post(route('departments.store'), [
            'name' => 'Bank Rakyat',
            'queue_code' => 'AA',
            'services_per_day' => 100,
            'services' => [
                ['name' => 'Pembayaran', 'is_active' => true],
                ['name' => 'Penarikan', 'is_active' => true]
            ],
        ]);
        
        $response->assertStatus(302)
            ->assertRedirect(route('departments.index'));
    }

    /**
     * DepartmentController Test Post Error.
     *
     * @return void
     */
    public function test_departments_store_error()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

            $this->dep = "";

        $response = $this->actingAs($this->user)->post(route('departments.store'), [
            'name' => 'Bank Rakyat',
            'queue_code' => 'AA',
            'services_per_day' => null,
            'services' => [
                ['name' => 'Pembayaran', 'is_active' => true],
                ['name' => 'Penarikan', 'is_active' => true]
            ],
        ]);
        
        $response->assertSessionHasErrors();
    }

    /**
     * DepartmentController Test Get Form Create.
     *
     * @return void
     */
    public function test_departments_edit()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

        $this->departmen = Department::factory()->create();

        $response = $this->actingAs($this->user)->get(route('departments.edit', $this->departmen->id));
        $response->assertStatus(200);
    }

    /**
     * DepartmentController Test Post.
     *
     * @return void
     */
    public function test_departments_update_success()
    {
        $this->user = User::factory()
            ->state(new Sequence(
                fn ($sequence) => ['role' => 'admin'],
            ))
            ->create();

        $this->departmen = Department::factory()->create();

        $response = $this->actingAs($this->user)->put(route('departments.update', $this->departmen->id), [
            'name' => 'Bank Rakyat',
            'queue_code' =>  $this->departmen->queue_code,
            'services_per_day' => $this->departmen->services_per_day,
            'services' => [
                ['name' => 'Pembayaran', 'is_active' => true],
                ['name' => 'Penarikan', 'is_active' => true]
            ],
        ]);
        
        $response->assertStatus(302)->assertRedirect(route('departments.index'));
    }
}
