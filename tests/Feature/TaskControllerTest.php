<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $this->actingAs($this->user);
        $body = Task::factory()->make()->only('name', 'status_id');
        $response = $this->post(route('tasks.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $body);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', ['task' => $this->task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', ['task' => $this->task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user);
        $body = Task::factory()->make()->only('name', 'status_id');
        $response = $this->patch(route('tasks.update', ['task' => $this->task]), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id,
            'name' => $body['name'],
            'status_id' => $body['status_id']
        ]);
    }

    public function testDestroy(): void
    {
        $this->actingAs($this->user);
        $ownTask = Task::factory()->for($this->user, 'createdBy')->create();
        $response = $this->delete(route('tasks.destroy', $ownTask));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $ownTask->id]);
    }
}
