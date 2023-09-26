linksCon = document.querySelectorAll("[data-delete]");
linksCon.forEach( link => {
    link.addEventListener('click', e=> {
        e.preventDefault();
        if(confirm('Attention la suppression sera definitive !!!')){
            fetch(link.getAttribute('href'),{
                method:"DELETE",
                headers:{
                    'X-Requested-With':'XMLHttpRequest',
                    'Content-Type':'application/json'
                },
                body: JSON.stringify({"_token":link.dataset.token})

            }).then(response => response.json())
                .then(data =>{
                    if(data.success){
                        link.parentElement.parentElement.remove();
                        afficheSuccess(data.message);
                    }else{
                        alert(data.error);
                    }
                })
        }
    })
})

function afficheSuccess(message)
{

    Ndiv = document.createElement('div');
    Ndiv.className = 'text-center alert alert-success alert-dismissible fade show position-sticky';
    Ndiv.setAttribute('role','alert');
    Ndiv.innerHTML = `
                 ${message} 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>      
    `;
    document.body.insertBefore(Ndiv , document.querySelector('div.container'))
}