# Theme

Some of the components use a theme configuration which has to be set into a global as well.
```twig
{% set theme = {
    fadeInAnimation: ...,
    ui: {
        button: {...},
        collapse: {...},
        modal: {...},
        
    }
    social: {...}
    ...
} %}

{% do _globals.set('lameco.components.theme', theme) %}
```

## Fade In Animations

```json
fadeInAnimation: BOOLEAN
```
