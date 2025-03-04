document.addEventListener("DOMContentLoaded", function () {
    const filterContainer = document.getElementById("selected-filters");

    function addFilterCat(cuisine) {
        if (document.querySelector(`.filter-tag[data-cuisine="${cuisine}"]`)) {
            return;
        }

        const filterTag = document.createElement("span");
        filterTag.classList.add("filter-tag");
        filterTag.setAttribute("data-cuisine", cuisine);
        filterTag.innerHTML = `${cuisine} <span class="close">&times;</span>`;

        filterContainer.appendChild(filterTag);

        filterTag.querySelector(".close").addEventListener("click", function () {
            filterTag.remove();
        });
    }

    function addFilterRestaurant(restaurant) {
        if (document.querySelector(`.filter-tag[data-restaurant="${restaurant}"]`)) {
            return;
        }

        const filterTag = document.createElement("span");
        filterTag.classList.add("filter-tag");
        filterTag.setAttribute("data-restaurant", restaurant);
        filterTag.innerHTML = `${restaurant} <span class="close">&times;</span>`;

        filterContainer.appendChild(filterTag);

        filterTag.querySelector(".close").addEventListener("click", function () {
            filterTag.remove();
        });
    }
    
    
    document.querySelectorAll(".restaurant-item").forEach(function (item) {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            addFilterRestaurant(this.dataset.restaurant);
        });
    });

    document.querySelectorAll(".category-item").forEach(function (item) {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            addFilterCat(this.dataset.cuisine);
        });
    });
});
