Laravel Gate Cache
==================

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
![Packagist Version](https://img.shields.io/packagist/v/rickselby/laravel-gate-cache)

Add a per-request caching layer to Laravel's Gate. 

| Laravel Auto Presenter Mapper | Laravel |
|-------------------------------|---------|
| **3.x**                       | 5.5-9.x |
| 2.x                           | 5.5-5.8 |
| 1.x                           | 5.5-5.7 |

## Installing

Require the project using [Composer](https://getcomposer.org):

```bash
$ composer require rickselby/laravel-gate-cache
```

Laravel will auto-discover the package.

## Use Case

As discussed on [reddit](https://www.reddit.com/r/laravel/comments/9mknx6/) - multiple calls to `Gate` methods 
result in the underlying code being re-run. Take this pseudo-blade-code, for example:

```
@foreach($posts as $post)
    @can('add_posts') BUTTON @endcan
    @can('edit_posts') BUTTON @endcan
    @can('delete_posts') BUTTON @endcan
@endforeach
```

Normally, each permission check would be called as many times as there are posts. With this package, 
they will only be called once; their results will be cached for any further calls.

Note that this is per-request only. Each request will test each permission once... but only once.

## License

Laravel Form Components is licensed under [The MIT License (MIT)](LICENSE).
