let links = document.querySelectorAll("[data-delete]");
links.forEach( link => {
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
                        link.parentElement.remove();
                    }else{
                        alert(data.error);
                    }
                })
        }
    })
})
