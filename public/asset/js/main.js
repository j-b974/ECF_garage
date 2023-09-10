
let nbContact = parseInt( localStorage.getItem('nbContact'));
let nbAvis = parseInt(localStorage.getItem('nbAvis'));

if(null != null){
    affichecountContact(nbContact);
}else{

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
        })
}

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
    let span = document.querySelector('#countSomme')
    span.innerHTML = nb;
}
if(nbAvis == null)
{
    console.log('ici')
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
        })
}else{
    affichecountAvis(nbAvis);
}
afficheSommes(nbAvis + nbContact);