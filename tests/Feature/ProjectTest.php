<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_project_index(): void
    {
        $project = Project::create(['name' => 'Alpha Project']);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.index');
        $response->assertSee('Alpha Project');
        $response->assertSee(route('projects.show', $project));
    }

    public function test_can_create_new_project(): void
    {
        $response = $this->post(route('projects.store'), [
            'name' => 'Beta Project',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'name' => 'Beta Project',
        ]);
    }

    public function test_create_project_requires_valid_name(): void
    {
        $response = $this->post(route('projects.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_can_view_project_show_via_route_model_binding(): void
    {
        $project = Project::create(['name' => 'Gamma Project']);

        $task1 = $project->tasks()->create([
            'name' => 'Task 1',
            'deadline' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $task2 = $project->tasks()->create([
            'name' => 'Task 2',
            'deadline' => now()->addDays(1)->format('Y-m-d'),
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $response->assertSee('Gamma Project');
        $response->assertSee('Task 1');
        $response->assertSee('Task 2');

        // Check tasks are ordered by deadline asc
        $responseTasks = $response->viewData('tasks');
        $this->assertCount(2, $responseTasks);
        $this->assertEquals($task2->id, $responseTasks->first()->id);
        $this->assertEquals($task1->id, $responseTasks->last()->id);
    }

    public function test_project_show_with_no_tasks_renders_cleanly(): void
    {
        $project = Project::create(['name' => 'Empty Project']);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $response->assertSee('Empty Project');
    }

    public function test_show_non_existent_project_returns_404(): void
    {
        $response = $this->get('/projects/99999');

        $response->assertStatus(404);
    }

    public function test_cannot_create_project_with_oversized_name(): void
    {
        $response = $this->post(route('projects.store'), [
            'name' => str_repeat('p', 256),
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_deleting_project_cascades_tasks_cleanly(): void
    {
        $project = Project::create(['name' => 'Project to delete']);
        $task = $project->tasks()->create(['name' => 'Task in project']);

        $project->delete();

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_cannot_create_project_with_whitespace_name(): void
    {
        $response = $this->post(route('projects.store'), [
            'name' => '   ',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_project_index_displays_task_counts_correctly(): void
    {
        $project = Project::create(['name' => 'Multi Task Project']);
        $project->tasks()->create(['name' => 'T1']);
        $project->tasks()->create(['name' => 'T2']);
        $project->tasks()->create(['name' => 'T3']);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertSee('Multi Task Project');
        $response->assertSee('3');
    }

    public function test_project_show_displays_task_status_and_action_buttons(): void
    {
        $project = Project::create(['name' => 'Show View Project']);
        $task = $project->tasks()->create([
            'name' => 'Pending Verification Task',
            'is_done' => false,
            'deadline' => '2026-11-20',
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertSee('Pending Verification Task');
        $response->assertSee('Belum Selesai');
        $response->assertSee('Tandai Selesai');
        $response->assertSee('2026-11-20');
    }
}
