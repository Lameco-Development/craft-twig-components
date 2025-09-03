/***********************************************************************************************************************
 * SCSS
 **********************************************************************************************************************/
import "../scss/plugin.scss";

/***********************************************************************************************************************
 * UI.Video.Default Iframes
 **********************************************************************************************************************/
const uiVideoIframes: NodeListOf<HTMLElement> = document.querySelectorAll(".ui-video__iframe--js");

if (uiVideoIframes.length > 0) {
  import("./components/uiVideoDefault").then((videoModule) => {
    videoModule.init(uiVideoIframes);
  });
}

/***********************************************************************************************************************
 * UI.Video.Background
 **********************************************************************************************************************/
const uiVideoBackgroundWrappers: NodeListOf<HTMLElement> = document.querySelectorAll(
  ".ui-video-background__wrapper--js",
);

if (uiVideoBackgroundWrappers.length > 0) {
  import("./components/uiVideoBackground").then((videoModule) => {
    videoModule.init(uiVideoBackgroundWrappers);
  });
}
