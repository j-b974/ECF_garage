
let nbContact = localStorage.getItem('nbContact');
console.log(routeCountContact);
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