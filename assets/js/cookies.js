boton = document.getElementById("b");
botonA = document.getElementById("a");
// Función para verificar si se ha aceptado la política de cookies
function verificarCookiesAceptadas() {
  // Obtener todas las cookies del navegador y dividirlas en un array
  var cookies = document.cookie.split(";");

  // Iterar sobre cada cookie
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];

    // Eliminar espacios en blanco al principio y al final de la cookie
    while (cookie.charAt(0) == " ") {
      cookie = cookie.substring(1);
    }

    // Verificar si la cookie de aceptación está presente
    if (cookie.indexOf("cookiesAceptadas=") == 0) {
      // Si la cookie está presente, ocultar el mensaje de política de cookies
      document.getElementById("cookieConsent").style.display = "none";
      return; // Salir de la función ya que no es necesario seguir verificando las cookies
    }
  }
}

// Función para aceptar las cookies
function aceptarCookies() {
  // Ocultar el mensaje de política de cookies
  document.getElementById("cookieConsent").style.display = "none";
  // Establecer una cookie para indicar que se han aceptado las cookies
  document.cookie =
    "cookiesAceptadas=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
}

// Verificar si se han aceptado las cookies al cargar la página
window.onload = verificarCookiesAceptadas;
function rechazrCookies() {
  document.getElementById("cookieConsent").style.display = "none";
}
boton.addEventListener("click", rechazrCookies);
botonA.addEventListener("click", aceptarCookies);
