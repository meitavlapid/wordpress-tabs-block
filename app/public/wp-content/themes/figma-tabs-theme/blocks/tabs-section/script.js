document.addEventListener("DOMContentLoaded", () => {
  initAllTabs();
  observeTabsChanges();
});

/* ==================================================
   Initialize all tab components
   ================================================== */

function initAllTabs(root = document) {
  initDesktopTabs(root);
  initMobileTabs(root);
}

/* ==================================================
   Desktop tabs
   ================================================== */

function initDesktopTabs(root = document) {
  const desktopSections = root.querySelectorAll(
    ".tabs-section__container:not([data-tabs-initialized])",
  );

  desktopSections.forEach((section) => {
    const tabs = Array.from(section.querySelectorAll(".tabs-section__tab"));
    const panels = Array.from(section.querySelectorAll(".tabs-section__panel"));
    if (!tabs.length || !panels.length) {
      return;
    }
    section.dataset.tabsInitialized = "true";

    const activateTab = (
      selectedTab,
      moveFocus = false,
      shouldCenter = true,
    ) => {
      const controlledPanelId = selectedTab.getAttribute("aria-controls");
      if (!controlledPanelId) {
        return;
      }
      const selectedIndex = tabs.indexOf(selectedTab);
      tabs.forEach((tab) => {
        const isSelected = tab === selectedTab;
        tab.classList.toggle("is-active", isSelected);
        tab.setAttribute("aria-selected", isSelected ? "true" : "false");
        tab.setAttribute("tabindex", isSelected ? "0" : "-1");
      });

      panels.forEach((panel) => {
        const isSelected = panel.id === controlledPanelId;
        panel.classList.toggle("is-active", isSelected);
        panel.hidden = !isSelected;
        if (!isSelected) {
          pausePanelVideos(panel);
        }
      });
      if (moveFocus) {
        selectedTab.focus({
          preventScroll: true,
        });
      }
      if (shouldCenter) {
        centerTab(selectedTab);
      }
    };

    addKeyboardNavigation(tabs, activateTab);

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        activateTab(tab);
      });
    });
    const initialTab =
      tabs.find((tab) => tab.classList.contains("is-active")) ||
      tabs.find((tab) => tab.getAttribute("aria-selected") === "true") ||
      tabs[0];
    activateTab(initialTab, false, false);
  });
}

/* ==================================================
   Mobile infinite slider and panels
   ================================================== */

