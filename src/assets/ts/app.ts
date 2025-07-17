/***********************************************************************************************************************
 * SCSS
 **********************************************************************************************************************/
import "../scss/app.scss";

/***********************************************************************************************************************
 * UI.Video.Default Iframes
 **********************************************************************************************************************/
const uiVideoIframes: NodeListOf<HTMLElement> = document.querySelectorAll(".ui-video__iframe--js");

if (uiVideoIframes.length > 0) {
  import("./components/uiVideoDefault").then((videoModule) => {
    videoModule.init(uiVideoIframes);
  });
}

console.log("hello Craft Twig Components");
