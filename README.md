# Laravel Router - Sellarix

---
- name: Sellarix
- github_url: https://github.com/sellarix/laravel-router
- linkedin_url: https://www.linkedin.com/company/sellarix-ltd/
---

This package allows you to create dynamic URL based routes and redirects. 

Connect the trait to a model that needs database handled routing.  

Fully filament compatible.

- Create url and canonical urls
- Update urls and keep the previous redirect
- create custom redirects

## Installation

```json
 "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/sellarix/laravel-router.git"
    }
  ],
```

```bash
composer require sellarix/package-router
```
## Usage

Start by adding UseRouting trait to any of your models you wish to contain a slug or generate url column

```php
    use UsesRouting;
```

Then implement the abstract requirements

```php
    private string $viewMethod = 'show'; // The method to call on the controller

    public function getSlugUrlFunction()
    {
        return $this->getUrl(); // return the url of the primary format such as `hello-world`
    }

    public function getBaseUrlFunction()
    {
        return $this->getCanonicalLink(); // return the canonical url such as `page/id/0`
    }


    public function getViewController()
    {
        return Controller::class; // return the controller you wish to use to view your model
    }
```
