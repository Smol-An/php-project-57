<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Database\Seeders\TaskStatusSeeder;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $name = fake()->text();
        $response = $this->post(route('task_statuses.store', compact('name')));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testEdit(): void
    {
        $this->seed(TaskStatusSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $response = $this->get(route('task_statuses.edit', $taskStatus));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $this->seed(TaskStatusSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $name = fake()->text();
        $response = $this->patch(route('task_statuses.update', $taskStatus), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testDestroy(): void
    {
        $this->seed(TaskStatusSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::inRandomOrder()->firstOrFail();
        $response = $this->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }
}
