###Form types
#####Autocomplete
Name: `se_type_autocomplete`.  
Class: `SonataExtensions\Form\Type\AutocompleteType`.   
JS Class: `SonataExtensions.Form.Autocomplete`.  
Parent element: `text`.  

Symfony native implementation of jQuery UI autocomplete widget.
Does not bind to sonata admin's form\admin\entity. That unleashes the flexibility of unit search. Useful when you want to store text only.

| Type | Required | Name | Description |
| - | - | - | - |
| _(string)_ | class | required | a model class to use |
| _(string)_ | match_against | required | a `class` property to match query against |
| _(string)_ | required | label_getter | a name of `class` property or method to use to generate the text label |
| _(int)_ | limit | optional, default: _null_ | limit output to that number |
| _(int)_ | min_length | optional, default: _null_ | a minimum typed letters required to trigger the search |
| _(array)_ | sort | optional, default: _null_ | an array of column -> order pairs to order the output |
| _(array)_ | properties | optional, default: _null_ | a list of extra `class` properties to extracted and put into JSON response |

A entity must have a repository which implements `SonataExtensionsBundle\Entity\AutocompleteProviderInterface` which forces developer to implement `getAutocomplete` method which configures QueryBuilder.  
Also there is a trait available for the most common autocomplete case: `SonataExtensionsBundle\Entity\AutocompleteProviderTrait`.

```php
$builder->add('name', 'se_type_autocomplete', array(
    'class' => 'AppBundle\Entity\Speaker\Product',
    'required' => true,
    'label_getter' => 'getLabel',
    'properties' => array(
        'clientPrice', 'payout', 'vat'
    ),
    'match_against' => 'product',
    'limit' => 20,
    'sort' => array(
        'id' => 'asc'
    ),            
));
```

#####ModelAutocomplete
Name: `se_type_model_autocomplete`.  
Class: `SonataExtensions\Form\Type\ModelAutocompleteType`.   
JS Class: `SonataExtensions.Form.ModelAutocomplete`.  
Parent element: `form`.  

Analogue of `sonata_type_model_autocomplete`.   
Options of this widget are same as Autocomplete type but additionally it creates a hidden `id` field and binds to the model. Usefull when you have to store text and id separately.

#####Collection
Name: `se_type_collection`.  
Class: `SonataExtensions\Form\Type\CollectionType`.   
JS Class: `SonataExtensions.Form.Collection`.  
Parent element: `collection`.  

Provides highly customizable table UI for collection widget.  
See [SonataExtensionsBundle/Resources/views/Form/collection.html.twig](../SonataExtensionsBundle/Resources/views/Form/collection.html.twig) for info about blocks available.

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(string)_ | button_label_add | optional, default: _form.label.add_item_ | a label for "add" button |  
| _(string)_ | button_label_remove | optional, default: _form.label.remove_item_ | a label for "remove" button |  

```php
$builder->add('products', 'se_type_collection', array(
    'label' => false,
    'type' => 'serp_type_booking_product',
    'allow_add' => true,
    'allow_delete' => true,
    'delete_empty' => true,
    'required' => false,
    'button_label_add' => 'button.add_product',
    'options' => array(
        'data_class' => 'AppBundle\Entity\Client\Booking\Product'
    ),
))
```

#####Datepicker
Name: `se_type_datepicker`.  
Class: `SonataExtensions\Form\Type\DatepickerType`.   
JS Class: `inline script`.  
Parent element: `text`.  

Uses bootstrap-datepicker library which is more powerfull.

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(array)_ | options | optional | this will be encoded into JSON and passed to the plugin |  

```php
$builder->add('eventDate', 'se_type_datepicker', array(
    'label' => 'label.event_date',
    'required' => false,
    'options' => array(
        'format' => 'dd.mm.yyyy',
    )
))
```

#####File
Name: `se_type_file`.  
Class: `SonataExtensions\Form\Type\FileType`.   
JS Class: `none`.  
Parent element: `file`.  

This element provides custom file widget UI.  
It's possible to prohibit future reuploads by setting `allow_change` to `false`.  

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(bool)_ | allow_change | optional, default: _true_ | allow to change uploaded file (reupload) |  

#####ModelFile
Name: `se_type_model_file`.  
Class: `SonataExtensions\Form\Type\ModelFileType`.   
JS Class: `none`.  
Parent element: `form`.  

