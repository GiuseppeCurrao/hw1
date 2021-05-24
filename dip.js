function fetchResponse(response) {
    if (!response.ok) {
        return null;
    }
    return response.json();
}

function fetchOrari(json){
    const T = document.querySelector("#nome");
    const Q = document.querySelector("#luogo");
    const C = document.querySelector("#giorno");
    while(T.firstChild){
        T.removeChild(T.lastChild);
    }
    while(Q.firstChild){
        Q.removeChild(Q.lastChild);
    }
    while(C.firstChild){
        C.removeChild(C.lastChild);
    }

    if(json){
        const cod = document.createTextNode("Codice Sede");
        const co = document.createElement("h4");
        co.appendChild(cod);
        T.appendChild(co);

        const k = document.createTextNode("Nome sede");
        const j = document.createElement("h4");
        j.appendChild(k);
        Q.appendChild(j);

        const l = document.createTextNode("Giorni");
        const m = document.createElement("h4");
        m.appendChild(l);
        C.appendChild(m);

        for(let i in json){
            if(json[0].tipo=="medico"){
                const c = document.createTextNode(json[0].codsede);
                const code = document.createElement("a");
                code.appendChild(c);
                T.appendChild(code);

                const n = document.createTextNode(json[0].nome);
                const nome = document.createElement("a");
                nome.appendChild(n);
                Q.appendChild(nome);

                const day = document.createTextNode("Sempre");
                const d = document.createElement("a");
                d.appendChild(day);
                C.appendChild(d);
            }else{
                const c = document.createTextNode(json[i].codsede);
                const code = document.createElement("a");
                code.appendChild(c);
                T.appendChild(code);
                T.appendChild(document.createElement("br"));

                const n = document.createTextNode(json[i].nome);
                const nome = document.createElement("a");
                nome.appendChild(n);
                Q.appendChild(nome);
                Q.appendChild(document.createElement("br"));

                const g = document.createTextNode(json[i].giorni);
                const giorni = document.createElement("a");
                giorni.appendChild(g);
                C.appendChild(giorni);
                C.appendChild(document.createElement("br"));

            }
        }
    }
}

function fetchHome(){
    const d=document.getElementById("dip");
    if(d.classList.contains("hidden")){
        d.classList.add("dip");
        d.classList.remove("hidden");
    }
    document.getElementById("an").classList.add("hidden");
    document.getElementById("trova").classList.add("hidden");

    if(document.getElementById("Tdip").classList.contains("hidden")){
        document.getElementById("Tdip").classList.add("link");
        document.getElementById("Tdip").classList.remove("hidden");
        document.getElementById("Tdip").addEventListener("click", fetchTrova);
    }
    if(document.getElementById("analisi").classList.contains("hidden")){
        document.getElementById("analisi").classList.add("link");
        document.getElementById("analisi").classList.remove("hidden");
        document.getElementById("analisi").addEventListener("click", fetchCarica);
    }
    document.getElementById("home").classList.remove("link");
    document.getElementById("home").classList.add("hidden");

    fetch("fetchOrari.php").then(fetchResponse).then(fetchOrari);
}

function fetchRicerca(event){
    event.preventDefault();
    fetch("dip_pers.php").then(fetchResponse).then(Carica);
}

function Carica(json){
    console.log("caaa");
    const T = document.querySelector("#nome");
    const Q = document.querySelector("#tel");
    const C = document.querySelector("#type");
    while(T.firstChild){
        T.removeChild(T.lastChild);
    }
    while(Q.firstChild){
        Q.removeChild(Q.lastChild);
    }
    while(C.firstChild){
        C.removeChild(C.lastChild);
    }

    if(json){
        for(let i in json){
            const n = document.createElement("a");
            const nome = document.createTextNode(json[i].nome);
            n.appendChild(nome);
            T.appendChild(n);
            T.appendChild(document.createElement("br"));

            const t = document.createElement("a");
            const tel = document.createTextNode(json[i].telefono);
            t.appendChild(tel);
            Q.appendChild(t);
            Q.appendChild(document.createElement("br"));

            const y = document.createElement("a");
            const type = document.createTextNode(json[i].tipo);
            y.appendChild(type);
            C.appendChild(y);
            C.appendChild(document.createElement("br"));
        }
    }
}

function fetchTrova(){
    document.getElementById("trova").classList.remove("hidden");
    const d = document.getElementById("dip");
    if(!d.classList.contains("hidden")){
        d.classList.remove("dip");
        d.classList.add("hidden");
    }

    document.getElementById("an").classList.add("hidden");


    if(document.getElementById("analisi").classList.contains("hidden")){
        document.getElementById("analisi").classList.add("link");
        document.getElementById("analisi").classList.remove("hidden");
        document.getElementById("analisi").addEventListener("click", fetchCarica);
    }
    if(document.getElementById("home").classList.contains("hidden")){
        document.getElementById("home").classList.add("link");
        document.getElementById("home").classList.remove("hidden");
        document.getElementById("home").addEventListener("click", fetchHome);
    }
    document.getElementById("Tdip").classList.remove("link");
    document.getElementById("Tdip").classList.add("hidden");

    document.querySelector("#Tsubmit").addEventListener("submit", fetchRicerca);

}

function fetchCarica(){
    document.getElementById("an").classList.remove("hidden");
    const d = document.getElementById("dip");
    if(!d.classList.contains("hidden")){
        d.classList.remove("dip");
        d.classList.add("hidden");
    }

    document.getElementById("trova").classList.add("hidden");


    if(document.getElementById("Tdip").classList.contains("hidden")){
        document.getElementById("Tdip").classList.add("link");
        document.getElementById("Tdip").classList.remove("hidden");
        document.getElementById("Tdip").addEventListener("click", fetchTrova);
    }
    if(document.getElementById("home").classList.contains("hidden")){
        document.getElementById("home").classList.add("link");
        document.getElementById("home").classList.remove("hidden");
        document.getElementById("home").addEventListener("click", fetchHome);
    }
    document.getElementById("analisi").classList.remove("link");
    document.getElementById("analisi").classList.add("hidden");
}
document.querySelector("#Tdip").addEventListener("click", fetchTrova);
document.querySelector("#analisi").addEventListener("click", fetchCarica);
fetchHome();