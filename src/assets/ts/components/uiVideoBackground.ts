export const init = (uiVideoBackgroundWrappers) => {
  const resizeBackgroundVideo = (el) => {
    // Set variables
    const videoWrapperHeight = el.offsetHeight;
    const videoWrapperWidth = el.offsetWidth;
    let videoContainerWidth = null;
    let videoContainerHeight = null;
    const videoContainer = el.querySelector(".ui-video-background__container--js");

    // Check if video should overlap in height or in width using 16:9 ratio
    if (videoWrapperHeight < videoWrapperWidth * 0.5625) {
      // Calculate dimensions
      videoContainerWidth = videoWrapperWidth;
      videoContainerHeight = videoWrapperWidth * 0.5625;
    } else {
      // Calculate dimensions
      videoContainerWidth = videoWrapperHeight * 1.7778;
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
