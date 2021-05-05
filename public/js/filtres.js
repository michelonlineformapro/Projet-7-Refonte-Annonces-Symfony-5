window.onload = () => {
    const FiltresForm = document.querySelector('#filtres');
    //Boucle sur le input
    document.querySelectorAll('#filtres input').forEach(input => {
        input.addEventListener('change', () =>{
            //Case cochée
            console.log('coché')
            //Donnée du formulaire
            const Form = new FormData(FiltresForm);
            //Url du queryString generer quand on coche
            const Params = new URLSearchParams();

            //Boucle cle + valeur
            Form.forEach((value, key) =>{
                console.log(key, value);
                //Creer une url queryString
                Params.append(key, value);
                console.log(Params.toString())
            });

            //Url de la page courante
            const Url = new URL(window.location.href);
            console.log(Url);

            //Creer la requète Ajax Fetch
            //Fetch retourne une promesse donc on utilise .then
            //Url.pathname = /annonces/ + ? ($_GET[''] + adresse quand on coche (id des checkboxe) + ajax bool
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                //Entete HTTP
                headers:{
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => response.json())
                .then(data => {
                    //Mise a jour de url page

                    //Inject dans le div vide
                    const content = document.querySelector("#resultat_categorie_ajax");
                    content.innerHTML = data.content
                    const link = document.querySelector("a.page-link")
                    if(link){
                        link.setAttribute('href', Url.pathname + "?" + Params.toString() + "&ajax=0");
                    }
                    //Paramètre = des données + title de onglet + url historique ATTENTION pa d'ajax ici
                    history.pushState({}, null, Url.pathname + "?" + Params.toString() + "&ajax=0")


                    console.log(data.content)


            }).catch(error => alert(error))
        });
    });
}