Same as File but adds hidden `id` element.  

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(bool)_ | allow_change | optional, default: _true_ | allow to change uploaded file (reupload) |  

#####ImageFile
Name: `se_type_image_file`.  
Class: `SonataExtensions\Form\Type\ImageType`.   
JS Class: `none`.  
Parent element: `file`.  

Same as File but displays an image preview if none uploaded.

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(bool)_ | allow_change | optional, default: _true_ | allow to change uploaded file (reupload) |  

#####ModelImageFile
Name: `se_type_model_image_file`.  
Class: `SonataExtensions\Form\Type\ModelImageFileType`.   
JS Class: `none`.  
Parent element: `form`.  

Same as ImageFile but adds hidden `id` field.

#####Joined
Name: `se_type_joined`.  
Class: `SonataExtensions\Form\Type\JoinedType`.   
JS Class: `none`.  
Parent element: `form`.  

Combines several form elements into single row. (eg. zip-city).  

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(array)_ | fields | required | symfony's standard form definitions |  
| _(array)_ | wrapper | optional | config |  
| _(string)_ | wrapper.class | optional | class of the `div.form-group` for this element |  

```php
$builder->add('zip_city', 'se_type_joined', array(
    'label' => 'label.zip_city',
    'wrapper' => array(
        'class' => 'row'
    ),
    'fields' => array(
        array(
            'name' => 'zip',
            'type' => 'integer',
            'options' => array(
                'label' => 'label.zip',
                'required' => false,
            ),
            'wrapper' => array(
                'class' => 'col-md-4'
            )
        ),
        array(
            'name' => 'city',
            'type' => 'text',
            'options' => array(
                'label' => 'label.city',
                'required' => false
            ),
            'wrapper' => array(
                'class' => 'col-md-8'
            )
        ),
    )
))
```

#####Label
Name: `se_type_label`.  
Class: `SonataExtensions\Form\Type\LabelType`.   
JS Class: `none`.  
Parent element: `text`.  

Renders a `div` element styled as form input.  

#####Money
Name: `se_type_model`.  
Class: `SonataExtensions\Form\Type\MoneyType`.   
JS Class: `none`.  
Parent element: `money`.  

Uses `Locale::getDefault()` to determine how to format money.

#####Title
Name: `se_type_title`.  
Class: `SonataExtensions\Form\Type\TitleType`.   
JS Class: `none`.  
Parent element: `choice`.  

Renders a choice field with predefined list of titles (eg. Mr., Ms., etc).  

#####RadioGrid
Name: `se_type_radio_grid`.  
Class: `SonataExtensions\Form\Type\RadioGridType`.   
JS Class: `none`.  
Parent element: `form`.

Renders a table with radio inputs. Use case: you want to check levels of user's spoken languages. This will draw a table where columns are levels and rows are skill levels.

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(string)_ | title | optional | A label of the element |  
| _(array)_ | columns | required |   |  
| _(array)_ | rows | required |  |  

```php
$builder->add('languages', 'se_type_radio_grid', array(
    'label' => false,
    'required' => false,
    'title' => 'label.languages',
    'data_class' => 'AppBundle\Entity\Speaker\LanguageSet',
    'rows' => array(
        'de' => 'languages.german',
        'fr' => 'languages.french',
        'it' => 'languages.italian',
        'en' => 'languages.english',
    ),
    'columns' => array(
        'native' => 'language_skills.native',
        'fluent' => 'language_skills.fluent',
        'minimal' => 'language_skills.minimal',
        'none' => 'language_skills.none',
    )
))
```

#####Translatable
Name: `se_type_translatable`.  
Class: `SonataExtensions\Form\Type\TranslatableType`.   
JS Class: `none`.  
Parent element: `form`.

Wraps target element in tabbed container. Each tab has an input for another language.

| Type | Required | Name | Description |  
| - | - | - | - |  
| _(string)_ | class | required | Name of translation repository class (Gedmo based) |  
| _(string)_ | type | required | An original input which value must be translatable   |  
| _(array)_ | options | optional | options for `type` input |  

```php
$builder->add('wishes', 'se_type_translatable', array(
    'type' => 'textarea',
    'class' => 'AppBundle\Entity\SpeakerTranslation',
    'label' => 'label.special_wishes',
    'required' => false,
    'options' => array(
        'label' => false,
    )
))
```


