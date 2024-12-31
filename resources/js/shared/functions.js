

function setCookie(name, value) {
    var d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function toggleDarkMode(element, classes, cookieData) {
    if (element.classList.contains(classes.lightmode)) {
        element.classList.add(...classes.darkmode.split(' '));
        element.classList.remove(...classes.lightmode.split(' '));
        setCookie(cookieData.name, cookieData.darkmodeValue);
    } else {
        element.classList.remove(...classes.darkmode.split(' '));
        element.classList.add(...classes.lightmode.split(' '));
        setCookie(cookieData.name, cookieData.lightmodeValue);
    }
}


export { toggleDarkMode, getCookie };
