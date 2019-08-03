---
extends: _layouts.post
section: content
title: Disable Submit Button on Form Submit with JavaScript
date: 2019-07-21
description: A technique to prevent multiple form submission.
categories: [JavaScript]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

## The problem

Let's say you have a simple form with a plain old submit to the server without Ajax. Sometimes the process take up to a second or even more, depending on the payload. Obviously if you're sending a file it will take longer. During that time, it is possible for the user to hit the submit button multiple times, whether by accident or intentionally. In that case, the server will receive multiple submissions of the same form data.

## The solution (or one of them)

A solution that I've employed often to ensure the form is submitted only one time - not because it's the best but because it's the quickest technique to reach for - is to disable the submit button once it's clicked. Since this is a server-side request, I am not too worried that the request will fail and the button will remain disabled.

Give the following HTML for our form:

```html
<form method="post" action="/">
    <button id="butt" type="submit">Submit</button>
</form>
```

We could use JavaScript to disable the button like so:

```javascript
var butt = document.getElementById('butt');

butt.addEventListener('click', function(event) {
    event.target.disabled = true;
});
```

The sequence of events goes something like this: the user clicks the button → the button is disabled → the form gets submitted → the server handles the request → it redirects wherever it is meant to.

That should be the end of the story. But wait, there's more!

## Chrome vs Firefox vs Safari

Unfortunately this little snippet does not work consistently across browsers. As of this writing, I tested this in the desktop versions of Chrome 75, Firefox 67, and Safari 12.

In **Chrome** or **Safari**, clicking the button will disable it but NOT submit the form. In **Firefox**, the behavior is as expected: click - disable - submit.

[Try it out for yourself on Codepen](https://codepen.io/anon/pen/rEXPMN?editors=1010). If it's not immediately obvious what happens, in Chrome/Safari, after the button is disabled, it remains on the screen (meaning the form wasn't submitted). In Firefox, it is disabled and then it disappears (meaning the form was submitted).

## The improved solution

What does one do when confronted with a situation like this, and they're not a JavaScript grandmaster? Well, reach for *the ol' `setTimeout` trick*, of course.

I suspect this situation has something to do with JavaScript's async nature, yada yada (correct me if I'm wrong). To break out of that behavior for this situation, and make the sequence of events synchronous, just wrap the offending code in a `setTimeout 0` statement, like so:

```javascript
var butt = document.getElementById('butt');

butt.addEventListener('click', function(event) { 
    setTimeout(function () {
        event.target.disabled = true;
    }, 0);
});
```

Or 1337 ES6 1-liner (I'm sure someone will find an even shorter way to write this):

```javascript
document.getElementById('butt').addEventListener('click', event => setTimeout(() => event.target.disabled = true, 0));
```

Codepen for both [long form](https://codepen.io/anon/pen/NZQoLm?editors=1010) and [1337 version](https://codepen.io/anon/pen/mNejbP?editors=1010).

Now the behavior is consistent in all browsers: click → disable → submit. Say what you will, but I've used this trick often when I run into similar situations and it works without fail.
