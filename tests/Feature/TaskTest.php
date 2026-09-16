<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task_with_name_and_deadline(): void
    {
        $project = Project::create(['name' => 'Project Alpha']);

        $response = $this->from(route('projects.show', $project))
            ->post(route('tasks.store', $project), [
                'name' => 'Fix routing discrepancies',
                'deadline' => '2026-09-30',
            ]);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Fix routing discrepancies',
            'deadline' => '2026-09-30 00:00:00',
            'is_done' => false,
        ]);
    }

    public function test_can_create_task_using_title_attribute_for_spec_compatibility(): void
    {
        $project = Project::create(['name' => 'Project Beta']);

        $response = $this->post(route('tasks.store', $project), [
            'title' => 'Design user interface',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Design user interface',
            'deadline' => null,
            'is_done' => false,
        ]);
    }

    public function test_can_create_task_without_deadline(): void
    {
        $project = Project::create(['name' => 'Project Gamma']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => 'Ongoing maintenance task',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Ongoing maintenance task',
            'deadline' => null,
        ]);
    }

    public function test_task_creation_requires_name_or_title(): void
    {
        $project = Project::create(['name' => 'Project Delta']);

        $response = $this->post(route('tasks.store', $project), []);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_can_toggle_task_status_to_completed(): void
    {
        $project = Project::create(['name' => 'Project Epsilon']);
        $task = $project->tasks()->create([
            'name' => 'Write documentation',
            'is_done' => false,
        ]);

        $response = $this->from(route('projects.show', $project))
            ->patch(route('tasks.toggle', $task));

        $response->assertRedirect(route('projects.show', $project));
        $this->assertTrue($task->fresh()->is_done);
    }

    public function test_can_toggle_task_status_back_to_incomplete(): void
    {
        $project = Project::create(['name' => 'Project Zeta']);
        $task = $project->tasks()->create([
            'name' => 'Test deployment',
            'is_done' => true,
        ]);

        $response = $this->patch(route('tasks.toggle', $task));

        $response->assertSessionHas('success');
        $this->assertFalse($task->fresh()->is_done);
    }

    public function test_task_mass_assignment_supports_title_directly(): void
    {
        $project = Project::create(['name' => 'Project Direct Title']);
        $task = $project->tasks()->create(['title' => 'Created via title mass assignment']);

        $this->assertEquals('Created via title mass assignment', $task->name);
        $this->assertEquals('Created via title mass assignment', $task->title);
    }

    public function test_task_title_mutator_does_not_overwrite_valid_name_with_null(): void
    {
        $task = new Task(['name' => 'Persistent Name', 'title' => null]);
        $this->assertEquals('Persistent Name', $task->name);
    }

    public function test_task_serialization_includes_title_attribute(): void
    {
        $project = Project::create(['name' => 'Project Serialize']);
        $task = $project->tasks()->create(['name' => 'Serialization Test Task']);

        $array = $task->toArray();
        $this->assertArrayHasKey('title', $array);
        $this->assertEquals('Serialization Test Task', $array['title']);
    }

    public function test_can_create_task_when_name_is_empty_but_title_is_provided(): void
    {
        $project = Project::create(['name' => 'Project Fallback']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => '',
            'title' => 'Title takes over',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Title takes over',
        ]);
    }

    public function test_task_creation_validates_max_length(): void
    {
        $project = Project::create(['name' => 'Project Max Len']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => str_repeat('x', 256),
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_creation_validates_deadline_format(): void
    {
        $project = Project::create(['name' => 'Project Invalid Date']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => 'Task with bad date',
            'deadline' => 'not-a-valid-date',
        ]);

        $response->assertSessionHasErrors('deadline');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_toggle_redirect_falls_back_to_project_show_when_referrer_missing(): void
    {
        $project = Project::create(['name' => 'Project Fallback Referrer']);
        $task = $project->tasks()->create(['name' => 'Fallback Task']);

        $response = $this->patch(route('tasks.toggle', $task));

        $response->assertRedirect(route('projects.show', $project));
    }

    public function test_toggle_non_existent_task_returns_404(): void
    {
        $response = $this->patch('/tasks/99999/toggle');

        $response->assertStatus(404);
    }

    public function test_empty_string_deadline_is_saved_as_null_and_does_not_evaluate_to_today(): void
    {
        $project = Project::create(['name' => 'Project Date Cast']);
        $task = $project->tasks()->create([
            'name' => 'No Deadline String',
            'deadline' => '',
        ]);

        $this->assertNull($task->deadline);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'deadline' => null,
        ]);
    }

    public function test_carbon_instance_assigned_to_deadline_persists_cleanly(): void
    {
        $project = Project::create(['name' => 'Project Carbon Deadline']);
        $targetDate = now()->addDays(7)->startOfDay();

        $task = $project->tasks()->create([
            'name' => 'Carbon Deadline Task',
            'deadline' => $targetDate,
        ]);

        $this->assertNotNull($task->deadline);
        $this->assertEquals($targetDate->format('Y-m-d'), $task->deadline->format('Y-m-d'));
    }

    public function test_task_title_update_updates_name_attribute_and_persists(): void
    {
        $project = Project::create(['name' => 'Project Title Update']);
        $task = $project->tasks()->create(['name' => 'Old Task Name']);

        $task->update(['title' => 'Updated via Title Field']);

        $this->assertEquals('Updated via Title Field', $task->fresh()->name);
        $this->assertEquals('Updated via Title Field', $task->fresh()->title);
    }

    public function test_whitespace_title_does_not_overwrite_valid_name(): void
    {
        $project = Project::create(['name' => 'Project Whitespace Title']);
        $task = $project->tasks()->create(['name' => 'Solid Name']);

        $task->title = '   ';
        $task->save();

        $this->assertEquals('Solid Name', $task->fresh()->name);
    }

    public function test_task_query_scopes_where_title_and_title_resolve_correctly(): void
    {
        $project = Project::create(['name' => 'Project Scope Title']);
        $task = $project->tasks()->create(['name' => 'Unique Scoped Task']);

        $foundByWhereTitle = Task::whereTitle('Unique Scoped Task')->first();
        $foundByTitleScope = Task::title('Unique Scoped Task')->first();

        $this->assertNotNull($foundByWhereTitle);
        $this->assertEquals($task->id, $foundByWhereTitle->id);

        $this->assertNotNull($foundByTitleScope);
        $this->assertEquals($task->id, $foundByTitleScope->id);
    }

    public function test_task_creation_fails_when_both_name_and_title_are_whitespace_only(): void
    {
        $project = Project::create(['name' => 'Project Blank Whitespace']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => '   ',
            'title' => '   ',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_creation_with_empty_deadline_string_via_http_stores_null(): void
    {
        $project = Project::create(['name' => 'Project Http Blank Deadline']);

        $response = $this->post(route('tasks.store', $project), [
            'name' => 'Web Form Task With Empty Deadline',
            'deadline' => '',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'Web Form Task With Empty Deadline',
            'deadline' => null,
        ]);
    }
}
