import PhotoSwipe from "photoswipe";
import PhotoSwipeLightbox from "photoswipe/lightbox";

export const init = (uiVideoIframes) => {
  uiVideoIframes.forEach((iframe) => {
    const gallery = iframe.querySelector("a");
    const lightbox = new PhotoSwipeLightbox({
      gallery: gallery,
      pswpModule: PhotoSwipe,
    });

    lightbox.addFilter("itemData", (itemData) => {
      const iframeUrl: string = itemData.element.dataset.pswpIframeUrl;
      if (iframeUrl) {
        itemData.iframeUrl = iframeUrl;
      }

      const videoUrl: string = itemData.element.dataset.pswpVideoUrl;
      if (videoUrl) {
        itemData.videoUrl = videoUrl;
        itemData.videoType = itemData.element.dataset.pswpVideoType ?? "";
      }

      return itemData;
    });

    lightbox.on("contentLoad", (e) => {
      const { content } = e;

      if (content.type === "iframe") {
        e.preventDefault();

        content.element = document.createElement("div");
        content.element.className = "pswp__iframe-container";

        const iframe = document.createElement("iframe");
        iframe.setAttribute("allowfullscreen", "");
        iframe.src = content.data.iframeUrl;
        content.element.appendChild(iframe);
      } else if (content.type === "video") {
        e.preventDefault();

        content.element = document.createElement("div");
        content.element.className = "pswp__video-container";

        const video = document.createElement("video");
        video.controls = true;
        video.autoplay = true;
        video.setAttribute("playsinline", "");

        const source = document.createElement("source");
        source.src = content.data.videoUrl;
        if (content.data.videoType) source.type = content.data.videoType;
        video.appendChild(source);
        content.element.appendChild(video);
      }
    });

    lightbox.init();
  });
};
