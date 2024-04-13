<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Database\Seeders\LabelSeeder;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $name = fake()->text();
        $response = $this->post(route('labels.store', compact('name')));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', compact('name'));
    }

    public function testEdit(): void
    {
        $this->seed(LabelSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::inRandomOrder()->first();
        $response = $this->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $this->seed(LabelSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::inRandomOrder()->first();
        $name = fake()->text();
        $response = $this->patch(route('labels.update', $label), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', compact('name'));
    }

    public function testDestroy(): void
    {
        $this->seed(LabelSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);
        $label = Label::inRandomOrder()->first();
        $response = $this->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
