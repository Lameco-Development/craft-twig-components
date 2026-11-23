# Changelog

Release notes for tagged versions are on [GitHub Releases](https://github.com/Lameco-Development/craft-twig-components/releases).

## Unreleased

### Fixed

- The plugin no longer creates Twig while Craft is still loading plugins. It now configures each site Twig environment when Craft creates it, through `View::EVENT_AFTER_CREATE_TWIG`. Before this, every site request logged "Twig instantiated before Craft is fully initialized." (about 2,500 warnings a day on a busy site).
