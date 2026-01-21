document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".sidebar a");
    const sections = document.querySelectorAll(".setting-section");
    const menuItems = document.querySelectorAll(".sidebar li");

    document.getElementById("personal-info").classList.add("active");

    links.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("data-target");

            sections.forEach((section) => {
                section.classList.remove("active");
            });

            menuItems.forEach((item) => {
                item.classList.remove("active");
            });

            document.getElementById(targetId).classList.add("active");
            this.parentElement.classList.add("active");
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".sidebar a");
    const sections = document.querySelectorAll(".setting-section");
    const menuItems = document.querySelectorAll(".sidebar li");
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.querySelector(".sidebar-toggle");

    document.getElementById("personal-info").classList.add("active");

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("active");
    });

    links.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("data-target");

            sections.forEach((section) => section.classList.remove("active"));
            menuItems.forEach((item) => item.classList.remove("active"));

            document.getElementById(targetId).classList.add("active");
            this.parentElement.classList.add("active");

            // Auto close sidebar on mobile
            if (window.innerWidth <= 767) {
                sidebar.classList.remove("active");
            }
        });
    });
});
