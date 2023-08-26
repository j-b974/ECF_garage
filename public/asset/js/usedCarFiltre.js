let rangeMin = 10;
//let range = document.querySelector(".range-selected");
const rangeInput = document.querySelectorAll(".range-input input");
const rangePrice = document.querySelectorAll(".range-price input");
let range1
rangeInput.forEach((input) => {
    input.addEventListener("input", function(e)  {

       let range = input.parentElement.parentElement.querySelector(".range-selected");
        let minRange = parseInt(this.parentNode.firstElementChild.value);
        let maxRange = parseInt(this.parentNode.lastElementChild.value);

        if (maxRange - minRange < rangeMin) {
            if (e.target.className === "min") {
                this.value = maxRange - rangeMin;
            } else {
                this.value = minRange + rangeMin;
            }
        } else {

            this.parentNode.parentNode.lastElementChild.children[0].value = minRange;
            this.parentNode.parentNode.lastElementChild.children[1].value = maxRange;

            range.style.left = (minRange / parseInt(this.parentNode.firstElementChild.max)) * 100 + "%";
            range.style.right = 100 - (maxRange / parseInt(this.parentNode.lastElementChild.max)) * 100 + "%";
            //range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
            //range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";

        }
    });
});
rangePrice.forEach((input) => {
    input.addEventListener("input",function (e) {
       let range = input.parentElement.parentElement.querySelector(".range-selected");

       let inputMin = this.parentNode.parentNode.lastElementChild.children[0]
        let rangeMax = this.parentNode.parentNode.lastElementChild.children[1]
        let slidMin = this.parentNode.parentNode.children[2].children[0]
        let slidMax = this.parentNode.parentNode.children[2].children[1]

        //console.log('min', rangeMin ,'max ',rangeMax)
        let minPrice =parseInt( inputMin.value);
        let maxPrice = parseInt(rangeMax.value);
        //console.log(rangeMax.value , maxPrice)
        //console.log(maxPrice <= slidMax.max)
        //console.log(slidMax.max)

        if (maxPrice - minPrice >= rangeMin && maxPrice <= parseInt(slidMax.max)) {

            console.log(e.target.className)
            if (e.target.className === "min") {
                console.log('ici')
                slidMin.value = minPrice;
                range.style.left = (minPrice / parseInt(slidMin.max)) * 100 + "%";

            } else {

                slidMax.value = maxPrice;
                range.style.right = 100 - (maxPrice / parseInt(slidMax.max)) * 100 + "%";
            }
        }
    });
});

