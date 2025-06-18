# Share List

## Twig

```html
<x-social.share.list entry="{{ entry }}" text="{{ 'share' | t }}"></x-social.share.list>
```
## Attributes

| Attribute    | Type                  | Default                                             | Desciprion                          |
|--------------|-----------------------|-----------------------------------------------------|-------------------------------------|
| Entry        | Entry Element         |                                                     | The entry you wish to share         |
| text         | string                |                                                     | The text shown with the share icons |

## Theme Config

```json
social: {
  share: {
    list: {
      wrapper: 'wrapper classes',
      item: 'item classes'
    }
  }
}
```
