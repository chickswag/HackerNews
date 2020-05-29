<?php

namespace Tests\Unit;

use App\Comments;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestComments extends TestCase
{

    use RefreshDatabase;
    protected $comments;
    public function setUp(): void
    {

        $this->comments = Comments::create([
            'created_by'    => 'Test',
            'posts_id'      => 1,
            'comment'       => "blah blah blah",
            'created_at'    => Carbon::now(),
            'comment_id'    => 1,
            'belongs_to'    => 1,
            'kids'          =>[30],
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


    public function testCanCreateComment()
    {

        $this->withoutExceptionHandling();
        $formData = [
            'created_by'    => 'Test',
            'posts_id'      => 1,
            'comment'       => "blah blah blah",
            'created_at'    => Carbon::now(),
            'comment_id'    => 1,
            'belongs_to'    => 1,
            'kids'          =>[30],
            'score'         => 100,
            'type'          => "test",
        ];
        $this->comments = Comments::create($formData)
            ->assertOk()
            ->assertJson(['message'=>"Task Created Successfully!!!"]);
    }

}
