# UI - Button

## Twig

```html
<x-ui.button>
    <x-slot name="icon">...</x-slot>
    <x-slot name="text">...</x-slot>
</x-ui.button>
```

## Attributes

| Attribute    | Type          | Default                                             | Desciprion                                                                                                                 |
|--------------|---------------|-----------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------|
| hyper        | Hyper Element |                                                     |                                                                                                                            |
| url          | string        |                                                     |                                                                                                                            |
| text         | string        |                                                     |                                                                                                                            |
| target       | string        | `_self`                                             |                                                                                                                            |
| variant      | string        | `primary`                                           | `primary` `secondary` `outline` `text` `white`                                                                             |
| size         | string | `default`                                           | `default` `sm`                                                                                                             |
| attr         | string (html) |                                                     | A string of attributes required, for example sprig attributes or a data-attr.                                              |
| iconPosition | string        | Specified in `theme.ui.button.icon.position` or `end` | `start` `end`                                                                                                              |
| icon         | string (html) |                                                     |                                                                                                                            |
| theme        | string (json encoded) | | The component will try to load the theme but if used in a Sprig include or Blitz include the theme might not be available. |

## Theme Config

```json
ui: {
  button: {
    base: 'basic classes',
    overlay: {
      base: 'basic overlay classes',
      primary: 'type specific overlay classes',
      secondary: 'type specific overlay classes',
      outline: 'type specific overlay classes',
      text: 'type specific overlay classes',
      white: 'type specific overlay classes',
    },
    content: {
      wrapper: 'basic content classes',
    },
    icon: {
      wrapper: 'icon wrapper classes',
      position: 'start OR end',
      html: 'basic html for icon, overwritable in component'
    },
// Type specific basic classes
    type: {
      primary: 'type specific classes',
      secondary: 'type specific classes',
      outline: 'type specific classes',
      text: 'type specific classes',
      white: 'type specific classes',
    },
// Classes applied depending on the size variable
    size: {
      default: 'size specific classes',
      sm: 'size specific classes'
    }
  }
}
```
