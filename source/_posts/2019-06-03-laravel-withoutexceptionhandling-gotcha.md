---
extends: _layouts.post
section: content
title: Laravel withoutExceptionHandling() Gotcha
date: 2019-06-03
description: Interesting behavior I came across while using Laravel's withoutExceptionHandling() method to help debug tests.
categories: [Laravel, Testing]
featured: false
image: /assets/img/2019-06-03-laravel-withoutexceptionhandling-gotcha.png
image_thumb: /assets/img/2019-06-03-laravel-withoutexceptionhandling-gotcha.png
image_author:
image_author_url:
image_unsplash:
---

Laravel offers a nice helper method that you can use temporarily in your tests to turn off exception handling by the framework. What happens in certain cases is that you won't see the actual error that triggered the exception, but merely the exception itself. This method can be called from inside a test as follows:
 
```php
$this->withoutExceptionHandling();
```

This is particularly useful in situations which trigger a `500 Server Error` that doesn't offer much context. Of course, you can dig through the logs, but it's a lot quicker to be able to see the error output when you're running the test.

I've been using this technique for a while now but it hadn't occurred to me that it matters *where* you place the call within your test.

Here's the scenario that brought me to this realization. Imagine that I am using TDD to test logic for a simple blog, more specifically that I can create a new post. And this is how I would write a basic test in Laravel for this functionality.

```php
/**
* @test
*/
public function as_an_authenticated_user_i_can_create_a_post()
{
    $this
        ->post('/posts/store')
        ->assertRedirect('/login');

    $body = [
        'title' => 'A new post',
        'contents' => 'Post content',
    ];

    $this
        ->actingAs($this->bob)
        ->post('/posts/store', $body)
        ->assertRedirect('/posts');

    $this->assertDatabaseHas('posts', $body);
}
```

My test has 3 assertions. First, I'm making sure that an unauthenticated user cannot create a post - they are redirected to the login page. Second, as an authenticated user, I want to be redirected to the list of posts after successfully creating a new post. Third, I also want to make sure that the post data was saved to the database.

Running this test produces the following error:

```bash
Response status code [500] is not a redirect status code.
Failed asserting that false is true.
...
```

Well, that's not very helpful. `$this->withoutExceptionHandling();` to the rescue! I plug it in quickly as the first line in my test and...

```php
public function i_can_create_a_post()
{
    $this->withoutExceptionHandling();
    ...
``` 

... the output is not what I would expect.

**Output**

```bash
There was 1 error:

1) Tests\Feature\ExampleTest::i_can_create_a_post
Illuminate\Auth\AuthenticationException: Unauthenticated.
...

```

Um... what gives? I already know that my first assertion passed. I know that because I wrote that statement first and the test was green. After writing the next 2 assertions, it went red. It looks like it catches the first action/assertion:

```php
$this
    ->post('/posts/store')
    ->assertRedirect('/login');
```

Instead of the second action/assertion (which is what triggers the `500 Server Error`):

```php
$this
    ->actingAs($this->bob)
    ->post('/posts/store', $body)
    ->assertRedirect('/posts');
```

So it turns out that `withoutExceptionHandling` needs to be right above the piece of code that fails, and not at the beginning of the test, as I had thought until now. Correcting my mistake:

```php
...
$this->withoutExceptionHandling();
$this
    ->actingAs($this->bob)
    ->post('/posts/store', $body)
    ->assertRedirect('/posts');
...
```

**Output**

Ah, this is the real issue.
           
```bash
There was 1 error:

1) Tests\Feature\ExampleTest::i_can_create_a_post
Illuminate\Database\QueryException: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'content' in 'field list' (SQL: insert into `posts` (`user_id`, `title`, `content`, `updated_at`, `created_at`) values (3, A new post, Post content, 2019-06-02 15:40:01, 2019-06-02 15:40:01))
...
Caused by
PDOException: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'content' in 'field list'
...
```

That's more like it. This was the error I was looking for, and it makes all the sense in the world. Notice the little typo `contents` vs `content`.

And that's all there is to it. By discovering this, `withoutExceptionHandling`'s utility has increased in my eyes.

On a final note, `withoutExceptionHandling` takes an additional argument, which is an array of exceptions that you want it to ignore. If you want to find out more about the inner workings of this function, you can find it at `vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/InteractsWithExceptionHandling.php`.
