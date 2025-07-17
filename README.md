# Requirements

- Craft CMS 5.0+
- TailwindCSS 4.0+
- PHP 8.4+

# Steps to use the plugin

1. Define the themeConfig

```twig
{% set ComponentsThemeConfig = {
  gsapAnimations: false,
  
  ui: {
    video: {
      mode: "[embed|lightbox]",
      embed: {
        class: ""
      },
      lightbox: {
        class: "",
        button: {
          class: "",
          html: ""
        }
      },
      consent: {
        class: ""
      }
    }
  }
}
```

2. Add the themeConfig to the `_globals` so they are available most of the time. 

> If you are using Sprig for example the themeConfig will not be available in the Sprig templates. You can pass the themeConfig (or a portion of the stripped down themeConfig) to the Sprig template using the `sprig` function and passing the theme object into the `theme` attribute of a component.
> 
> Be sure to `| json_encode` the themeConfig when passing it to Sprig, because Sprig only allows string, boolean, numbers or arrays.
> 
> ```twig
> {{ sprig('path/to/template', { theme: ComponentsThemeConfig | json_encode }) }}



```twig
{% do _globals.set('lameco.components.theme', ComponentsThemeConfig) %}
```

3. Register the assets to make sure the plugin's styles and scripts are loaded in your templates:

```twig
{% do view.registerAssetBundle(
'lameco\\crafttwigcomponents\\assetbundles\\CraftTwigComponents\\CraftTwigComponentsAsset'
) %}
```
