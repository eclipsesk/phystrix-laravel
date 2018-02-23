# Laravel binding for phystrix Package

## Installation

```sh
composer require eclipsesk/phystrix-laravel
artisan vendor publish
```

## Usage

```php
use Eclipsesk\Phystrix\Phystrix;

class MyController extends Controller
{
    public function index(Phystrix $phystrix)
    {
        $myCommand = $phystrix->getCommand(MyCommand::class);
        
        $result = $myCommand->execute();
    }
}
```
