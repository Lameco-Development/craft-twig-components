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
  
    image: {
      picture: {
        class: ""
      },
      img: {
        class: "",
        mobileBreakpoint: ""
      },
      caption: {
        class: ""
      }
    },
  
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
    },
    
    breadcrumbs: {
        class: "",
        home: {
            html: ""
        },
        back: {
            class: "",
            html: ""
        },
        separator: {
            html: ""
        },
        item: {
            class: "",
            current: {
                class: ""
            }
        }
    },
    
    collapse: {
        class: "",
        button: {
            class: ""
        },
        title: {
            class: ""
        },
        icon: {
            class: "",
            html: "",
            openHTML: "",
            closeHTML: ""
        }
    },
    
    button: {
        class: "",
        overlay: {
            class: "",
        },
        type: {
            [primary|primaryDark|secondary|secondaryDark|text|textDark]: {
                class: "",
                overlay: ""
            }        
        }
        inner: {
            class: ""
        },
        icon : {
            position: "[start|end]",
            class: "",
            html: ""
        }
    }
  },
  
  social: {
    share: {
       class: "",
       text: "",
       items: [ "mail", "linkedin", "facebook", "twitter", "whatsapp" ],
       list: {
        class: "",
       },
       item: {
        class: "",
       }
    }
  }
} %}
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

# FontAwesome

The Component Library uses FontAwesome for icons used in fallback logic if nothing in the themeConfig is defined.
In the `fontawesome.ts` file import the pre-defined icons using:
```js 
import { twigComponentsFontAwesomeIcons } from "../../../vendor/lameco/craft-twig-components/src/assets/ts/fontAwesome";

library.add(
    ...twigComponentsFontAwesomeIcons,
    // other icons you want to add
)
```
