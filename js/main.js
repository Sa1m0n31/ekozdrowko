/* Menu animation */
const mobileMenu = document.querySelector(".mobileMenu");
const mobileMenuChildren = document.querySelectorAll(".mobileMenu>*");
const openMobileMenu = () => {
    gsap.to(mobileMenu, { scaleX: 1, duration: .5 })
        .then(() => {
            gsap.to(mobileMenuChildren, { opacity: 1, duration: .3 });
        })
}

const closeMobileMenu = () => {
    gsap.to(mobileMenuChildren, { opacity: 0, duration: .3 })
        .then(() => {
            gsap.to(mobileMenu, { scaleX: 0, duration: .5 });
        });
}

const addToCart = async (id, n) => {
    const addToCartSingleBtn = document.querySelector(".addToCartBtn--single");
    let url = addToCartSingleBtn.getAttribute('href');
    let newUrl = url;

    if(id) {
        newUrl = await url.replace(/(add-to-cart=).*?(&)/, 'add-to-cart=' + id + "&");
    }
    if(n) {
        newUrl = await newUrl.replace(/(quantity=).*/, 'quantity=' + n);
    }
    await addToCartSingleBtn.setAttribute('href', newUrl);
}

/* Google maps */
let map;
const mapId = document.getElementById("map");

function initMap() {
    const myLatLng = { lat: 51.736264580700514, lng: 19.49366595836616 };
    map = new google.maps.Map(mapId, {
        center: myLatLng,
        zoom: 13,
    });

    /* Add marker */
    let marker = new google.maps.Marker({
        position: myLatLng,
        map,
        title: "Delikatesy Ekologiczne Zdrówko",
    });
    marker.addListener("click", () => {
        map.setZoom(18);
    });
}
if(mapId) initMap();

/* Add to cart popup - Polish captions */
const viewCartBtn = document.querySelector(".xoo-cp-btn-vc");
const continueShippingBtn = document.querySelector(".xoo-cp-btns>.xoo-cp-close");

if(viewCartBtn) {
    viewCartBtn.textContent = "Zobacz koszyk";
    continueShippingBtn.textContent = "Kontynuuj zakupy";
}


/* Landing paralax animation */
const landing = document.querySelector(".landingSiemaOverlay");
if(landing) {
    window.addEventListener("scroll", () => {
       landing.style.opacity = (window.pageYOffset / 1000).toString();
    });
}

/* Top menu hover */
const menuHover = () => {
    const topMenu = document.querySelector(".topMenu");
}

/* Landing page Siema carousel */
const landingSiemaSelector = document.querySelector(".landingContainer");
const landingDots = document.querySelectorAll(".landingDot");
let landingSiema;
if(landingSiemaSelector) {
    gsap.set(landingDots[0], { background: "#518218" });
    landingSiema = new Siema({
        selector: ".landingSiema",
        perPage: 1,
        loop: true,
        onChange: () => {
            gsap.set(landingDots, {background: "#fff"});
            gsap.set(landingDots[landingSiema.currentSlide], {background: "#518218"});
        }
    });
}

const landingNext = () => {
    landingSiema.next();
}

const landingPrev = () => {
    landingSiema.prev();
}

const landingGoTo = (n) => {
    landingSiema.goTo(n);
}

/* Show categories in shop (mobile) */
const showCategories = () => {
    if(window.innerWidth <= 700) {
        const categoriesMenu = document.querySelector(".menu-produkty-container");
        const arrow = document.querySelectorAll(".sklepMenu__mobileBtn__img")[0];
        let tl = gsap.timeline();

        if(!localStorage.getItem('zdrowko-show-categories')) {
            localStorage.setItem('zdrowko-show-categories', 'T');
            tl.set(categoriesMenu, { display: "block" });
            tl.set(arrow, { rotate: 180 });
            tl.to(categoriesMenu, { opacity: 1, duration: .4 });
        }
        else {
            localStorage.removeItem('zdrowko-show-categories');
            tl.to(categoriesMenu, { opacity: 0, duration: .4 });
            tl.set(categoriesMenu, { display: "none" });
            tl.set(arrow, { rotate: 0 });
        }
    }
}

/* Show producenci in shop (mobile) */
const showProducenci = () => {
    if(window.innerWidth <= 700) {
        const producenciMenu = document.querySelector(".menu-producenci-container");
        const arrow = document.querySelector(".sklepMenu__mobileBtn__img--producenci");
        let tl = gsap.timeline();

        if(!localStorage.getItem('zdrowko-show-producenci')) {
            localStorage.setItem('zdrowko-show-producenci', 'T');
            tl.set(producenciMenu, { display: "block" });
            tl.set(arrow, { rotate: 180 });
            tl.to(producenciMenu, { opacity: 1, duration: .4 });
        }
        else {
            localStorage.removeItem('zdrowko-show-producenci');
            tl.to(producenciMenu, { opacity: 0, duration: .4 });
            tl.set(producenciMenu, { display: "none" });
            tl.set(arrow, { rotate: 0 });
        }
    }
}

/* Ajax add to cart */
let popup = document.querySelector(".addToCartPopup");

