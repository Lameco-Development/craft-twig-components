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
       items: [ "copy", "mail", "linkedin", "facebook", "twitter", "whatsapp" ],
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

## Image

`<x-ui.image>` renders an asset as a `<picture>` with a desktop `<source>`, an optional mobile `<source>` and an `<img>`.

| Prop | Default | Description |
| ---- | ------- | ----------- |
| `image` | — | The asset to render. Nothing is rendered when it is empty. |
| `transform` | `null` | Transform (handle or array) for the desktop `<source>` and the `<img>`. |
| `mobileImage` | `null` | A different asset for viewports below `breakpoint`. |
| `mobileTransform` | `null` | Transform for the mobile `<source>`, applied to `mobileImage`. |
| `breakpoint` | `theme.ui.image.image.mobileBreakpoint` or `992px` | Width from which the desktop `<source>` applies. |
| `srcset` | `['1x', '2x']` | Sizes passed to `getSrcset()`. |
| `lazyload` | `true`, or `false` when `fetchpriority` is `high` | `loading="lazy"` when true, `loading="eager"` when false. |
| `fetchpriority` | `null` | `high`, `low` or `auto`, rendered as `fetchpriority` on the `<img>`. Any other value, or none, omits the attribute. |
| `pictureClass` | `theme.ui.image.picture.class` | Classes on the `<picture>`. |
| `imgClass` | `theme.ui.image.image.class` | Classes on the `<img>`. With `object-cover`, the asset's focal point sets `object-position`. |
| `captionClass` | `theme.ui.image.caption.class` | Classes on the `<figcaption>`, rendered from the component's slot. |

### Above-the-fold images

Give the image that is likely the Largest Contentful Paint (a hero, a page header) a high fetch priority. It then loads eagerly as well, because a lazy image is not requested until layout has run:

```twig
<x-ui.image image="{{ entry.heroImage.one() }}" transform="hero" fetchpriority="high"></x-ui.image>
```

Pass `lazyload` explicitly to override that default.