function initMobileTabs(root = document) {
  const mobileSections = root.querySelectorAll(
    ".tabs-section-mobile:not([data-tabs-initialized])",
  );
  mobileSections.forEach((section) => {
    const slider = section.querySelector(".tabs-section-mobile__slider");
    const track = section.querySelector(".tabs-section-mobile__slider-track");
    const originalTabs = Array.from(
      section.querySelectorAll(".tabs-section-mobile__tab"),
    );
    const panels = Array.from(
      section.querySelectorAll(".tabs-section-mobile__panel"),
    );
    if (!slider || !track || originalTabs.length < 2 || !panels.length) {
      return;
    }
    section.dataset.tabsInitialized = "true";
    let scrollTimer = null;
    let isJumping = false;
    let isProgrammaticScroll = false;

    /* ----------------------------------------------
       Create clones for the infinite loop
       ---------------------------------------------- */

    const firstClone = originalTabs[0].cloneNode(true);
    const lastClone = originalTabs[originalTabs.length - 1].cloneNode(true);
    firstClone.classList.add("is-clone");
    lastClone.classList.add("is-clone");
    firstClone.removeAttribute("id");
    lastClone.removeAttribute("id");
    firstClone.setAttribute("aria-hidden", "true");
    lastClone.setAttribute("aria-hidden", "true");
    firstClone.setAttribute("tabindex", "-1");
    lastClone.setAttribute("tabindex", "-1");
    firstClone.dataset.realIndex = "0";
    lastClone.dataset.realIndex = String(originalTabs.length - 1);
    track.insertBefore(lastClone, originalTabs[0]);
    track.appendChild(firstClone);
    const sliderTabs = Array.from(
      track.querySelectorAll(".tabs-section-mobile__tab"),
    );
    originalTabs.forEach((tab, index) => {
      tab.dataset.realIndex = String(index);
    });

    /* ----------------------------------------------
       Calculate the centered scroll position
       ---------------------------------------------- */

    const getCenteredScrollPosition = (tab) => {
      const sliderRect = slider.getBoundingClientRect();
      const tabRect = tab.getBoundingClientRect();
      return (
        slider.scrollLeft +
        tabRect.left -
        sliderRect.left -
        slider.clientWidth / 2 +
        tabRect.width / 2
      );
    };

    const centerTab = (tab, behavior = "smooth") => {
      isProgrammaticScroll = true;
      slider.scrollTo({
        left: getCenteredScrollPosition(tab),
        behavior,
      });
      window.setTimeout(
        () => {
          isProgrammaticScroll = false;
        },
        behavior === "smooth" ? 400 : 30,
      );
    };

    /* ----------------------------------------------
       Activate the matching real tab and panel
       ---------------------------------------------- */

    const activateRealTab = (
      realIndex,
      moveFocus = false,
      shouldCenter = true,
    ) => {
      const selectedTab = originalTabs[realIndex];

      if (!selectedTab) {
        return;
      }
      const controlledPanelId = selectedTab.getAttribute("aria-controls");
      originalTabs.forEach((tab, index) => {
        const isSelected = index === realIndex;
        tab.classList.toggle("is-active", isSelected);
        tab.setAttribute("aria-selected", isSelected ? "true" : "false");
        tab.setAttribute("tabindex", isSelected ? "0" : "-1");
      });
      panels.forEach((panel) => {
        const isSelected = panel.id === controlledPanelId;
        panel.classList.toggle("is-active", isSelected);
        panel.hidden = !isSelected;
        if (!isSelected) {
          pausePanelVideos(panel);
        }
      });
      sliderTabs.forEach((tab) => {
        const tabIndex = Number(tab.dataset.realIndex);
        tab.classList.toggle("is-active", tabIndex === realIndex);
      });
      if (moveFocus) {
        selectedTab.focus({
          preventScroll: true,
        });
      }
      if (shouldCenter) {
        centerTab(selectedTab);
      }
    };

    /* ----------------------------------------------
       Click navigation
       ---------------------------------------------- */

    sliderTabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        const realIndex = Number(tab.dataset.realIndex);
        activateRealTab(realIndex, false, false);
        if (tab.classList.contains("is-clone")) {
          const realTab = originalTabs[realIndex];
          centerTab(realTab, "auto");
          return;
        }
        centerTab(tab);
      });
    });

    /* ----------------------------------------------
       Keyboard navigation
       ---------------------------------------------- */

    originalTabs.forEach((tab, index) => {
      tab.addEventListener("keydown", (event) => {
        let nextIndex = null;
        switch (event.key) {
          case "ArrowRight":
            nextIndex = (index + 1) % originalTabs.length;
            break;
          case "ArrowLeft":
            nextIndex = (index - 1 + originalTabs.length) % originalTabs.length;
            break;
          case "Home":
            nextIndex = 0;
            break;
          case "End":
            nextIndex = originalTabs.length - 1;
            break;
          default:
            return;
        }
        event.preventDefault();
        activateRealTab(nextIndex, true, true);
      });
    });

    /* ----------------------------------------------
       Swipe navigation
       ---------------------------------------------- */

    slider.addEventListener(
      "scroll",
      () => {
        if (isJumping || isProgrammaticScroll) {
          return;
        }
        window.clearTimeout(scrollTimer);
        scrollTimer = window.setTimeout(() => {
          const sliderRect = slider.getBoundingClientRect();
          const sliderCenter = sliderRect.left + sliderRect.width / 2;
          let closestTab = sliderTabs[0];
          let closestDistance = Infinity;
          sliderTabs.forEach((tab) => {
            const tabRect = tab.getBoundingClientRect();
            const tabCenter = tabRect.left + tabRect.width / 2;
            const distance = Math.abs(tabCenter - sliderCenter);
            if (distance < closestDistance) {
              closestDistance = distance;
              closestTab = tab;
            }
          });

          const realIndex = Number(closestTab.dataset.realIndex);
          activateRealTab(realIndex, false, false);
          if (closestTab === firstClone || closestTab === lastClone) {
            isJumping = true;
            const matchingRealTab = originalTabs[realIndex];
            slider.scrollTo({
              left: getCenteredScrollPosition(matchingRealTab),
              behavior: "auto",
            });
            requestAnimationFrame(() => {
              isJumping = false;
            });
          }
        }, 120);
      },
      {
        passive: true,
      },
    );

    /* ----------------------------------------------
       Initial tab
       ---------------------------------------------- */

    const initialIndex = Math.max(
      0,
      originalTabs.findIndex(
        (tab) =>
          tab.classList.contains("is-active") ||
          tab.getAttribute("aria-selected") === "true",
      ),
    );
    activateRealTab(initialIndex, false, false);
    requestAnimationFrame(() => {
      centerTab(originalTabs[initialIndex], "auto");
    });
  });
}
/* ==================================================
   Shared keyboard navigation
   ================================================== */

function addKeyboardNavigation(tabs, activateTab) {
  tabs.forEach((tab, index) => {
    tab.addEventListener("keydown", (event) => {
      let nextIndex = null;
      switch (event.key) {
        case "ArrowRight":
          nextIndex = (index + 1) % tabs.length;
          break;
        case "ArrowLeft":
          nextIndex = (index - 1 + tabs.length) % tabs.length;
          break;
        case "Home":
          nextIndex = 0;
          break;
        case "End":
          nextIndex = tabs.length - 1;
          break;
        default:
          return;
      }

      event.preventDefault();
      activateTab(tabs[nextIndex], true);
    });
  });
}

/* ==================================================
   Pause videos in hidden panels
   ================================================== */

function pausePanelVideos(panel) {
  panel.querySelectorAll("video").forEach((video) => {
    video.pause();
  });
}

/* ==================================================
   Gutenberg / dynamic block rendering
   ================================================== */

function observeTabsChanges() {
  const observer = new MutationObserver((mutations) => {
    let shouldInitialize = false;
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (!(node instanceof HTMLElement)) {
          return;
        }
        if (
          node.matches(".tabs-section__container, .tabs-section-mobile") ||
          node.querySelector(".tabs-section__container, .tabs-section-mobile")
        ) {
          shouldInitialize = true;
        }
      });
    });
    if (shouldInitialize) {
      initAllTabs();
    }
  });
  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });
}
