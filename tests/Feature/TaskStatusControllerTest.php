<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
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
        $body = TaskStatus::factory()->make()->only('name');
        $response = $this->post(route('task_statuses.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', $body);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $response = $this->get(route('task_statuses.edit', $taskStatus));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $body = TaskStatus::factory()->make()->only('name');
        $response = $this->patch(route('task_statuses.update', $taskStatus), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', [
            'id' => $taskStatus?->id,
            'name' => $body['name']
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }
}
