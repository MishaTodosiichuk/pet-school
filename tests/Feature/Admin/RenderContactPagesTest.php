<?php

namespace Tests\Feature\Admin;

use App\Models\Contact;
use App\Models\User;
use Tests\TestCase;

class RenderContactPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    public function testRenderIndex(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.contact.index'));

        $response->assertStatus(200);
    }

    public function testRenderEdit(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.contact.edit', $contact->id));

        $response->assertStatus(200);
    }
}
