function fetchResponse(response) {
    if (!response.ok) {
        return null;
    }
    return response.json();
}

function fetchAnalisi(json){
    const T = document.querySelector("#tipo");
    const Q = document.querySelector("#quantità");
    const D = document.querySelector("#data");
    const C = document.querySelector("#città");

    while(T.firstChild){
        T.removeChild(T.lastChild);
    }
    while(Q.firstChild){
        Q.removeChild(Q.lastChild);
    }
    while(D.firstChild){
        D.removeChild(D.lastChild);
    }
    while(C.firstChild){
        C.removeChild(C.lastChild);
    }

    if(json){
        for(let i in json){
            const t = document.createTextNode(json[i].tipo);
            const q = document.createTextNode(json[i].quantita);
            const d = document.createTextNode(json[i].data);
            const p = document.createTextNode(json[i].citta + " " + json[i].via);
            const br1= document.createElement("br");
            const br2= document.createElement("br");
            const br3= document.createElement("br");
            const br4= document.createElement("br");

            const tipe = document.createElement("a");
            tipe.classList.add("details");
            tipe.appendChild(t);
            const quantity = document.createElement("a");
            quantity.classList.add("details");
            quantity.appendChild(q);        
            const date = document.createElement("a");
            date.classList.add("details");
            date.appendChild(d);        
            const place = document.createElement("a");
            place.classList.add("details");
            place.appendChild(p);
            

            T.appendChild(tipe);
            T.appendChild(br1);
            Q.appendChild(quantity);
            Q.appendChild(br2);
            D.appendChild(date);
            D.appendChild(br3);
            C.appendChild(place);
            C.appendChild(br4);
        }
    }else{
        const text = document.createElement("a");
        const tex = document.createTextNode("Non hai effettuato ancora nessuna donazione");

        const sana= document.querySelector("don");
        text.appendChild(tex);
        sana.appendChild(text);
    }
}

function fetchHome(){
    const d=document.getElementById("don");
    if(d.classList.contains("hidden")){
        d.classList.add("don");
        d.classList.remove("hidden");
    }
    document.getElementById("form").classList.add("hidden");
    document.getElementById("prenotazione").classList.add("hidden");

    if(document.getElementById("pren").classList.contains("hidden")){
        document.getElementById("pren").classList.add("link");
        document.getElementById("pren").classList.remove("hidden");
        document.getElementById("pren").addEventListener("click", fetchPrenota);
    }
    if(document.getElementById("mdati").classList.contains("hidden")){
        document.getElementById("mdati").classList.add("link");
        document.getElementById("mdati").classList.remove("hidden");
        document.getElementById("mdati").addEventListener("click", fetchModifica);
    }
    document.getElementById("home").classList.remove("link");
    document.getElementById("home").classList.add("hidden");

    fetch("fetchDon.php").then(fetchResponse).then(fetchAnalisi);
}

function fetchModifica(event){
    document.getElementById("form").classList.remove("hidden");
    const d = document.getElementById("don");
    if(!d.classList.contains("hidden")){
        d.classList.remove("don");
        d.classList.add("hidden");
    }

    document.getElementById("prenotazione").classList.add("hidden");


    if(document.getElementById("pren").classList.contains("hidden")){
        document.getElementById("pren").classList.add("link");
        document.getElementById("pren").classList.remove("hidden");
        document.getElementById("pren").addEventListener("click", fetchPrenota);
    }
    if(document.getElementById("home").classList.contains("hidden")){
        document.getElementById("home").classList.add("link");
        document.getElementById("home").classList.remove("hidden");
        document.getElementById("home").addEventListener("click", fetchHome);
    }
    document.getElementById("mdati").classList.remove("link");
    document.getElementById("mdati").classList.add("hidden");


    document.querySelector(".telefono input").addEventListener("blur", checkTelefono);
    document.querySelector(".data input").addEventListener("blur", checkData);
    document.querySelector(".città input").addEventListener("blur", checkCitta);
    document.querySelector(".via input").addEventListener("blur", checkVia);
    document.querySelector(".peso input").addEventListener("blur", checkPeso);
    checkForm();
}

function checkTelefono(event) {
    const telInput = document.querySelector('.telefono input');
    if (telInput.value.length < 10 || telInput.value.length > 11 ) {
        document.querySelector('.telefono').classList.add('errorj');
        document.querySelector(".telefono span").classList.remove("hide");
    }else {
        document.querySelector('.telefono').classList.remove('errorj');
        document.querySelector(".telefono span").classList.add("hide");
    }
    checkForm();
}

function checkData(event) {
    const dataInput = document.querySelector('.data input');
    if ( dataInput.value >= new Date().toISOString().slice(0, 10)) {
        document.querySelector('.data').classList.add('errorj');
        document.querySelector(".data span").classList.remove("hide");
    } else {
        document.querySelector('.data').classList.remove('errorj');
        document.querySelector(".data span").classList.add("hide");
    }
    checkForm();
}

function checkCitta(event) {
    const cittàInput = document.querySelector('.città input');
    if (cittàInput.value.length > 0) {
        document.querySelector('.città').classList.remove('errorj');
        document.querySelector(".città span").classList.add("hide");
    } else {
        document.querySelector('.città').classList.add('errorj');
        document.querySelector(".città span").classList.remove("hide");
    }
    checkForm();
}

