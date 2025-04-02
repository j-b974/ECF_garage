
const paginator = document.querySelector("#pagination");

function btnprixId() {

    const elMinPrix = document.querySelector('#prixId-min-value');
    const elMaxPrix = document.querySelector('#prixId-max-value');

    let attribut = `minPrix=${elMinPrix.value}&maxPrix=${elMaxPrix.value}`;
    CallData(attribut);
}
function btnkilometrageId() {

    const elMinKm = document.querySelector('#kilometrageId-min-value');
    const elMaxKm = document.querySelector('#kilometrageId-max-value');

    let attribut = `minKm=${elMinKm.value}&maxKm=${elMaxKm.value}`;
    CallData(attribut);
}

function btnanneeId() {

    const elMinDate = document.querySelector('#anneeId-min-value');
    const elMaxDate = document.querySelector('#anneeId-max-value');

    let attribut = `minDate=${elMinDate.value}&maxDate=${elMaxDate.value}`;
    CallData(attribut);
}


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
            if(i % 5 == 0){
                span.appendChild(pageButton)
                divPaginator.appendChild(span);
            }

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
    span&&span.classList.remove('active');
    span&&span.firstElementChild.classList.remove('bg-danger');
    element.parentNode.classList.add('active');
    element.classList.add('bg-danger');

}

//displayList();


// appelle data filtrer

btnValid.addEventListener('click',e=>{
    e.preventDefault();

    const elMinPrix = document.querySelector('#prixId-min-value');
    const elMaxPrix = document.querySelector('#prixId-max-value');

    const elMinKm = document.querySelector('#kilometrageId-min-value');
    const elMaxkm = document.querySelector('#kilometrageId-max-value');

    const elMinDate = document.querySelector('#anneeId-min-value');
    const elMaxDate = document.querySelector('#anneeId-max-value');

    let attribut = `minPrix=${elMinPrix.value}&maxPrix=${elMaxPrix.value}&minKm=${elMinKm.value}&maxKm=${elMaxkm.value}&minDate=${elMinDate.value}&maxDate=${elMaxDate.value}`;
    CallData(attribut);
})

/**
 *
 * @param attribut string "name=valeur "
 *
 * @constructor
 */
function CallData(attribut)
{
    fetch('/Voiture/Occassion/dataUsedCar?'+attribut)
        .then(reponse => reponse.json())
        .then(data =>{

            dataList = data.dataUsedCar;
            divPaginator.innerHTML="";
            supprimePaginator();
            createPaginationButtons();
            displayList();
        })

}
