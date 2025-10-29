# Requirements

- Craft CMS 5.0+
- TailwindCSS 4.0+
- AlpineJS 3.0+
- PHP 8.4+

# Steps to use the plugin

1. Define the themeConfig

```twig
{% set ComponentsThemeConfig = {
  gsapAnimations: false,
  
  ui: {
    
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
    
    button: {
        class: "",
        overlay: {
            class: "",
        },
        type: {
            [primary|primaryDark|secondary|secondaryDark|text|textDark]: {
                class: "",
                overlay: {
                    class: "",
                },
                icon : {
                    class: "",
                    html: "",
                }
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
    
    collapse: {
        class: "",
        button: {
            class: "",
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
        content: {
          class: ""
        }
    },

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
    
    modal: {
      class: "",
      overlay: {
        class: ""
      },
      content: {
        class: ""
      },
      title: {
        class: ""
      },
      button: {
        class: "",
        html: ""
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
  },
  
  social: {
    follow: {
       class: "",
       text: "",
       items: [ "facebook", "linkedin", "twitter", "instagram", "pinterest", "youtube", "vimeo" ],
       list: {
        class: "",
       },
       item: {
        class: "",
       }
    },
    
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
  
  sprig: {
    loader: {
        class: "",
        html: ""
    },
    
    pagination: {
        class: "",
        neighbours: 1,
        list: {
            class: "",
        },
        item: {
            class: "",
            active: {
                class: ""
            },
        },
        arrows: {
            class: "",
            disabled: {
                class: ""
            },
            prev: {
                html: ""
            },
            next: {
                html: ""
            },
        },
        ellipsis: {
            class: "",
            html: ""
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

4. Include the Twig Components SCSS in your main SCSS file.

```scss
@use "../../../vendor/lameco/craft-twig-components/src/assets/scss/index";
```

5. Add the Twig Components template source to SCSS.

```scss
@source "../../../vendor/lameco/craft-twig-components/**/*.twig";
```

## FontAwesome

The Component Library uses FontAwesome for icons used in fallback logic if nothing in the themeConfig is defined.
In the `fontawesome.ts` file import the pre-defined icons using:
```js 
import { twigComponentsFontAwesomeIcons } from "../../../vendor/lameco/craft-twig-components/src/assets/ts/fontAwesome";

library.add(
    ...twigComponentsFontAwesomeIcons,
    // other icons you want to add
)
```

## AlpineJS

The Component Library uses AlpineJS for the interactive components. Make sure to include AlpineJS in your project and initialize it properly.
At least the following AlpineJS plugins are required:
- collapse

## Sprig

The Component Library uses Sprig for dynamic components. Make sure to include Sprig in your project and initialize it properly.

### Pagination

Since the pagination is a Sprig component, you need to pass the themeConfig to the Sprig template. You can do this by passing the `theme` attribute to the Sprig component:

```twig
{{ sprig('path/to/pagination', { theme: ComponentsThemeConfig }) }}
```

Then when rendering the pagination, you can access the themeConfig in the Sprig template like this:

```twig
<x-sprig.pagination pageInfo="..." theme="{{ theme | json_encode }}"></x-sprig.pagination>
```
