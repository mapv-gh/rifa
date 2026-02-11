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

function showToast(mensaje, tipo = "success") {
  let container = document.getElementById("toast-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "toast-container";
    container.className =
      "fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none";
    document.body.appendChild(container);
  }

  const esExito = tipo === "success";
  const borde = esExito ? "border-yellow-400" : "border-red-500";
  const iconoColor = esExito ? "text-yellow-400" : "text-red-500";
  const titulo = esExito ? "¡Éxito!" : "Error";

  const svgIcon = esExito
    ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
    : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

  const toast = document.createElement("div");
  // Nota: translate-x-[120%] y opacity-0 son vitales para que la animación de entrada funcione
  toast.className = `pointer-events-auto flex items-center gap-3 w-max max-w-sm bg-slate-900 border ${borde} text-white px-5 py-4 rounded-xl shadow-2xl transition-all duration-500 translate-x-[120%] opacity-0`;

  toast.innerHTML = `
        <div class="${iconoColor}">${svgIcon}</div>
        <div>
            <h4 class="font-bold text-sm uppercase tracking-wide">${titulo}</h4>
            <p class="text-xs text-slate-300">${mensaje}</p>
        </div>
    `;

  container.appendChild(toast);

  // 4. Activar animación (Entrada)
  setTimeout(() => {
    toast.classList.remove("translate-x-[120%]", "opacity-0");
  }, 100);

  // 5. Eliminar (Salida)
  setTimeout(() => {
    toast.classList.add("translate-x-[120%]", "opacity-0");
    setTimeout(() => toast.remove(), 500);
  }, 3000);
}

function addToCart(event) {
  event.preventDefault();
  const formData = new FormData(event.target);

  fetch(`${BASE_PATH}provider/add_to_cart.php`, {
    method: "POST",
    body: formData,
  })
    .then((r) => r.json())
    .then((data) => {
      if (data.status === "success") {
        showToast("Producto agregado correctamente", "success");
      }
    })
    .catch((e) => {
      console.error(e);
      showToast("Error de conexión", "error");
    });
}
