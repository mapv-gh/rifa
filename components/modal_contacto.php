<div id="myModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-pink-300 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="bg-pink-600 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-pink-600 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start bg-pink-600">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-white">
                            Datos
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-white">
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium cumque ad ipsa qui tenetur, dolores reiciendis vero porro, est quibusdam modi similique aliquid, deserunt itaque. Quibusdam possimus architecto ad pariatur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-pink-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-white text-base font-medium text-black sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function openModal() {
        document.getElementById('myModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');
    }
</script>