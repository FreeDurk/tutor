<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Middleware\CheckAdmin;
use App\Http\Requests\TaskDtoRequest;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure we're using the testing environment
        $this->app['env'] = 'testing';
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_task_api_index(): void
    {
        $this->withoutMiddleware(CheckAdmin::class);

        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        Task::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Success',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'status' => ['label', 'value'],
                            'priority' => ['label', 'value'],
                            'order',
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                    'links' => [
                        '*' => ['url', 'label', 'active']
                    ]
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_task_api_store(): void
    {
        $this->withoutMiddleware(CheckAdmin::class);

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $user = User::factory()->create();
        $user->assignRole($adminRole);

        Sanctum::actingAs($user, ['*']);

        $payload = [
            'title' => 'TEST TASK',
            'description' => 'TESTING TASK',
            'status' => "Pending",
            'priority' => "Medium",
            'order' => 1,
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Success',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'status' => ['label', 'value'],
                    'priority' => ['label', 'value'],
                    'order',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
