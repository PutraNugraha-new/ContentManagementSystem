<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostControllerTest extends TestCase
{
    public function testIndex()
    {
        $user = User::factory()->create(); // Menggunakan factory untuk membuat pengguna
        $this->actingAs($user); // Mensimulasikan pengguna yang terautentikasi

        // Melakukan permintaan GET ke route 'posts.index'
        $response = $this->get(route('posts.index'));

        // Memastikan status respons adalah 200
        $response->assertStatus(200);
        // Memastikan view memiliki data 'posts'
        $response->assertViewHas('posts');
    }
}
