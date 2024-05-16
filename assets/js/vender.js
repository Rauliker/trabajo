let provincias = document.getElementById("provincias");
let municipios = document.getElementById("municipios");

function updateMunicipios() {
  fetch("assets/js/municipios.json") // Fetch data from municipios.json in the same folder
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      municipios.innerHTML = "";
      // Process data
      console.log(provincias.value);
      console.log(municipios.value);
      for (let municipio of data) {
        // Loop through municipalities
        if (municipio.id_provincia === provincias.value) {
          let newOption = document.createElement("option");
          newOption.value = municipio.id;
          newOption.name = municipio.id_provincia;
          newOption.textContent = municipio.nombre;
          municipios.appendChild(newOption);
        }
      }
    });
}

provincias.addEventListener("change", updateMunicipios);
