---
extends: _layouts.post
section: content
title: A Pattern for Building Reusable Create/Update Forms
date: 2019-03-04
description: Create and update forms acting on the same resources very often share much of the same code. This reusable pattern helps keep your code DRY.
categories: [Patterns, Laravel]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

Like a lot of people, I hate working with forms. It's one of those tedious things that almost never gets better. Most projects that accept user input will require one or more forms at some point. And very often, we need to perform the standard CRUD operations on data.

If you do this often enough, you'll soon notice that create and update forms have generally the same fields and the only thing that is different is the action and the form submit endpoint. I admit that through laziness and lack of planning I've duplicated create and update form code often in the past. Here, though, is what I consider a better pattern to deal with this situation, with a minimum of code duplication.

I've been applying this technique a lot in my Laravel projects but it can be used in other frameworks or languages with a few tweaks.

## The Naive Approach

In this example, I have 2 routes, one pointing to the create view, another to the update view, both containing the respective form templates.

** Create View **
```html
@extends('layouts.app')

@section('content')
    <h1>Create Widget</h1>

    <form method="POST" action="{{ route('widget.store') }}">
        @csrf

        <input id="brand" type="text" class="{{ $errors->has('brand') ? ' is-invalid' : '' }}" name="brand" value="{{ old('brand') ?? $widget->brand }}">
        
        ... A LOT OF INPUTS
        
        <button type="submit">Create</button>
    </form>
</section>
@endsection

```

** Update View **
```html
@extends('layouts.app')

@section('content')
    <h1>Edit Widget</h1>

    <form method="POST" action="{{ route('widget.update', $widget->id) }}">
        @csrf
        @method('PATCH')

        <input id="brand" type="text" class="{{ $errors->has('brand') ? ' is-invalid' : '' }}" name="brand" value="{{ old('brand') ?? $widget->brand }}">
        
        ... A LOT OF INPUTS
        
        <button type="submit">Update</button>
    </form>
</section>
@endsection

```

It quickly becomes obvious that the only difference between the two forms is the method (`POST` vs `PATCH`) and the route (`route('widget.create')` vs `route('widget.update', $widget->id)`). Maybe this isn't as noticeable for short 1-2 field forms, but when you have lots of them, the pain gets real.

There must be a better way to de-duplicate the markup, right? There is.

## The Better Approach

The much more elegant solution is to extract the common form markup into a Blade partial and to include this partial, along with some metadata, in the original create/update views.  

** New Create View **
```html
@extends('layouts.app')

@section('content')
    <h1>Create Widget</h1>

    <form method="POST" action="{{ route('widget.store') }}">
        @csrf

        @include('partials._form', [
            'widget' => new \App\Widget(),
            'btnText' => 'Create',
        ])
    </form>
</section>
@endsection
```

** New Update View **
```html
@extends('layouts.app')

@section('content')
    <h1>Edit Widget</h1>

    <form method="POST" action="{{ route('widget.update', $widget->id) }}">
        @csrf
        @method('PATCH')

        @include('partials._form', [
            'btnText' => 'Update',
        ])
    </form>
</section>
@endsection
```

** `_form.blade.php` Partial **
```html
<input id="brand" type="text" class="{{ $errors->has('brand') ? ' is-invalid' : '' }}" name="brand" value="{{ old('brand') ?? $widget->brand }}">

... A LOT OF INPUTS

<button type="submit">
    {{ __($btnText) }}
</button>
``` 

With this new approach we use the exact same form input markup for both forms. The form tags along with the `csrf` and `method` inputs are now the skeleton containing the partial we extracted.

To allow the value of the field to be pre-populated if it exists (`old('brand') ?? $widget->brand`), we either pass the `$widget` model for an existing item, or we instantiate a new model when creating a new item.

For other differences between the two forms, we can pass data to the partial in an array, like we did here for the submit button label in the form of `btnText`.

## In Closing

It's worth thinking about duplication ahead of time. Often we start building a form, template, controller or other logic and then we add a very similar behaviour for a different route or model or entity, only to realize that they both operate in a very similar manner. Good planning is easier said than done but it's never too late to go back and do some refactoring. For my part, I always try to keep my code as DRY as possible. 