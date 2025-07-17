import PhotoSwipe from "photoswipe";
import PhotoSwipeLightbox from "photoswipe/lightbox";

export const init = (uiVideoIframes) => {
  uiVideoIframes.forEach((iframe) => {
    const gallery = iframe.querySelector("a");
    console.log(iframe);
    const lightbox = new PhotoSwipeLightbox({
      gallery: gallery,
      pswpModule: PhotoSwipe,
    });

    // parse data-google-map-url attribute
    lightbox.addFilter("itemData", (itemData) => {
      const iframeUrl: string = itemData.element.dataset.pswpIframeUrl;
      if (iframeUrl) {
        itemData.iframeUrl = iframeUrl;
      }
      return itemData;
    });

    // override slide content
    lightbox.on("contentLoad", (e) => {
      const { content } = e;
      if (content.type === "iframe") {
        // prevent the deafult behavior
        e.preventDefault();

        // Create a container for iframe
        // and assign it to the `content.element` property
        content.element = document.createElement("div");
        content.element.className = "pswp__iframe-container";

        const iframe = document.createElement("iframe");
        iframe.setAttribute("allowfullscreen", "");
        iframe.src = content.data.iframeUrl;
        content.element.appendChild(iframe);
      }
    });

    lightbox.init();
    console.log(lightbox);
  });
};
