<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);
        $name = fake()->text();
        $status_id = TaskStatus::inRandomOrder()->first()->id;
        $response = $this->post(route('tasks.store', compact('name', 'status_id')));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', compact('name'));
    }

    public function testShow(): void
    {
        $this->seed();
        $task = Task::inRandomOrder()->first();
        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::inRandomOrder()->first();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::inRandomOrder()->first();
        $name = fake()->text();
        $status_id = TaskStatus::inRandomOrder()->first()->id;
        $response = $this->patch(route('tasks.update', $task), compact('name', 'status_id'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', compact('name'));
    }

    public function testDestroy(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::inRandomOrder()->first();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
