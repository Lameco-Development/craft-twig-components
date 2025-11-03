export const init = (uiVideoBackgroundWrappers) => {
  const resizeBackgroundVideo = (el) => {
    // Set variables
  const videoWrapperHeight = el.offsetHeight;
  const videoWrapperWidth = el.offsetWidth;
  let videoContainerWidth = null;
  let videoContainerHeight = null;
  const videoContainer = el.querySelector(".ui-video-background__container--js");

  // Calculate video aspect ratio
  const videoAspectRatio = videoContainer.dataset.width / videoContainer.dataset.height;
  const wrapperAspectRatio = videoWrapperWidth / videoWrapperHeight;

  // Scale video to cover the wrapper while maintaining aspect ratio
  if (wrapperAspectRatio > videoAspectRatio) {
    // Wrapper is wider than video - fit to width
    videoContainerWidth = videoWrapperWidth;
    videoContainerHeight = videoWrapperWidth / videoAspectRatio;
  } else {
    // Wrapper is taller than video - fit to height
    videoContainerWidth = videoWrapperHeight * videoAspectRatio;
    videoContainerHeight = videoWrapperHeight;
  }

  videoContainer.style.width = `${videoContainerWidth}px`;
  videoContainer.style.height = `${videoContainerHeight}px`;
};

let resizeTimout;
window.addEventListener("resize", function () {
  clearTimeout(resizeTimout);
  resizeTimout = setTimeout(function () {
    uiVideoBackgroundWrappers.forEach(function (el) {
      resizeBackgroundVideo(el);
    });
  }, 250);
});

uiVideoBackgroundWrappers.forEach(function (el) {
  resizeBackgroundVideo(el);
});
};
