(function() {
    "use strict";

    const imgSlider = document.querySelector(".img-slider");
    const imgSliderList = document.querySelector(".img-slider-list");
    const imgSliderElements = imgSliderList.children;

    let activeItem;
    if (getCookie("activeItem") === undefined || getCookie("pageTitle") === undefined || getCookie("pageTitle") !== document.title) {
        activeItem = 0;
    } else {
        activeItem = parseInt(getCookie("activeItem"))
    }
    imgSliderElements[activeItem].classList.add("slider-item-active");

    if (imgSliderElements.length > 1) {
        let sliderControl = document.createElement("div");
        sliderControl.classList.add("slider-control");

        let buttonLeft = document.createElement("button");
        buttonLeft.classList.add("img-slider-button");
        buttonLeft.classList.add("slider-button-left");
        buttonLeft.type = "button";
        buttonLeft.innerHTML = "&#8249;";
        buttonLeft.addEventListener("click", () => {
            let oldValue = activeItem;
            changeActive(-1);
            imgSliderElements[oldValue].classList.remove("slider-item-active");
            sliderControl.getElementsByClassName("img-slider-dot")[oldValue].classList.remove("dot-active");
            imgSliderElements[activeItem].classList.add("slider-item-active");
            sliderControl.getElementsByClassName("img-slider-dot")[activeItem].classList.add("dot-active");
            setActiveItemCookies();
        });
        sliderControl.append(buttonLeft);

        let buttonRight = document.createElement("button");
        buttonRight.classList.add("img-slider-button");
        buttonRight.classList.add("slider-button-right");
        buttonRight.type = "button";
        buttonRight.innerHTML = "&#8250;";
        buttonRight.addEventListener("click", () => {
            let oldValue = activeItem;
            changeActive(1);
            imgSliderElements[oldValue].classList.remove("slider-item-active");
            sliderControl.getElementsByClassName("img-slider-dot")[oldValue].classList.remove("dot-active");
            imgSliderElements[activeItem].classList.add("slider-item-active");
            sliderControl.getElementsByClassName("img-slider-dot")[activeItem].classList.add("dot-active");
            setActiveItemCookies();
        });
        sliderControl.append(buttonRight);

        for (let i = 0; i < imgSliderElements.length; i++) {
            let sliderDot = document.createElement("span");
            sliderDot.classList.add("img-slider-dot");
            if (i === activeItem) {
                sliderDot.classList.add("dot-active");
            }
            sliderControl.append(sliderDot);
        }

        imgSlider.append(sliderControl);
    }

    // Если больше нуля, то увеличивает. Если меньше нуля, то уменьшает. Если равном нулю, то не изменяет
    function changeActive(value) {
        if (value > 0 && activeItem < imgSliderElements.length - 1) {
            activeItem++;
        } else if (value < 0 && activeItem > 0) {
            activeItem--;
        }
    }

    function setActiveItemCookies() {
        let activeElement = encodeURIComponent("activeItem") + '=' + encodeURIComponent(activeItem);
        let pageTitle = encodeURIComponent("pageTitle") + '=' + encodeURIComponent(document.title);
        let maxAge = "max-age=" + 1000 * 60 * 60;
        document.cookie = activeElement;
        document.cookie = pageTitle;
        document.cookie = maxAge;
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
})();