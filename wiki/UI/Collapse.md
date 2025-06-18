# UI - Collapse

## Twig

```html
<x-ui.collapse title="{{ collapseItem.blockTitle }}">
    // Content goes here
</x-ui.collapse>
```

## Attributes

| Attribute | Type   | Default                                             | Desciprion                                           |
|-----------|--------|---------------|------------------------------------------------------|
| Title     | string |                                                     | The title within the button that toggles the collapse |

## Theme Config

If `icon.openHtml` and `icon.closedHtml` are set the `icon.html` will not be used.

```json
ui: {
  collapse: {
    wrapper: 'wrapper classes',
    button: 'button classes (the element you click on the collapse the content)',
    icon: {
      wrapper: 'button icon classes',
      html: 'basic html for icon'
      openHtml: 'basic html for open icon',
      closedHtml: 'basic html for closed icon',
    },
    content: 'content classes'        
  }
}
```
