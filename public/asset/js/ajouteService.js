
const btnAjout = document.querySelector('#btnAjoute');
const card = document.querySelector('#card')
let count = 0
console.log('ok');
btnAjout.addEventListener('click', function(e){
    e.preventDefault();
count++
   hr = document.createElement('hr');
   div = document.createElement('div');
   div.className ="card-body "
   div.innerHTML =`
    <div class="d-flex flex-column">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bg-dark text-white" id="basic-addon1">nom service</span>
            </div>
            <input type="text" name ="nomService[new${count}]" class="form-control" placeholder="nom service" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bg-dark text-white" id="basic-addon1">label Prix</span>
            </div>
            <input type="text" name="labelPrix[new${count}]" class="form-control" placeholder="34€/heure" aria-label="Username" aria-describedby="basic-addon1">
        </div>
    </div>
`;
   card.insertBefore(hr,this.parentNode);
    card.insertBefore( div ,this.parentNode);
    this.parentNode.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"})
} )

// ================= modification ==================

const lstBtnSupprime = document.querySelectorAll('[delete]')
lstBtnSupprime.forEach(function(btn){
    btn.addEventListener('click', function(event){
       let id =  this.getAttribute('delete');
       let card = document.querySelector('#card'+id);
       let hr = document.querySelector('#hr'+id);
       hr.remove();
       card.remove();
       this.parentNode.remove();
    })
})