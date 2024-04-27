<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
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
        $user = User::factory()->create();
        $this->actingAs($user);
        $body = [
            'name' => fake()->text,
            'status_id' => TaskStatus::inRandomOrder()->firstOrFail()->id
        ];
        $response = $this->post(route('tasks.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $body);
    }

    public function testShow(): void
    {
        $task = Task::inRandomOrder()->first();
        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::inRandomOrder()->first();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::inRandomOrder()->first();
        $body = [
            'name' => fake()->text,
            'status_id' => TaskStatus::inRandomOrder()->firstOrFail()->id
        ];
        $response = $this->patch(route('tasks.update', $task), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $body['name'],
            'status_id' => $body['status_id']
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = new Task([
            'name' => fake()->text,
            'status_id' => TaskStatus::inRandomOrder()->firstOrFail()->id,
            'created_by_id' => $user->id
        ]);
        $task->save();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
