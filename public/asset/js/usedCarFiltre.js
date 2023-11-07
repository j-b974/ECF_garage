let rangeMin = 10;
//let range = document.querySelector(".range-selected");
const rangeInput = document.querySelectorAll(".range-input input");
const rangePrice = document.querySelectorAll(".range-price input");
const paginator = document.querySelector("#pagination");
let minPrix , maxPrix ,minKm , maxKm ,minDate ,maxDate;
rangeInput.forEach((input) => {
    input.addEventListener("input", function(e)  {

       let range = input.parentElement.parentElement.querySelector(".range-selected");
        let minRange = parseInt(this.parentNode.firstElementChild.value);
        let maxRange = parseInt(this.parentNode.lastElementChild.value);
        recupData(minRange, this.parentNode.firstElementChild)
        recupData(maxRange , this.parentNode.lastElementChild)
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

        recupData(minPrice, inputMin)
        recupData(maxPrice , rangeMax)

        if (maxPrice - minPrice >= rangeMin && maxPrice <= parseInt(slidMax.max)) {

            console.log(e.target.className)
            if (e.target.className === "min") {

                slidMin.value = minPrice;
                range.style.left = (minPrice / parseInt(slidMin.max)) * 100 + "%";

            } else {

                slidMax.value = maxPrice;
                range.style.right = 100 - (maxPrice / parseInt(slidMax.max)) * 100 + "%";
            }
        }
    });
});
// ============

function addUsedCar( viewPage , data){

    let div = document.createElement('div');
    div.className = "col-md-4";

    let { id , prix , kilometrage , anneeFabrication , pathImage} = data;

    div.innerHTML =`
        <div class="card mb-3" style= "max-width: 540px;">
            <div class="row">
                <div class="col-md-4">
                    <img src="${pathImage}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card-body">
                        <h5 class="card-title">prix : ${prix} €</h5>
                        <p class="card-text">kilométrage : ${kilometrage}</p>
                        <p class="card-text">année de frabrication : ${anneeFabrication}</p>
                    </div>
                </div>
            </div>
             <div class="card-footer d-flex justify-content-center">
                <a href="/Voiture-Occassion/${id} "  class="btn btn-dark w-75"> Voir </a>
            </div>
        </div>
    `;
    viewPage.appendChild(div);
}

const viewPage = document.querySelector('#viewPage');
const btnValid = document.querySelector('#btnFiltre');

function recupData(value ,element)
{
    switch (element.dataset.name) {
        case 'minPrix':
            minPrix = value
            break;
        case 'maxPrix':
            maxPrix = value
            minKm = 0;
            maxKm =0;
            minDate =0;
            maxDate=0;
            break;
        case 'minKm':
            minKm = value
            minPrix = maxPrix = minDate = maxDate = 0;
            break;
        case 'maxKm':
            maxKm = value
            break;
            case 'minDate':
            minDate = value
            break;
            case 'maxDate':
            maxDate = value
                minPrix = maxPrix = minKm = maxKm = 0;
            break;
    }

}
function supprimePaginator()
{
    if(paginator)
    {
        paginator.innerHTML = '';
    }
}

// ============== pagination ===============
let dataList = [/* Votre liste de données */];
const itemsPerPage = 9; // Nombre d'éléments à afficher par page
const paginationContainer = document.getElementById("pagination");
const dataListContainer = document.getElementById("data-list");
const divPaginator = document.createElement('div');
divPaginator.className ="pagination";

let currentPage = 1;

function displayList() {
    viewPage.innerHTML = "";
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedData = dataList.slice(start, end);

    for (const data of paginatedData) {

        addUsedCar(viewPage, JSON.parse(data));
    }
}

function createPaginationButtons() {
    const totalPages = Math.ceil(dataList.length / itemsPerPage);
    paginationContainer.innerHTML = "";

    if (totalPages > 1) {
        const previousButton = document.createElement("button");
        const span = document.createElement("span");
        span.className ="page-item"
        previousButton.className="page-link"
        previousButton.textContent = "Précédent";
        previousButton.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                activeClass(divPaginator.childNodes[currentPage].firstChild);
                displayList();
            }
        });
        span.appendChild(previousButton)
        divPaginator.appendChild(span);

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("button");
            const span = document.createElement("span");
            active = '';
            dgClass ="";
            if(currentPage == i ){
                dgClass = 'bg-danger';
                active = 'active';
            }
            span.className =`page-item ${active}`;
            pageButton.className=`page-link ${dgClass}`;

            pageButton.textContent = i;
            pageButton.addEventListener("click", () => {
                currentPage = i;
                activeClass(pageButton);
                displayList();
            });
            span.appendChild(pageButton)
            divPaginator.appendChild(span);
        }

        const nextButton = document.createElement("button");
        nextButton.textContent = "Suivant";
        const span2 = document.createElement("span");
        span2.className ="page-item"
        nextButton.className="page-link"
        nextButton.addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                activeClass(divPaginator.childNodes[currentPage].firstChild);
                displayList();
            }
        });
        span2.appendChild(nextButton);
        divPaginator.appendChild(span2);
        paginationContainer.appendChild(divPaginator);
    }
}
function activeClass(element){


    let span = element.parentNode.parentNode.querySelector('span.active');
    span.classList.remove('active');
    span.firstElementChild.classList.remove('bg-danger');
    element.parentNode.classList.add('active');
    element.classList.add('bg-danger');

}

//displayList();


// appelle data filtrer
btnValid.addEventListener('click',e=>{
    e.preventDefault();
    let attribut = '?minPrix='+minPrix+'&maxPrix='+maxPrix+
        '&minKm='+minKm+'&maxKm='+maxKm+
        '&minDate='+minDate+'&maxDate='+maxDate;

    fetch(btnValid.dataset.link+attribut)
        .then(reponse => reponse.json())
        .then(data =>{

           dataList = data.dataUsedCar;
           divPaginator.innerHTML="";
            supprimePaginator();
            createPaginationButtons();
           displayList();
        })
})
