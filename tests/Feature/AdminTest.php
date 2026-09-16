<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_route_renders_landing_page_without_duplicating_admin(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSee(route('projects.index'));
        $response->assertSee(route('admin.index'));
        // Verify it is not the admin account management panel
        $response->assertDontSee('Manajemen Akun (Admin)');
    }

    public function test_can_view_admin_user_list(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Administrator',
            'email' => 'jane@example.com',
            'role' => 'admin',
        ]);

        $response = $this->get(route('admin.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertSee('Jane Administrator');
        $response->assertSee('jane@example.com');
        $response->assertSee('admin');
        $response->assertSee(route('admin.destroy', $user));
    }

    public function test_can_create_user_via_admin(): void
    {
        $response = $this->post(route('admin.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'user',
        ]);
    }

    public function test_cannot_create_user_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post(route('admin.store'), [
            'name' => 'Another User',
            'email' => 'duplicate@example.com',
            'role' => 'user',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_can_delete_user_via_route_model_binding(): void
    {
        $user = User::factory()->create([
            'name' => 'User To Delete',
            'email' => 'delete_me@example.com',
        ]);

        $response = $this->delete(route('admin.destroy', $user));

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_path_redirects_to_admin_index(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.index'));
    }

    public function test_cannot_create_user_with_invalid_role(): void
    {
        $response = $this->post(route('admin.store'), [
            'name' => 'Hacker User',
            'email' => 'hacker@example.com',
            'role' => 'superuser',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'hacker@example.com']);
    }

    public function test_deleting_user_associated_with_projects_cascades_pivot_cleanly(): void
    {
        $user = User::factory()->create();
        $project = Project::create(['name' => 'User Pivot Project']);
        $project->users()->attach($user->id);

        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);

        $response = $this->delete(route('admin.destroy', $user));

        $response->assertRedirect(route('admin.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('project_user', ['user_id' => $user->id]);
    }

    public function test_delete_non_existent_user_returns_404(): void
    {
        $response = $this->delete('/admin/users/99999');

        $response->assertStatus(404);
    }
}
