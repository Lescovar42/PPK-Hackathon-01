<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_collaboration_page_and_links_back_to_project_view(): void
    {
        $project = Project::create(['name' => 'Collab Alpha']);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.collaboration');
        $response->assertSee('Collab Alpha');
        // Verify it links back to project view
        $response->assertSee(route('projects.show', $project));
    }

    public function test_progress_calculation_with_mixed_tasks(): void
    {
        $project = Project::create(['name' => 'Progress Test Project']);
        $project->tasks()->create(['name' => 'Task 1', 'is_done' => true]);
        $project->tasks()->create(['name' => 'Task 2', 'is_done' => false]);
        $project->tasks()->create(['name' => 'Task 3', 'is_done' => true]);
        $project->tasks()->create(['name' => 'Task 4', 'is_done' => false]);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $this->assertEquals(4, $response->viewData('totalTasks'));
        $this->assertEquals(2, $response->viewData('completedTasks'));
        $this->assertEquals(50, $response->viewData('progress'));
        $response->assertSee('<strong>2</strong> dari <strong>4</strong>', false);
        $response->assertSee('50%');
    }

    public function test_progress_calculation_with_zero_tasks_avoids_division_by_zero(): void
    {
        $project = Project::create(['name' => 'Zero Tasks Project']);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $this->assertEquals(0, $response->viewData('totalTasks'));
        $this->assertEquals(0, $response->viewData('completedTasks'));
        $this->assertEquals(0, $response->viewData('progress'));
        $response->assertSee('0%');
    }

    public function test_can_add_member_to_project(): void
    {
        $project = Project::create(['name' => 'Team Project']);
        $user = User::factory()->create([
            'name' => 'John Collaborator',
        ]);

        $response = $this->post(route('projects.members.add', $project), [
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('projects.collaboration', $project));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($project->users->contains($user));
    }

    public function test_cannot_add_non_existent_user_as_member(): void
    {
        $project = Project::create(['name' => 'Invalid User Collab']);

        $response = $this->post(route('projects.members.add', $project), [
            'user_id' => 99999,
        ]);

        $response->assertSessionHasErrors('user_id');
        $this->assertDatabaseCount('project_user', 0);
    }

    public function test_adding_duplicate_member_is_idempotent(): void
    {
        $project = Project::create(['name' => 'Idempotent Collab']);
        $user = User::factory()->create();

        // Add member first time
        $this->post(route('projects.members.add', $project), ['user_id' => $user->id]);

        // Add member second time
        $response = $this->post(route('projects.members.add', $project), ['user_id' => $user->id]);

        $response->assertRedirect(route('projects.collaboration', $project));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('project_user', 1);
    }

    public function test_collaboration_page_renders_gracefully_when_no_users_exist(): void
    {
        $project = Project::create(['name' => 'No Users Collab']);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $response->assertSee('Belum ada pengguna terdaftar');
    }

    public function test_collaboration_non_existent_project_returns_404(): void
    {
        $response = $this->get('/projects/99999/collaboration');

        $response->assertStatus(404);
    }

    public function test_add_member_requires_user_id(): void
    {
        $project = Project::create(['name' => 'Validation Member Project']);

        $response = $this->post(route('projects.members.add', $project), []);

        $response->assertSessionHasErrors('user_id');
        $this->assertDatabaseCount('project_user', 0);
    }

    public function test_progress_calculation_reaches_one_hundred_percent(): void
    {
        $project = Project::create(['name' => 'Fully Done Project']);
        $project->tasks()->create(['name' => 'T1', 'is_done' => true]);
        $project->tasks()->create(['name' => 'T2', 'is_done' => true]);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $this->assertEquals(2, $response->viewData('totalTasks'));
        $this->assertEquals(2, $response->viewData('completedTasks'));
        $this->assertEquals(100, $response->viewData('progress'));
        $response->assertSee('100%');
    }

    public function test_collaboration_page_displays_current_members_and_emails(): void
    {
        $project = Project::create(['name' => 'Member Display Project']);
        $user = User::factory()->create([
            'name' => 'Alice Collaborator',
            'email' => 'alice@collab.test',
        ]);
        $project->users()->attach($user->id);

        $response = $this->get(route('projects.collaboration', $project));

        $response->assertStatus(200);
        $response->assertSee('Alice Collaborator');
        $response->assertSee('alice@collab.test');
    }
}
