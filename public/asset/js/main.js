
let nbContact =  localStorage.getItem('nbContact');
let nbAvis = localStorage.getItem('nbAvis');

    fetch(routeCountContact,{
        method:"GET",
        headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Content-Type':'application/json'
        },
        //body: JSON.stringify({"_token":link.dataset.token})

    }).then(response => response.json())
        .then(data =>{
            localStorage.setItem('nbContact', data.nbContact);
          affichecountContact(data.nbContact)
            afficheSommes(parseInt(nbAvis) + parseInt(data.nbContact));
        })

function affichecountContact(nb)
{
    let span = document.querySelector("#countContact");

    span.innerHTML= nb;
}
function affichecountAvis(nb){
    let span = document.querySelector("#countAvis");
    span.innerHTML = nb;
}
function afficheSommes(nb)
{
    console.log(nb);
    let span = document.querySelector('#countSomme')
    span.innerHTML = nb;
}
if(nbAvis == null || nbAvis)
{
    getCountAvis()
}else{
    affichecountAvis(nbAvis);
}

function getCountAvis()
{
    fetch(routeCountAvis,{
        method:"GET",
        headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Content-Type':'application/json'
        },
        //body: JSON.stringify({"_token":link.dataset.token})

    }).then(response => response.json())
        .then(data =>{
            localStorage.setItem('nbAvis', data.nbCountAvis);
            affichecountAvis(data.nbCountAvis);
            afficheSommes(parseInt(data.nbCountAvis) + parseInt(nbContact));
        })
}