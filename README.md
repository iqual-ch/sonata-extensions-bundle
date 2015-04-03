# Installation

```bash
composer require mpom/sonata-extensions-bundle
```

Add to your AppKernel.php:
```php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new SonataExtensionsBundle\SonataExtensionsBundle,
            // ...
        )
    }
```

See Resources/doc/index.md for documentation.