document.addEventListener('DOMContentLoaded', async () => {
    let queryParams = window.location.search;
    let add = new URLSearchParams(queryParams);
    if(add.get('add-to-cart')) {
        setCartPopup();
        history.pushState({}, null, "http://skylo-test2.pl/sklep");
    }

    /* Assume we're in shop - get current category */
    /* 1. Get content of produkty menu */
    const produktyMenu = document.querySelectorAll("#menu-produkty>li");
    const produktySubmenu = document.querySelectorAll("#menu-produkty>li>ul>li");
    const produktyAll = [];

    produktyMenu.forEach(item => {
        let newTextContent = item.textContent.toLowerCase().replace(' ', '-');
        produktyAll.push(newTextContent);
    });

    produktySubmenu.forEach(item => {
        let newTextContent = item.textContent.toLowerCase().replace(' ', '-');
        produktyAll.push(newTextContent);
    });

    /* 2. Replace polish letters */
    await produktyAll.forEach((item, index) => {
         produktyAll[index] = item.replace('ą', 'a').replace('ć', 'c').replace('ę', 'e').replace('ł', 'l').replace('ń', 'n').replace('ó', 'o').replace('ś', 's').replace('ż', 'z').replace('ź', 'z');
    });

    /* 3. Check which is equal to current category */
    let categoryArray = window.location.href.split("/");
    let category = categoryArray[categoryArray.length-2];

    produktyAll.forEach((item, i) => {
        console.log(item + " vs " + category);
        if(item === category) {
            console.log(i);
            if(produktyMenu[i]) produktyMenu[i].style.color = "#51821B !important";
        }
    })
});

const setCartPopup = () => {
    popup.style.display = "flex";
    popup.style.opacity = 1;
}

const popupExit = () => {
    popup.style.opacity = 0;
    setTimeout(() => {
        popup.style.display = "none";
    }, 500);
}

/* Initialize product amount */
if(document.querySelector(".singleMain")) {
    localStorage.setItem('zdrowko-amount', 1);
}

/* Set product amount (on single product page */
const showAmount = document.querySelector(".lessMoreBtn--amount");
const setProductAmount = (n) => {
    localStorage.setItem('zdrowko-amount', n);
    if(parseInt(localStorage.getItem('zdrowko-amount'))<1) {
        localStorage.setItem('zdrowko-amount', '1');
    }
    showAmount.textContent = localStorage.getItem('zdrowko-amount');
}

/* Change placeholders on Login page */
const loginUsername = document.querySelector(".woocommerce-Input[name=username]");
const loginPassword = document.querySelector(".woocommerce-Input[name=password]");
if(loginUsername) {
    loginUsername.setAttribute('placeholder', 'Adres email');
}
if(loginPassword) {
    loginPassword.setAttribute('placeholder', 'Hasło');
}

/* Change placeholders on Zamowienie page */
const zamowienieFields = document.querySelectorAll(".woocommerce-billing-fields__field-wrapper>p>label");
if(zamowienieFields[0]) {
    const zamowienieInputs = document.querySelectorAll(".woocommerce-billing-fields__field-wrapper>p>span>input");
    let zamowienieTextContents = [];
    zamowienieFields.forEach(item => {
        zamowienieTextContents.push(item.textContent);
    });
    zamowienieInputs.forEach((item, i) => {
        item.setAttribute("placeholder", zamowienieTextContents[i]);
    });
}

/* Change placeholders on Zamowienie page - part 2 */
const zamowienieFields2 = document.querySelectorAll(".woocommerce-shipping-fields__field-wrapper>p>label");
if(zamowienieFields2[0]) {
    const zamowienieInputs = document.querySelectorAll(".woocommerce-shipping-fields__field-wrapper>p>span>input");
    let zamowienieTextContents = [];
    zamowienieFields2.forEach(item => {
        zamowienieTextContents.push(item.textContent);
    });
    zamowienieInputs.forEach((item, i) => {
        item.setAttribute("placeholder", zamowienieTextContents[i]);
    });
}

/* Change placeholders on register page */
const registerFields = document.querySelectorAll(".woocommerce-form-register>p>label");
if(registerFields[0]) {
    const zamowienieInputs = document.querySelectorAll(".woocommerce-form-register>p>input");
    let zamowienieTextContents = [];
    registerFields.forEach(item => {
        zamowienieTextContents.push(item.textContent);
    });
    zamowienieInputs.forEach((item, i) => {
        item.setAttribute("placeholder", zamowienieTextContents[i]);
    });
}

/* Change placeholders on szczegoly konta page */
const szczegolyKontaFields = document.querySelectorAll(".woocommerce-EditAccountForm>p>label");
if(szczegolyKontaFields[0]) {
    const szczegolyKontaInputs = document.querySelectorAll(".woocommerce-EditAccountForm>p>input");
    let zamowienieTextContents = [];
    szczegolyKontaFields.forEach(item => {
        zamowienieTextContents.push(item.textContent);
    });
    szczegolyKontaInputs.forEach((item, i) => {
        item.setAttribute("placeholder", zamowienieTextContents[i]);
    });
}

/* Remove text content from wysylka */
const wysylkaLabel = document.querySelector("label[for=shipping_method_0_flat_rate1]");
if(wysylkaLabel) {
    //wysylkaLabel.textContent = "";
}

/* Clear payment method names */
const paymentMethods = document.querySelectorAll(".wc_payment_method>label");
if(paymentMethods[0]) {
    paymentMethods.forEach(item => {
        item.textContent = "";
    });
}

/* Siema carousels on frontpage */
let siema1 = new Siema({
    selector: "#frontPageSection1",
    perPage: {
        1200: 4,
        900: 3,
        600: 2,
        100: 1
    }
});

let siema2 = new Siema({
    selector: "#frontPageSection2",
    perPage: {
        1200: 4,
        900: 3,
        600: 2,
        100: 1
    }
});

let siema3 = new Siema({
    selector: "#frontPageSection3",
    perPage: {
        1200: 4,
        900: 3,
        600: 2,
        100: 1
    }
});

const siemaLeft1 = () => {
    siema1.prev();
}

const siemaRight1 = () => {
    siema1.next();
}

const siemaLeft2 = () => {
    siema2.prev();
}

const siemaRight2 = () => {
    siema2.next();
}
const siemaLeft3 = () => {
    siema3.prev();
}

const siemaRight3 = () => {
    siema3.next();
}