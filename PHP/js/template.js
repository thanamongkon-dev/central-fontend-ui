// Carousel templates
const templates = {
  normal: (title, slidesHTML, textColor, bgColor,uuid, desktopSize, mobileSize, gap) => `
          <div id="carousel-container-normal" class="container relative flex w-full py-4" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="w-full mx-auto">
              <h1 id="Title" class="px-4 mt-10 mb-6 text-3xl font-bold font-cpn max-sm:px-4 max-sm:text-xl">${
                title || "TITLE"
              }</h1>
              <!-- carousel container -->
              <div class="relative grid w-full col-span-2 py-6">
              <!-- scrollable content -->
                <div id="carousel-${uuid}" class="grid grid-flow-col md:auto-cols-[calc(${desktopSize}%-0.5rem)] auto-cols-[calc(${mobileSize}%-0.5rem)] gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl select-none font-bebas-neue md:text-base md:gap-${gap} hide-scrollbar cursor-grab">
                  ${slidesHTML}
                </div>

                <!-- left button -->
                <button
                  id="prevBtn"
                  onclick="carouselPrev('carousel-${uuid}')"
                  class="absolute left-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6 rotate-180"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>

                <!-- right button -->
                <button
                  id="nextBtn"
                  onclick="carouselNext('carousel-${uuid}')"
                  class="absolute right-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
              </div>
            </div>
          </div>
        `,

  normalDesktopTemplate: (title, slidesHTML, textColor, bgColor,uuid, desktopSize, gap) => `
        <div id="carousel-container-normal-desktop" class="hidden container relative sm:flex w-full py-4" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="w-full mx-auto">
              <h1 id="Title" class="px-4 mt-10 mb-6 text-3xl font-bold font-cpn max-sm:px-4 max-sm:text-xl">${
                title || "TITLE"
              }</h1>
              <!-- carousel container -->
              <div class="relative grid w-full col-span-2 py-6">
              <!-- scrollable content -->
                <div id="carousel-${uuid}" class="grid grid-flow-col md:auto-cols-[calc(${desktopSize}%-0.5rem)] gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl select-none font-bebas-neue md:text-base md:gap-${gap} hide-scrollbar cursor-grab">
                  ${slidesHTML}
                </div>

                <!-- left button -->
                <button
                  id="prevBtn"
                  onclick="carouselPrev('carousel-${uuid}')"
                  class="absolute left-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6 rotate-180"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>

                <!-- right button -->
                <button
                  id="nextBtn"
                  onclick="carouselNext('carousel-${uuid}')"
                  class="absolute right-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
              </div>
            </div>
          </div>
      `,

  normalMobileTemplate: (title, slidesHTML, textColor, bgColor,uuid, mobileSize, gap) => `
        <div id="carousel-container-normal-mobile" class="sm:hidden container relative flex w-full py-4" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="w-full mx-auto">
              <h1 id="Title" class="px-4 mt-10 mb-6 text-3xl font-bold font-cpn max-sm:px-4 max-sm:text-xl">${
                title || "TITLE"
              }</h1>
              <!-- carousel container -->
              <div class="relative grid w-full col-span-2 py-6">
              <!-- scrollable content -->
                <div id="carousel-${uuid}" class="grid grid-flow-col auto-cols-[calc(${mobileSize}%-0.5rem)] gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl select-none font-bebas-neue md:text-base md:gap-${gap} hide-scrollbar cursor-grab">
                  ${slidesHTML}
                </div>
              </div>
            </div>
          </div>
      `,

  hero: (title, subtitle, slidesHTML, textColor, bgColor,uuid, desktopSize, mobileSize, gap,mainLink) => `
          <div id="carousel-container-hero" class="py-4 flex w-full container relative" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="grid w-full grid-cols-1 lg:grid-cols-3 place-content-center place-items-center">
              <div class="relative flex flex-col w-full gap-[0.5rem] text-center md:text-left lg:pr-[2.8125rem]">
                <a id="hero-link" href="${mainLink}" target="_blank" class="absolute inset-0 z-10"></a>
                <h1 id="Title" class="md:text-[3.5rem] text-[1.75rem] leading-none hover:underline font-central-sang-bleu">${
                  title || "TITLE"
                }</h1>
                <p id="Subtitle" class="text-[0.875rem] md:text-[1rem]">${subtitle || "SUBTITLE"}</p>
              </div>
              <div class="relative grid min-w-full col-span-2 py-6 pl-3 md:px-0">
                <div id="carousel-${uuid}" class="grid grid-flow-col md:auto-cols-[calc(${desktopSize}%-0.5rem)] auto-cols-[calc(${mobileSize}%-0.5rem)] select-none font-bebas-neue w-full gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl md:text-base md:gap-${gap} hide-scrollbar cursor-grab"
>
                  ${slidesHTML}
                </div>
                <!-- left button -->
                <button
                  id="prevBtn"
                  onclick="carouselPrev('carousel-${uuid}')"
                  class="absolute left-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6 rotate-180"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
                <!-- right button -->
                <button
                  id="nextBtn"
                  onclick="carouselNext('carousel-${uuid}')"
                  class="absolute right-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
              </div>
            </div>
          </div>
        `,

  heroDesktopTemplate: (title, subtitle, slidesHTML, textColor, bgColor,uuid, desktopSize, gap,mainLink) => `
        <div id="carousel-container-hero-desktop" class="hidden py-4 md:flex w-full container relative" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="grid w-full grid-cols-1 lg:grid-cols-3 place-content-center place-items-center">
              <div class="relative flex flex-col w-full gap-[0.5rem] text-center md:text-left lg:pr-[2.8125rem]">
                <a id="hero-link" href="${mainLink}" target="_blank" class="absolute inset-0 z-10"></a>
                <h1 id="Title" class="md:text-[3.5rem] text-[1.75rem] leading-none hover:underline font-central-sang-bleu">${
                  title || "TITLE"
                }</h1>
                <p id="Subtitle" class="text-[0.875rem] md:text-[1rem]">${subtitle || "SUBTITLE"}</p>
              </div>
              <div class="relative grid min-w-full col-span-2 py-6 pl-3 md:px-0">
                <div id="carousel-${uuid}" class="grid grid-flow-col md:auto-cols-[calc(${desktopSize}%-0.5rem)] select-none font-bebas-neue w-full gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl md:text-base md:gap-${gap} hide-scrollbar cursor-grab"
>
                  ${slidesHTML}
                </div>
                <!-- Navigation buttons -->
                <!-- left button -->
                <button
                  id="prevBtn"
                  onclick="carouselPrev('carousel-${uuid}')"
                  class="absolute left-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6 rotate-180"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
                <!-- right button -->
                <button
                  id="nextBtn"
                  onclick="carouselNext('carousel-${uuid}')"
                  class="absolute right-0 z-10 hidden p-2 transition-colors -translate-y-1/2 bg-white bg-opacity-75 md:block top-1/2 hover:bg-gray-300"
                >
                  <img
                    class="w-6 h-6"
                    src="https://assets.central.co.th/is/image/cenergy/arrowRight?$PNG$"
                  />
                </button>
              </div>
            </div>
          </div>
      `,

  heroMobileTemplate: (title, subtitle, slidesHTML, textColor, bgColor,uuid, mobileSize, gap,mainLink) => `
        <div id="carousel-container-hero-mobile" class="sm:hidden py-4 flex w-full container relative" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="grid w-full grid-cols-1 lg:grid-cols-3 place-content-center place-items-center">
              <div class="relative flex flex-col w-full gap-[0.5rem] text-center md:text-left lg:pr-[2.8125rem]">
                <a id="hero-link" href="${mainLink}" target="_blank" class="absolute inset-0 z-10"></a>
                <h1 id="Title" class="md:text-[3.5rem] text-[1.75rem] leading-none hover:underline font-central-sang-bleu">${
                  title || "TITLE"
                }</h1>
                <p id="Subtitle" class="text-[0.875rem] md:text-[1rem]">${subtitle || "SUBTITLE"}</p>
              </div>
              <div class="relative grid min-w-full col-span-2 py-6 pl-3 md:px-0">
                <div id="carousel-${uuid}" class="grid grid-flow-col auto-cols-[calc(${mobileSize}%-0.5rem)] select-none font-bebas-neue w-full gap-${gap/2} overflow-x-auto overflow-y-hidden text-xl md:text-base md:gap-${gap} hide-scrollbar cursor-grab"
>
                  ${slidesHTML}
                </div>
              </div>
            </div>
          </div>
      `,

  grid: (title, gridCols, slidesHTML, textColor, bgColor,uuid) => `
          <div id="carousel-container-grid" class="py-4 bg-white min-w-screen" style="color: ${textColor}; background-color: ${bgColor}">
            <div class="container mx-auto max-w-[1200px]">
              <h1 id="Title" class="md:text-[30px] mb-6 text-[20px] text-left font-bold">${
                title || "TITLE"
              }</h1>
              <div class="grid grid-cols-${gridCols} gap-6">
                ${slidesHTML}
              </div>
            </div>
          </div>
        `,
};
