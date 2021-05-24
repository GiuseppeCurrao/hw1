function infoClick(event)
{
  const frase = event.currentTarget;
  frase.removeEventListener("click", infoClick);
  const scatola = event.currentTarget.parentNode;
  const figli = scatola.childNodes;
  for (let i=0; i< figli.length; i++){
      if(figli[i].classList.contains("hidden") && !figli[i].classList.contains("mdettagli")){
          figli[i].classList.remove("hidden");
      } else if(figli[i].classList.contains("hidden") && figli[i].classList.contains("mdettagli")){
        figli[i].classList.remove("hidden");
        figli[i].addEventListener("click", noInfo);
      }

  }
  frase.classList.add("hidden");
}

function noInfo(event){
    const frase = event.currentTarget;
    frase.removeEventListener("click", noInfo);
    const scatola = event.currentTarget.parentNode;
    const figli = scatola.childNodes;
    for(let i=0; i<figli.length; i++){
      if(!figli[i].classList.contains("hidden") && !figli[i].classList.contains("img")){
        figli[i].classList.add("hidden");
      } else {
        figli[i].classList.remove("hidden");
        figli[i].addEventListener("click", infoClick);
      }
    }
}


function cerca(event){
  event.preventDefault();
  const input = document.querySelector("#nome");
  const locali = document.getElementById("locali");
  const centri = locali.getElementsByClassName("container");
  for(let i =0; i<centri.length; i++){
    const centro = centri[i].querySelector(".titolo");
    if(centro.innerText.toLowerCase().indexOf(input.value.toLowerCase())<0){
      centri[i].classList.add("hidden");
    } else if(centri[i].classList.contains("hidden")){
      centri[i].classList.remove("hidden");
    } 
  }
}


const pics = document.querySelector("#locali");
for (let i=0; i<immagini.length; i++){
    const container = document.createElement("div");
    container.classList.add("container");
    pics.appendChild(container);

    const psrc = immagini[i];
    const image = document.createElement("img");
    image.src = psrc;
    container.appendChild(image);

    const tit = document.createTextNode(titolo[i]);
    const tito = document.createElement("a");
    tito.classList.add("titolo");
    tito.appendChild(tit);
    container.appendChild(tito);

    const box = document.createElement("div");
    box.classList.add("box");
    container.appendChild(box);

    const details = document.createTextNode("Maggiori informazioni");
    const det = document.createElement("a");
    det.classList.add("dettagli");
    det.appendChild(details);
    det.addEventListener("click", infoClick);
    box.appendChild(det);

    const indirizzo = document.createTextNode(via[i]);
    const ind = document.createElement("a");
    ind.classList.add("hidden");
    ind.classList.add("informazioni");
    ind.appendChild(indirizzo);
    box.appendChild(ind);

    const giorno = document.createTextNode(giorni[i]);
    const day = document.createElement("a");
    day.classList.add("hidden");
    day.classList.add("informazioni");
    day.appendChild(giorno);
    box.appendChild(day);

    const orario = document.createTextNode(orari[i]);
    const ora = document.createElement("a");
    ora.classList.add("hidden");
    ora.classList.add("informazioni");
    ora.appendChild(orario);
    box.appendChild(ora);

    const less = document.createTextNode("Riduci");
    const l = document.createElement("a");
    l.classList.add("mdettagli");
    l.classList.add("hidden");
    l.appendChild(less);
    box.appendChild(l);
}

const form = document.querySelector("form");
form.addEventListener("keyup", cerca);
form.addEventListener("submit", cerca);
