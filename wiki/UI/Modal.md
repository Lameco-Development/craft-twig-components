# UI - Modal

## Twig

```html
<x-ui.modal title="{{ title }}" modalTrigger="{{ modalTrigger }}">
    // Content goes here
</x-ui.modal>
```

## Attributes

| Attribute | Type   | Default                                             | Desciprion                                                                                                                             |
|-----------|--------|---------------|----------------------------------------------------------------------------------------------------------------------------------------|
| Title     | string |                                                     | The title within the button that toggles the collapse                                                                                  |
| modalTrigger | string | | The (unique) value used trigger the modal. Since the modal is triggered by a button the modalTrigger is scoped outside this component. |

## Theme Config

If `icon.openHtml` and `icon.closedHtml` are set the `icon.html` will not be used.

```json
ui: {
  modal: {
    overlay: 'overlay classes',
    title: 'title classes',
    content: {
      wrapper: 'content wrapper classes',
      inner: 'content inner classes'
    },
    button: {
      class: 'button classes',
      icon: 'html for button icon'
    }    
  }
}
```
