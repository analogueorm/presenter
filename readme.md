# Analogue Presenter

*Based heavily on [Jeffrey Way's Easy View Presenters for Laravel](https://github.com/laracasts/Presenter)*

So you have those scenarios where a bit of logic needs to be performed before some data (likely from your entity) is displayed from the view.

- Should that logic be hard-coded into the view? *No*.
- Should we instead store the logic in the model? *No again!*

Instead, leverage view presenters. That's what they're for! This package provides one such implementation.

## Install

Pull this package in through Composer.

```js
{
    "require": {
        "analogueorm/presenter": "0.2.*"
    }
}
```

## Usage

The first step is to store your presenters somewhere - anywhere. These will be simple objects that do nothing more than format data, as required.

Here's an example of a presenter.

```php
use Analogue\Presenter\Presenter;

class UserPresenter extends Presenter {

    public function fullName()
    {
        return $this->entity->first . ' ' . $this->entity->last;
    }

    public function accountAge()
    {
        return $this->entity->created_at->diffForHumans();
    }

}
```

Next, on your entity, pull in the `Analogue\Presenter\Presentable` trait.

Here's an example - maybe an Analogue `User` entity.

```php
<?php

use Analogue\ORM\Entity;
use Analogue\Presenter\Presentable;

class User extends Entity {

    use Presentable;
}
```

Then, add a `public $presentable` property to the relevant entity map:

```php
<?php

use Analogue\ORM\EntityMap;

// the UserPresenter class we created above
use App\Http\Presenters\UserPresenter;

class UserMap extends EntityMap
{
    public $presenter = UserPresenter::class;

    // ...
}
```

That's it! You're done. Now, within your controller/view, you can do:

```php
// in some controller
return view("user", ["user" => $user->present()]);
```

```php
<h1>Hello, {{ $user->fullName() }}</h1>
```

The Presenter will also pass through any calls to entity properties: e.g. `$user->present()->first()` would return the `$user->first` property - this is useful if you pass the presenter, rather than the entity, into your template.

## Laravel Integration

There is also a `PresentBladeServiceProvider` included for use with Laravel and the Blade templating language.

This adds a `@presenteach` and `@endpresenteach` directive, which allows you to easily iterate over the presenters for each entity in a collection:

```php
// config/app.php
'providers' => [
    // ...
    Analogue\Presenter\PresentBladeServiceProvider::class,
]
```

```blade
<ul>
@presenteach ($users as $user)
    <li>{{ $user->fullName() }}</li>
@endpresenteach
</ul>
```
