var BASE_PATH = window.location.pathname.includes("/views/") ? "../" : "./";
// O mejor aún, comprueba si ya existe:
if (typeof BASE_PATH === "undefined") {
  var BASE_PATH = window.location.pathname.includes("/views/") ? "../" : "./";
}
var menuBtn = document.getElementById("menuButton");
var closeBtn = document.getElementById("closeMenu");
var sidebar = document.getElementById("sidebar");
var backdrop = document.getElementById("menuBackdrop");

var toggleMenu = () => {
  sidebar?.classList.toggle("-translate-x-full");
  backdrop?.classList.toggle("hidden");
};

menuBtn?.addEventListener("click", toggleMenu);
closeBtn?.addEventListener("click", toggleMenu);
backdrop?.addEventListener("click", toggleMenu);

function addToCart(event) {
  event.preventDefault();

  const submitBtn = event.target.querySelector('button[type="submit"]');
  if (submitBtn) submitBtn.disabled = true;

  const formData = new FormData(event.target);

  fetch(`${BASE_PATH}provider/add_to_cart.php`, {
    method: "POST",
    body: formData,
  })
    .then((r) => r.json())
    .then((data) => {
      if (data.status === "success") {
        // ÉXITO: Aquí puedes redirigir o mostrar un alert simple
        console.log("Producto agregado:", data.message);
        alert("Producto agregado al carrito");
      } else {
        // ERROR LÓGICO (Stock, Login, etc)
        console.error("Error al agregar:", data.message);
        alert(data.message || "Error al agregar producto");
      }
    })
    .catch((e) => {
      // ERROR DE RED O SERVIDOR
      console.error(e);
      alert("Ocurrió un error de conexión");
    })
    .finally(() => {
      // Reactivamos el botón siempre
      if (submitBtn) submitBtn.disabled = false;
    });
}

// Hacemos la función global para que funcione con el onsubmit="..." del HTML
window.addToCart = addToCart;
document.addEventListener("DOMContentLoaded", () => {
  const mobileDropdownBtn = document.querySelector(
    '[data-target="sub-cat-mobile"]',
  );
  if (mobileDropdownBtn) {
    mobileDropdownBtn.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      const targetDiv = document.getElementById(targetId);
      const arrow = this.querySelector(".arrow-icon");

      targetDiv.classList.toggle("hidden");
      if (!targetDiv.classList.contains("hidden")) {
        arrow.style.transform = "rotate(180deg)";
      } else {
        arrow.style.transform = "rotate(0deg)";
      }
    });
  }
});
