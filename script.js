const BASE_PATH = window.location.pathname.includes("/views/") ? "../" : "./";

const menuBtn = document.getElementById("menuButton");
const closeBtn = document.getElementById("closeMenu");
const sidebar = document.getElementById("sidebar");
const backdrop = document.getElementById("menuBackdrop");

const toggleMenu = () => {
  sidebar?.classList.toggle("-translate-x-full");
  backdrop?.classList.toggle("hidden");
};

menuBtn?.addEventListener("click", toggleMenu);
closeBtn?.addEventListener("click", toggleMenu);
backdrop?.addEventListener("click", toggleMenu);

function addToCart(event) {
  event.preventDefault();

  // Bloqueamos el botón para evitar doble click
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
