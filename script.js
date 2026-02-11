// Opción más robusta para rutas (o mantén la tuya si estás seguro de la estructura)
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
  const formData = new FormData(event.target);

  const submitBtn = event.target.querySelector('button[type="submit"]');
  if (submitBtn) submitBtn.disabled = true;

  fetch(`${BASE_PATH}provider/add_to_cart.php`, {
    method: "POST",
    body: formData,
  })
    .then((r) => {
      if (!r.ok) throw new Error("Error HTTP");
      return r.json();
    })
    .then((data) => {
      if (data.status === "success") {
        showToast(data.message || "Producto agregado correctamente", "success");
      } else {
        // AHORA SI mostramos el error del backend
        showToast(data.message || "No se pudo agregar", "error");
      }
    })
    .catch((e) => {
      console.error(e);
      showToast("Error de conexión con el servidor", "error");
    })
    .finally(() => {
      if (submitBtn) submitBtn.disabled = false;
    });
}

window.addToCart = addToCart;