function checkVia(event) {
    const viaInput = document.querySelector('.via input');
    if (viaInput.value.length > 0) {
        document.querySelector('.via').classList.remove('errorj');
        document.querySelector(".via span").classList.add("hide");
    } else {
        document.querySelector('.via').classList.add('errorj');
        document.querySelector(".via span").classList.remove("hide");
    }
    checkForm();
}

function checkPeso(event) {
    const pesoInput = document.querySelector('.peso input');
    if (pesoInput.value <= 30) {
        document.querySelector('.peso').classList.add('errorj');
        document.querySelector(".peso span").classList.remove("hide");
    } else {
        document.querySelector('.peso').classList.remove('errorj');
        document.querySelector(".peso span").classList.add("hide");
    }
    checkForm();
}   

function checkForm(){
    const tel = document.querySelector(".telefono");
    const data = document.querySelector(".data");
    const cit = document.querySelector(".città");
    const via = document.querySelector(".via");
    const peso = document.querySelector(".peso");
    if(tel.classList.contains("errorj")||data.classList.contains("errorj")||cit.classList.contains("errorj")||via.classList.contains("errorj")||peso.classList.contains("errorj")){
        document.getElementById("submit").disabled=true;
    }else{
        document.getElementById("submit").disabled=false;

    }
}

function fetchPrenotazione(json){
    const T = document.querySelector("#codice");
    const D = document.querySelector("#pdata");
    const C = document.querySelector("#pcittà");

    while(T.firstChild){
        T.removeChild(T.lastChild);
    }
    while(D.firstChild){
        D.removeChild(D.lastChild);
    }
    while(C.firstChild){
        C.removeChild(C.lastChild);
    }

    if(json){
        const codice = document.createElement("h4");
        const data = document.createElement("h4");
        const sede = document.createElement("h4");
        const cod = document.createTextNode("Codice prenotazione");
        const date = document.createTextNode("Data");
        const sed = document.createTextNode("Sede");

        codice.appendChild(cod);
        data.appendChild(date);
        sede.appendChild(sed);
        T.appendChild(codice);
        D.appendChild(data);
        C.appendChild(sede);

        const c = document.createElement("a");
        const ct = document.createTextNode(json[0].codpren);
        c.appendChild(ct);
        T.appendChild(c);

        const d = document.createElement("a");
        const dt = document.createTextNode(json[0].data);
        d.appendChild(dt);
        D.appendChild(d);

        const s = document.createElement("a");
        const st = document.createTextNode(json[0].citta + " " + json[0].via);
        s.appendChild(st);
        C.appendChild(s);

    }
}

function fetchEffPren(json){
    //document.querySelectorAll(".sede").forEach(e => e.remove());
    if(json){
        for(let i in json){
            const s= document.createElement("div");
            s.classList.add("sede");

            const nome = document.createElement("a");
            const n = document.createTextNode(json[i].nome);
            nome.appendChild(n);
            s.appendChild(nome);
            const luogo = document.createElement("a");
            const l = document.createTextNode(json[i].citta + " " + json[i].via);
            luogo.appendChild(l);
            s.appendChild(luogo);

            const f = document.createElement("form");
            f.setAttribute('method',"post"); 

            const inp = document.createElement("input");
            inp.setAttribute('type',"date");
            inp.setAttribute('name',"ndata");

            const name = document.createElement("input");
            name.setAttribute('type', "hidden");
            name.setAttribute('name', "sede");
            name.setAttribute('value', json[i].codsede);

            const su = document.createElement("input");
            su.setAttribute('type',"submit");
            su.setAttribute('value',"Prenota");

            f.appendChild(inp);
            f.appendChild(name);
            f.appendChild(su);
            s.appendChild(f);

            document.getElementById("effpren").appendChild(s);
        }


    }
}

function fetchPrenota(event){
    document.getElementById("prenotazione").classList.remove("hidden");
    const d = document.getElementById("don");
    if(!d.classList.contains("hidden")){
        d.classList.remove("don");
        d.classList.add("hidden");
    }

    const l = document.getElementById("form");
    if(!l.classList.contains("hidden")){
        l.classList.add("hidden");
    }

    if(document.getElementById("mdati").classList.contains("hidden")){
        document.getElementById("mdati").classList.add("link");
        document.getElementById("mdati").classList.remove("hidden");
        document.getElementById("mdati").addEventListener("click", fetchModifica);
    }
    if(document.getElementById("home").classList.contains("hidden")){
        document.getElementById("home").classList.add("link");
        document.getElementById("home").classList.remove("hidden");
        document.getElementById("home").addEventListener("click", fetchHome);
    }
    document.getElementById("pren").classList.remove("link");
    document.getElementById("pren").classList.add("hidden");

    fetch("fetchPren.php").then(fetchResponse).then(fetchPrenotazione);
    fetch("fetchSedi.php").then(fetchResponse).then(fetchEffPren);
}

document.querySelector("#mdati").addEventListener("click", fetchModifica);
document.querySelector("#pren").addEventListener("click", fetchPrenota);
fetchHome();