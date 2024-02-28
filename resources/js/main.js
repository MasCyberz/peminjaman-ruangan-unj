const linkcolor = document.querySelectorAll(".link");

function colorlink() {
    linkcolor.forEach((l) => l.classList.remove("active-link"));
    this.classList.add("active-link");
}

linkcolor.forEach((l) => l.addEventListener("click", colorlink));

// const showmenu = (toggleId, navbarId) => {
//     const toggle = document.getElementById(toggleId),
//           navbar = document.getElementById(navbarId)

//     if(toggle && navbar){
//         toggle.addEventListener('click', () =>{
//             navbar.classList.toggle('show-menu')
//         })
//     }
// }
// showmenu('navtoggle', 'sidebar')

const sidebar = document.querySelector("#sidebar");
const toggle = document.querySelector("#toggle");

toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

const swup = new Swup({
    plugins: [new SwupSlideTheme()],
});
