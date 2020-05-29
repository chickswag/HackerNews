<?php

namespace Tests\Unit;

use App\Posts;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestPosts extends TestCase
{
    use RefreshDatabase;
    protected $posts;
    public function setUp(): void
    {
        parent::setUp();
        $this->posts = Posts::create([
            'created_by'    => 'Test',
            'post_id'       => 1,
            'title'         => "testing the post",
            'created_at'    => Carbon::now(),
            'comment_ids'   => [1,2,3],
            'url'           => "http://testing.test.com",
            'comment_count' =>30,
            'score'         => 100,
            'type'          => "test",
        ]);


    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testPostsRedirectsToPosts()
    {
        $this->get('/')->assertRedirect('/Posts');
    }

    public function testCanCreateTask()
    {

        $this->withoutExceptionHandling();
        $formData = [
            'created_by'    => 'Test',
            'post_id'       => 1,
            'title'         => "testing the post",
            'created_at'    => Carbon::now(),
            'comment_ids'   => [1,2,3],
            'url'           => "http://testing.test.com",
            'comment_count' =>30,
            'score'         => 100,
            'type'          => "test",
        ];
        $this->posts = Posts::create($formData)
            ->assertOk()
            ->assertJson(['message'=>"Post Created Successfully!!!"]);
    }


}
