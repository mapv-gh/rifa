<section class="container mx-auto px-4 mt-12 mb-12">
        <div class="relative bg-slate-900 rounded-[2.5rem] border border-white/10 overflow-hidden px-6 py-12 md:px-12 md:py-16 group">
            
            <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('assets/images/util/pattern.png')]"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="text-center lg:text-left order-2 lg:order-1">
                    <p class="text-yellow-300 text-xs md:text-sm font-bold uppercase tracking-[0.3em] mb-4 flex items-center justify-center lg:justify-start gap-2">
                        <span class="animate-pulse">⏳</span> Sorteo en Vivo
                    </p>
                    
                    <h2 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter text-white mb-6 leading-none">
                        Gran Rifa <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-400 to-white">Monumental</span>
                    </h2>
                    
                    <p class="text-slate-300 mb-8 max-w-md mx-auto lg:mx-0 font-medium">
                        Participa por esta espectacular camioneta 0KM. Todo lo recaudado irá en beneficio de las series juveniles del club.
                    </p>
    
                    <div id="countdown" class="flex flex-wrap justify-center lg:justify-start gap-3 md:gap-4 mb-8">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-black/40 border border-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                                <span id="dias" class="text-2xl font-black text-white">00</span>
                            </div>
                            <span class="text-slate-500 text-[10px] uppercase font-bold mt-2">Días</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-black/40 border border-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                                <span id="horas" class="text-2xl font-black text-white">00</span>
                            </div>
                            <span class="text-slate-500 text-[10px] uppercase font-bold mt-2">Hrs</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-black/40 border border-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                                <span id="minutos" class="text-2xl font-black text-white">00</span>
                            </div>
                            <span class="text-slate-500 text-[10px] uppercase font-bold mt-2">Min</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-yellow-400 border border-yellow-300 rounded-2xl flex items-center justify-center text-black shadow-[0_0_20px_rgba(250,204,21,0.4)]">
                                <span id="segundos" class="text-2xl font-black">00</span>
                            </div>
                            <span class="text-yellow-300 text-[10px] uppercase font-bold mt-2">Seg</span>
                        </div>
                    </div>
    
                    <div class="flex flex-col lg:flex-row items-center gap-4">
                        <a href="#comprar-rifa" class="w-full lg:w-auto bg-white text-black hover:bg-yellow-400 font-black uppercase text-sm px-10 py-4 rounded-xl transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:-translate-y-1 flex items-center justify-center gap-2 group-hover:shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                            <span>Comprar Números</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                        </a>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                            * Valor ticket: $1.000
                        </p>
                    </div>
                </div>
    
                <div class="relative order-1 lg:order-2 flex justify-center items-center">
                    
                    <div class="absolute w-[120%] h-[120%] bg-gradient-to-tr from-yellow-400/20 to-transparent blur-[60px] rounded-full pointer-events-none"></div>
                    
                    <img src="./assets/images/util/auto.png" 
                         alt="Premio Camioneta" 
                         class="relative w-full max-w-md lg:max-w-full object-contain drop-shadow-2xl transition-transform duration-700 hover:scale-105 z-10">
                    
                    <div class="absolute -top-6 right-0 lg:-right-4 bg-red-600 text-white font-black text-xl italic px-4 py-2 rounded-xl -rotate-6 shadow-lg border-2 border-white z-20 animate-bounce">
                        ¡0 KM!
                    </div>
                </div>
    
            </div>
        </div>
    </section>