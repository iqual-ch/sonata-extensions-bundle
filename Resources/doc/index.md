#SonataExtenisonsBundle provides some useful extensions to the Sonata project.

###Overview
1. Installation and setup
2. [Form types](form-types.md)
3. Layout and assets
4. Frontend translations

### Installation

1. download bundle, install and enable bundle;
2. your admin layout template must extend `SonataExtensionsBundle::layout.html.twig`;
3. add `SonataExtensionsBundle:Form:widgets.html.twig` to `twig.form.resources` config option. This will enable custom widgets.


### Layout and assets

This bundle uses Assetic for asset management.

##### Styles and Javascript
In your layout file override block _stylesheets_ or _javascripts_ and add any content you need

```twig
{% block stylesheets %}
    {{ parent() }}
    {% stylesheets 
        '@AppBundle/Resources/public/css/admin/styles.less' 
        filter='cssrewrite' %}
    <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    {% javascripts 
        '@AppBundle/Resources/public/js/*' 
        '@AppBundle/Resources/public/js/*/*' 
        '@AppBundle/Resources/public/js/*/*/*' 
        '@AppBundle/Resources/public/js/*/*/*/*' 
        '@AppBundle/Resources/public/js/*/*/*/*/*' 
        '@AppBundle/Resources/public/js/*/*/*/*/*/*' 
         %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}
```

###Frontend Translations

Bundle provides translation support on frontend. Create a new translation file for domain `javascript` (eg. Resources\translations\javascript.en.yml). It's contents will be loaded to fronted and ready to use.  

Bundle provides a class **SonataExtensions.Translator** (and alias function `t(message)`) for that needs.   
Usage:
```javascript
SonataExtensions.Translator.translate('message');
// or
t('message');
```