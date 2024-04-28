<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $body = Label::factory()->make()->only('name');
        $response = $this->post(route('labels.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', $body);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::inRandomOrder()->first();
        $response = $this->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::inRandomOrder()->first();
        $body = Label::factory()->make()->only('name');
        $response = $this->patch(route('labels.update', $label), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', [
            'id' => $label?->id,
            'name' => $body['name']
        ]);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::factory()->create();
        $response = $this->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
