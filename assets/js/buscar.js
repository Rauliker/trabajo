let provincias = document.getElementById("provincias");
let municipios = document.getElementById("municipios");
let tipo = document.getElementById("tipo");
let superficie = document.getElementById("superficie");
let hab = document.getElementById("nhab");
let prec = document.getElementById("prec");
let fecha = document.getElementById("fecha");
let construccion = document.getElementById("construccion");
let estado = document.getElementById("estado");
let filtros = document.getElementById("filtros");
let mfiltro = document.getElementById("filtr");
let divFiltro = document.getElementById("filt");

let botonDer = document.getElementsByClassName("botonDer");
let botonIzq = document.getElementsByClassName("botonIzq");
function mostrar() {
  divStyle = getComputedStyle(divFiltro).display;
  if (divStyle == "none") {
    divFiltro.style.display = "block";
    divFiltro.style.border = "2px solid gray";
    divFiltro.style.backgroundColor = "#f5f5f5";
  } else {
    divFiltro.style.display = "none";
  }
}

async function filtrar() {
  try {
    let container = document.querySelector(".container");
    container.innerHTML = "";

    // Obtener los datos de result.json
    const response = await fetch("assets/js/result.json");
    const data = await response.json();

    // Obtener los datos de img.json una sola vez
    const imgResponse = await fetch("assets/js/img.json");
    const imgData = await imgResponse.json();

    const prov = await fetch("assets/js/provincias.json");
    const provincia = await prov.json();

    const mun = await fetch("assets/js/municipios.json");
    const muni = await mun.json();
    let i = 0;
    // Filtrar y procesar los resultados
    data.forEach((result) => {
      // Aplicar condiciones de filtro
      const tipoValido = result.tipo === tipo.value || tipo.value === "todos";
      const provinciaValida =
        result.provincia == provincias.value || provincias.value === "todos";
      const municipioValido =
        result.municiopio == municipios.value || municipios.value === "todos";
      const numHab = result.habitaciones == hab.value || hab.value === "";

      const precios = result.precio == prec.value || prec.value === "";

      const superf =
        result.superficie == superficie.value || superficie.value === "";
      const date = fecha.value <= result.dia;
      const est = estado.value == result.estado || estado.value === "todos";
      const constur =
        construccion.value == result.construccion ||
        construccion.value === "todos";

      if (
        tipoValido &&
        provinciaValida &&
        municipioValido &&
        numHab &&
        precios &&
        superf &&
        date &&
        est &&
        constur
      ) {
        // Encontrar la imagen correspondiente en imgData
        const images = imgData.filter((img) => img.id_vivienda == result.id);

        if (images.length > 0) {
          // Crear elemento de listado de imágenes
          let listingDiv = document.createElement("div");
          listingDiv.classList.add("listing");

          let listingImage = document.createElement("div");
          listingImage.classList.add("listing-image");

          /*if (images.length > 1) {
            // Agregar botones de navegación izquierda y derecha
            let botonIzq = document.createElement("div");
            botonIzq.classList.add("botonIzq");
            botonIzq.textContent = "<";
            listingImage.appendChild(botonIzq);
          }*/
          let listingDiva = document.createElement("div");
          listingDiva.classList.add(result.id);
          // Mostrar la primera imagen
          let image = document.createElement("img");
          image.src = `images/${images[0].imagen}`;
          image.className = "image";
          image.style.width = "250px";
          image.style.height = "180px";
          listingDiva.appendChild(image);
          listingImage.appendChild(listingDiva);

          /*if (images.length > 1) {
            // Agregar botones de navegación izquierda y derecha
            let botonDer = document.createElement("div");
            botonDer.classList.add("botonDer");
            botonDer.textContent = ">";
            listingImage.appendChild(botonDer);
          }*/

          let listingDetails = document.createElement("div");
          listingDetails.classList.add("listing-details");

          let listingName = document.createElement("div");
          listingName.classList.add("listing-name");
          listingName.textContent = `Nombre: ${result.nombre}`;
          listingDetails.appendChild(listingName);

          let listingPrice = document.createElement("div");
          listingPrice.classList.add("listing-price");
          listingPrice.textContent = `Precio: ${result.precio}€`;
          listingDetails.appendChild(listingPrice);

          let listingAddress = document.createElement("div");
          listingAddress.classList.add("listing-address");
          listingAddress.textContent = `Dirección: ${provincia.nombre} ,${muni.nombre} ,${result.direccion}`;
          listingDetails.appendChild(listingAddress);

          let listingDescription = document.createElement("div");
          listingDescription.classList.add("listing-description");
          listingDescription.textContent = `Descripción: ${result.descrippcion}`;
          listingDetails.appendChild(listingDescription);

          // Agregar elementos al contenedor
          listingDiv.appendChild(listingImage);
          listingDiv.appendChild(listingDetails);
          container.appendChild(listingDiv);
        }
      }
    });
  } catch (error) {
    console.error("Error en la función filtrar:", error);
  }
}

function updateMunicipios() {
  fetch("assets/js/municipios.json") // Fetch data from municipios.json in the same folder
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      municipios.innerHTML = "";
      // Process data
      console.log(provincias.value);
      console.log(municipios.value);
      let newOption = document.createElement("option");
      newOption.value = "todos";
      newOption.name = "todos";
      newOption.textContent = "todos";
      municipios.appendChild(newOption);
      for (let municipio of data) {
        // Loop through municipalities
        if (provincias.value === "todos") {
          let newOption = document.createElement("option");
          newOption.value = municipio.id;
          newOption.name = municipio.id_provincia;
          newOption.textContent = municipio.nombre;
          municipios.appendChild(newOption);
        } else if (municipio.id_provincia === provincias.value) {
          let newOption = document.createElement("option");
          newOption.value = municipio.id;
          newOption.name = municipio.id_provincia;
          newOption.textContent = municipio.nombre;
          municipios.appendChild(newOption);
        }
      }
    });
}

// Declarar un índice para rastrear la imagen actualmente mostrada
let currentIndex = 0; // Variable global para rastrear el índice de la imagen actualmente mostrada

async function mover(direc, ids) {
  try {
    const imgResponse = await fetch("assets/js/img.json");
    const imgData = await imgResponse.json();
    const images = imgData.filter((img) => img.id_vivienda == ids);

    if (images.length > 1) {
      if (direc === "next") {
        currentIndex = (currentIndex + 1) % images.length;
      } else if (direc === "prev") {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
      }

      let listingDiv = document.getElementsByClassName(ids);
      let links = document.getElementById("i" + ids);

      if (listingDiv.length > 0) {
        let firstListingDiv = listingDiv[0];
        firstListingDiv.innerHTML = "";
        let a = document.createElement("a");
        a.id = links.id;
        a.href = links.href;
        let image = document.createElement("img");
        image.innerHTML = "";
        image.src = `images/${images[currentIndex].imagen}`;
        image.className = "image";
        image.style.width = "250px";
        image.style.height = "180px";
        a.appendChild(image);
        firstListingDiv.appendChild(a);
      }
    }
  } catch (error) {
    console.error("Error en la función mover:", error);
  }
}

provincias.addEventListener("change", updateMunicipios);
//filtros.addEventListener("click", filtrar);
mfiltro.addEventListener("click", mostrar);
for (let i = 0; i < botonDer.length; i++) {
  botonDer[i].addEventListener("click", () => mover("next", botonDer[i].id));
}
for (let x = 0; x < botonIzq.length; x++) {
  botonIzq[x].addEventListener("click", () => mover("prev", botonIzq[x].id));
}
