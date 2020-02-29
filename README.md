Laravel Gate Cache
==================

Add a per-request caching layer to Laravel's Gate. 

## Compatibility Chart

| Laravel Gate Cache | Laravel |
|--------------------|---------|
| **1.x**            | 5.5-5.7 |
| **2.x**            | 5.5+    |

| Laravel Gate Cache |   PHP   |
|--------------------|---------|
| **1.x**            | 7.0+    |
| **2.x**            | 7.1+    |

**NB:** Laravel 5.5.* and PHP 7.4 cannot be tested due to deprecations.

## Installing

Require the project using [Composer](https://getcomposer.org):

```bash
$ composer require rickselby/laravel-gate-cache
```

Laravel will auto-discover the package.

## Use Case

As discussed on [reddit](https://www.reddit.com/r/laravel/comments/9mknx6/) - multiple calls to `Gate` methods result in the underlying code being re-run. Take this pseudo-blade-code, for example:

```
@foreach($posts as $post)
    @can('add_posts') BUTTON @endcan
    @can('edit_posts') BUTTON @endcan
    @can('delete_posts') BUTTON @endcan
@endforeach
```

Normally, each permission check would be called as many times as there are posts. With this package, they will only be called once; their results will be cached for any further calls.

Note that this is per-request only. Each request will test each permission once... but only once.

## License

Laravel Form Components is licensed under [The MIT License (MIT)](LICENSE).
